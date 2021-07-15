<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <server-error-alert :serverErrors="serverErrors" v-if="serverErrors" />
      <form-group :validator="$v.form.stripeEnabled" name="stripeEnabled">
        <label class="ml-5">{{ translate("admin.stripeEnabled") }}</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="material-icons">credit_score</i>
            </span>
          </div>
          <toggle-button
            v-model.trim="$v.form.stripeEnabled.$model"
            :value="$v.form.stripeEnabled.$model"
            :sync="true"
          />
        </div>
      </form-group>
      <form-group :validator="$v.form.stripeKey" name="stripeKey">
        <label class="ml-5">Stripe Key</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="material-icons">vpn_key</i>
            </span>
          </div>
          <input
            type="text"
            @input="$v.form.stripeKey.$touch()"
            class="form-control"
            v-model.trim="$v.form.stripeKey.$model"
          />
        </div>
      </form-group>
      <form-group :validator="$v.form.stripeSecret" name="stripeSecret">
        <label class="ml-5">Stripe Secret</label>
        <div class="input-group">
          <div @click="toggleStripeKeyVisible" class="input-group-prepend">
            <span class="input-group-text">
              <i class="material-icons">lock</i>
            </span>
          </div>
          <input
            :type="stripeKeyVisible ? 'text' : 'password'"
            @input="$v.form.stripeSecret.$touch()"
            class="form-control"
            v-model.trim="$v.form.stripeSecret.$model"
          />
          <div
            @click="toggleStripeKeyVisible"
            class="input-group-prepend toggle-stripe-key-btn"
          >
            <span class="input-group-text">
              <i class="material-icons">{{
                stripeKeyVisible ? "visibility" : "visibility_off"
              }}</i>
            </span>
          </div>
          <br />
        </div>
      </form-group>
      <div
        class="alert alert-warning alert-dismissible fade show mx-5"
        role="alert"
      >
        <i class="fa fa-info-circle text-white"> </i>
        <strong> {{ translate("admin.warning") }}</strong>
        {{ translate("admin.stripeWarning") }}
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <button class="btn btn-warning ml-5" :disabled="loading || !formChanged">
        <i v-if="loading" class="fa fa-circle-notch fa-spin mr-1"></i>
        {{ translate("admin.save") }}
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { required, requiredIf } from "vuelidate/lib/validators";
import { fireToast } from "../../helpers";

export default {
  props: ["paymentSettings"],
  data() {
    return {
      form: this.paymentSettings,
      loading: false,
      formChanged: false,
      stripeKeyVisible: false,
      serverErrors: null,
    };
  },
  validations: {
    form: {
      stripeEnabled: {
        required,
      },
      stripeKey: {
        required: requiredIf(function () {
          return this.form.stripeEnabled === true;
        }),
      },
      stripeSecret: {
        required: requiredIf(function () {
          return this.form.stripeEnabled === true;
        }),
      },
    },
  },
  watch: {
    form: {
      handler() {
        this.formChanged = true;
      },
      deep: true,
    },
  },
  methods: {
    toggleStripeKeyVisible() {
      this.stripeKeyVisible = !this.stripeKeyVisible;
    },
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.loading = true;
        axios
          .post("/settings/payment", this.form)
          .then((res) => {
            fireToast(
              "success",
              translate("admin.updated", { item: translate("admin.settings") })
            );
          })
          .catch((err) => {
            const errorMsg = err.response?.data?.msg;
            if (errorMsg) {
              this.serverErrors = [[errorMsg]];
            }
            fireToast("danger", translate("front.errorMessage"));
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },
  },
};
</script>

<style scoped>
.toggle-stripe-key-btn {
  cursor: pointer;
}
</style>
