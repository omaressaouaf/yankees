<template>
  <form
    class="needs-validation mt-4"
    id="checkout-form"
    @submit.prevent="handleSubmit"
  >
    <server-error-alert v-if="serverErrors" :server-errors="serverErrors" />
    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="firstName">{{ translate("admin.name") }}</label>
        <input
          type="text"
          class="form-control"
          :value="authUser.name"
          readonly
        />
      </div>
      <div class="col-md-6 mb-3">
        <label for="lastName">Email</label>
        <input
          type="text"
          class="form-control"
          :value="authUser.email"
          readonly
        />
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 mb-3">
        <label for="firstName">{{ translate("admin.phone") }}</label>
        <input
          type="text"
          class="form-control"
          :value="authUser.phone"
          readonly
        />
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div>
          <label for="country">{{ translate("admin.address") }}</label>
          <select
            v-if="addresses.length"
            v-model="form.address_id"
            required
            class="form-control d-block w-100"
            id="address"
          >
            <option
              :key="address.id"
              v-for="address in addresses"
              :value="address.id"
            >
              {{ address.line }}
            </option>
          </select>
          <br />
          <a
            href="#"
            data-toggle="modal"
            data-target="#addressSelectorModal"
            class="text-primary btn-link"
          >
            <i class="fa fa-plus"></i>
            {{ translate("admin.add") }}</a
          >
          <address-selector
            @addressAdded="addAddress"
            :user-id="authUser.id"
            :apply-front-theme="true"
          >
          </address-selector>
        </div>
      </div>
    </div>

    <hr class="mb-4" />
    <h4 class="mb-3">{{ translate("admin.paymentDetails") }}</h4>
    <div class="d-block mt-4 mb-3 d-flex">
      <label
        v-if="$gate.can('checkout-with-stripe')"
        class="inputcontainer mr-4"
        >Credit Card
        <input
          class="form-check-input"
          v-model="form.paymentMode"
          value="stripe"
          type="radio"
        />
        <span class="radiomark mark"></span>
      </label>
      <label class="inputcontainer"
        >Cash on Delivery
        <input
          class="form-check-input"
          v-model="form.paymentMode"
          value="cash"
          type="radio"
        />
        <span class="radiomark mark"></span>
      </label>
    </div>
    <div v-if="form.paymentMode == 'stripe'">
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="cc-name">{{ translate("admin.nameOnCard") }}</label>
          <input
            type="text"
            required
            class="form-control"
            v-model="form.nameOnCard"
            :placeholder="translate('admin.nameOnCard')"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="card-element">Credit Card</label>
          <div id="card-element" class="form-control">
            <!-- stripe elements will be inserted here -->
          </div>
          <!-- to display errors -->
          <div
            id="card-errors"
            v-if="cardError"
            class="text-danger"
            role="alert"
          >
            {{ cardError }}
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-md-12 mb-3">
        <p class="text-info">
          <i class="fa fa-info-circle"></i>
          {{ translate("admin.cashOnDeliveryText") }}
        </p>
      </div>
    </div>

    <div class="row" v-if="!$gate.can('checkout-with-stripe')">
      <div class="col-md-12 mb-3">
        <p class="text-info">
          <i class="fa fa-info-circle"></i>
          {{ translate("admin.stripeCheckoutNotice") }}
        </p>
      </div>
    </div>

    <button
      id="checkout-btn"
      :disabled="paymentProcessing"
      class="btn-orange btn-square btn-block"
      type="submit"
    >
      <i class="fa fa-spinner fa-spin" v-if="paymentProcessing"></i>
      {{ translate("front.checkout") }}
    </button>
  </form>
</template>

<script>
import axios from "axios";
import ServerErrorAlert from "../../admin/components/partials/ServerErrorAlert.vue";
import { fireToast } from "../../admin/helpers";
export default {
  components: { ServerErrorAlert },
  props: ["clientSecret", "authUser", "authUserAddresses"],
  data() {
    return {
      stripeKey: process.env.MIX_STRIPE_KEY,
      addresses: this.authUserAddresses,
      paymentProcessing: false,
      cardError: null,
      serverErrors: null,
      form: {
        address_id: this.authUserAddresses[0]?.id || null,
        paymentMode: this.$gate.can("checkout-with-stripe") ? "stripe" : "cash",
        nameOnCard: "",
      },
    };
  },
  watch: {
    "form.paymentMode": function (newVal, oldVal) {
      if (newVal == "stripe") {
        this.$nextTick(() => {
          this.cardElement.mount("#card-element");
        });
      }
    },
  },
  methods: {
    addAddress(address) {
      this.addresses.push(address);
      this.form.address_id = address.id;
    },
    async handleSubmit() {
      if (!this.form.address_id) {
        fireToast(
          "danger",
          translate("admin.add") + " " + translate("admin.address")
        );
        return;
      }
      try {
        this.paymentProcessing = true;
        // create a stripe token and set it into the form if the payment method is stripe
        if (this.form.paymentMode == "stripe") {
          // const options = {
          //   name: this.form.nameOnCard,
          //   address_line1: this.addresses.find(
          //     (address) => address.id === this.form.address_id
          //   ).line,
          // };
          const { setupIntent, error } = await this.stripe.confirmCardSetup(
            this.clientSecret,
            {
              payment_method: {
                card: this.cardElement,
                billing_details: { name: this.form.nameOnCard },
              },
            }
          );
          if (error) {
            this.cardError = error.message;
            this.paymentProcessing = false;
            return;
          }
          this.form.paymentMethod = setupIntent.payment_method;
        }
        // then checkout
        const res = await axios.post("/checkout", this.form);
        window.location.href = "/account/orders";
      } catch (err) {
        switch (err.response.status) {
          case 422:
            this.serverErrors = Object.values(err.response.data.errors);
            break;
          case 404:
            this.serverErrors = [["Address Not Found"]];
            break;
          case 400:
            this.serverErrors = err.response.data.message;
            break;
          default:
            this.serverErrors = [["Checkout Failed"]];
        }
        this.paymentProcessing = false;
      }
    },
    initCardElement() {
      this.stripe = Stripe(this.stripeKey);
      const elements = this.stripe.elements();
      const options = {
        hidePostalCode: true,
        style: {
          base: {
            color: "#32325d",
            fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
              color: "#aab7c4",
            },
          },
          invalid: {
            color: "#fa755a",
            iconColor: "#fa755a",
          },
        },
      };
      this.cardElement = elements.create("card", options);
      this.cardElement.mount("#card-element");
      this.cardElement.addEventListener("change", (e) => {
        this.cardError = e.error ? e.error.message : null;
      });
    },
  },
  mounted() {
    if (this.$gate.can("checkout-with-stripe")) {
      this.initCardElement();
    }
  },
};
</script>

<style scoped>
.StripeElement--focus {
  border-color: #cda45e;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px #cda45e;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px #cda45e;
}

.StripeElement--invalid {
  border-color: #fa755a;
}
</style>
