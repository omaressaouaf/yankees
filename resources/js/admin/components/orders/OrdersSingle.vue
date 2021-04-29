<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">{{ translate("admin.orders") }}</li>
    </the-breadcrumb>
    <orders-single-skeleton v-if="getIsLoading" />
    <div v-else class="d-print-none">
      <orders-invoice />
      <address-directions
        :end-address-line="orderObject.address_line"
        :end-address-details="orderObject.address_details"
      />

      <div class="row mb-0 py-0">
        <div class="col-md-12 d-flex flex-wrap">
          <button
            class="btn btn-danger mr-2"
            data-toggle="modal"
            data-target=".invoiceModal"
          >
            <i class="fa fa-print mr-1"></i> {{ translate("admin.invoice") }}
          </button>
          <button
            class="btn btn-info"
            data-toggle="modal"
            data-target="#addressDirectionsModal"
          >
            <i class="fa fa-location-arrow mr-1"></i>
            Directions
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="card mt-4">
            <div class="card-body">
              <div class="d-flex flex-wrap align-items-center">
                <h4>
                  {{ translate("admin.orderDetails") }}
                </h4>
                <div class="mr-2 ml-auto">
                  <multiselect
                    v-if="
                      $gate.can('update-order', orderObject) &&
                      $gate.can('manage')
                    "
                    :options="allDeliverymen"
                    :value="orderObject.deliveryman"
                    @select="handleDeliverymanSelect"
                    @remove="handleDeliverymanRemove"
                    :searchable="true"
                    :placeholder="translate('admin.deliveryman')"
                    :loading="deliverymenIsLoading"
                    track-by="id"
                    label="name"
                    :show-labels="false"
                  >
                    <template slot="option" slot-scope="props">
                      <div class="option__desc">
                        <span class="option__title">{{
                          props.option.name
                        }}</span>
                        <br />
                        <span class="option__small small">{{
                          props.option.email
                        }}</span>
                      </div>
                    </template>
                  </multiselect>
                </div>
                <div style="max-width: 170px">
                  <multiselect
                    v-if="$gate.can('update-order', orderObject)"
                    :options="availableStatuses"
                    :value="orderObject.status"
                    @select="handleStatusSelect"
                    :allowEmpty="false"
                    :preserve-search="true"
                    :placeholder="translate('admin.status')"
                    :custom-label="customMultiselectLabel"
                    :show-labels="false"
                    :loading="statusIsLoading"
                  >
                    <template slot="option" slot-scope="props">
                      <div class="option__desc">
                        <span class="option__title">{{
                          translate("admin." + props.option)
                        }}</span>
                      </div>
                    </template>
                  </multiselect>
                </div>
              </div>
              <hr />
              <div>
                <span
                  style="opacity: 0.8"
                  class="p-2 badge float-right"
                  :class="bindStatusClass(orderObject.status, 'badge')"
                >
                  <i
                    class="fa"
                    :class="bindStatusClass(orderObject.status, 'icon')"
                  ></i>
                  {{ translate("admin." + orderObject.status) }}
                </span>

                <p class="text-muted mb-0">
                  {{ translate("admin.order") }} ID : {{ orderObject.id }}
                </p>
                <p class="text-muted mb-0 text-capitalize">
                  {{ translate("admin.paymentMode") }} :
                  {{ orderObject.payment_mode }}
                </p>
                <p
                  class="text-muted mb-0 text-capitalize"
                  v-if="orderObject.deliveryman"
                >
                  {{ translate("admin.deliveryman") }} :
                  <component
                    :is="$gate.can('manage') ? 'router-link' : 'div'"
                    :to="{
                      name: 'users.edit',
                      params: { id: orderObject.deliveryman.id },
                    }"
                  >
                    <u>
                      {{ orderObject.deliveryman.name }}
                      <span class="small mr-2">{{
                        orderObject.deliveryman.email
                      }}</span>
                    </u>
                  </component>
                </p>

                <div v-if="orderObject.payment_mode == 'stripe'">
                  <p class="h6 mt-3">{{ translate("admin.onlinePayment") }}</p>

                  <p class="text-muted mb-0 pb-0">
                    {{ translate("admin.nameOnCard") }} :
                    {{ orderObject.name_on_card }}
                  </p>
                  <p class="text-muted mb-0 pb-0">
                    {{ translate("admin.userCharged") }} :
                    <i
                      class="fa"
                      :class="[
                        orderObject.user_charged
                          ? 'fa-check text-success'
                          : 'fa-times text-danger',
                      ]"
                    ></i>
                  </p>
                  <p class="text-muted mb-0 pb-0">
                    {{ translate("admin.userRefunded") }} :
                    <i
                      class="fa"
                      :class="[
                        orderObject.user_refunded
                          ? 'fa-check text-success'
                          : 'fa-times text-danger',
                      ]"
                    ></i>
                  </p>
                  <p
                    class="text-muted mb-0 pb-0"
                    v-if="orderObject.payment_confirmation_required"
                  >
                    {{ translate("admin.paymentConfirmationRequired") }} :
                    <i class="fa fa-check text-success"></i>
                  </p>
                </div>
              </div>
              <hr />
              <div
                class="row mb-3"
                v-for="meal in orderObject.meals"
                :key="meal.id"
              >
                <div class="col-md-3">
                  <img :src="meal.resizedImage" class="img-fluid" alt="" />
                </div>
                <div class="col-md-5">
                  <h4 class="mb-0 pb-0" :class="{ 'text-danger': !meal.id }">
                    <component
                      :is="
                        meal.id && $gate.can('manage') ? 'router-link' : 'div'
                      "
                      :to="{ name: 'meals.edit', params: { id: meal.id } }"
                    >
                      <i v-if="!meal.id" class="fa fa-info-circle"></i>
                      {{ meal.title }}
                    </component>
                  </h4>

                  <p
                    class="text-muted"
                    style="white-space: pre-wrap"
                    v-html="meal.pivot.user_selected_options"
                  ></p>
                </div>

                <div class="col-md-2">
                  <p>{{ meal.pivot.qty }}X</p>
                </div>
                <div class="col-md-2 font-weight-bold">
                  <p>{{ meal.pivot.meal_subtotal }} dhs</p>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-md-5 offset-md-7">
                  <p>
                    <span class="font-weight-bold">{{
                      translate("admin.subtotal")
                    }}</span>
                    <span class="float-right"
                      >{{ orderObject.subtotal }} dhs</span
                    >
                  </p>
                  <p class="">
                    <span class="font-weight-bold">{{
                      translate("front.delivery")
                    }}</span>
                    <span class="float-right"
                      >{{ orderObject.delivery_price }} dhs</span
                    >
                  </p>
                  <p class="text-danger">
                    <span class="font-weight-bold">{{
                      translate("admin.tax")
                    }}</span>
                    <span class="float-right"
                      >{{ orderObject.tax_price }} dhs</span
                    >
                  </p>
                  <hr />
                  <p class="text-success">
                    <span class="font-weight-bold">Total</span>
                    <span class="float-right">{{ orderObject.total }} dhs</span>
                  </p>
                  <div v-if="$gate.can('manage')">
                    <button
                      class="btn btn-success btn-block"
                      v-if="$gate.can('charge', orderObject)"
                      @click="chargeUser"
                      :disabled="chargeIsLoading"
                    >
                      <i
                        class="fa fa-circle-notch fa-spin mr-1"
                        v-if="chargeIsLoading"
                      ></i>
                      <i class="material-icons mr-1" v-else>credit_score</i>
                      {{ translate("admin.charge") }}
                      {{ orderObject.total }} dhs
                    </button>
                    <button
                      class="btn btn-danger btn-block"
                      @click="handleRefund"
                      v-if="$gate.can('refund', orderObject)"
                      :disabled="refundIsLoading"
                    >
                      <i
                        class="fa fa-circle-notch fa-spin mr-1"
                        v-if="refundIsLoading"
                      ></i>
                      <i class="material-icons mr-1" v-else>credit_score</i>
                      {{ translate("admin.refund") }}
                      {{ orderObject.total }} dhs
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mt-4">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <h4>Client</h4>
              </div>
              <hr />
              <div v-if="orderObject.user">
                <div class="d-flex">
                  <img
                    style="border-radius: 50%"
                    class="img-fluid mr-2"
                    width="70"
                    height="50"
                    src="/storage/images/design/avatarplaceholder.png"
                    alt=""
                  />
                  <div>
                    <u class="mb-0 text-dark">
                      <component
                        :is="$gate.can('manage') ? 'router-link' : 'div'"
                        :to="{
                          name: 'users.edit',
                          params: { id: orderObject.user.id },
                        }"
                      >
                        {{ orderObject.user.name }}
                      </component>
                    </u>
                    <p class="text-muted">ID : {{ orderObject.user.id }}</p>
                  </div>
                </div>
              </div>
              <div v-else>
                <p class="text-danger">
                  <i class="fa fa-info-circle"></i>
                  {{ translate("admin.noUserForOrder") }}
                </p>
              </div>
              <hr />
              <h5>Contact</h5>
              <p><i class="fa fa-envelope mr-1"></i> {{ orderObject.email }}</p>
              <p><i class="fa fa-phone mr-1"></i> {{ orderObject.phone }}</p>
              <p>
                <i class="fa fa-map-marker-alt mr-1"></i>
                {{ orderObject.address_line }} <br />
                {{ orderObject.address_details }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { mapGetters, mapActions } from "vuex";
import { orderStatusMixin } from "../../mixins";
import OrdersSingleSkeleton from "./OrdersSingleSkeleton.vue";
import OrdersInvoice from "./OrdersInvoice.vue";
import "vue-multiselect/dist/vue-multiselect.min.css";
import { fireAlert, fireConfirm } from "../../helpers";
import AddressDirections from "../addresses/AddressDirections.vue";

export default {
  components: { OrdersSingleSkeleton, OrdersInvoice, AddressDirections },
  mixins: [orderStatusMixin],
  data() {
    return {
      form: {},
    };
  },

  watch: {
    orderObject() {
      this.form = { ...this.orderObject };
    },
  },
  computed: {
    availableStatuses() {
      if (this.$gate.can("manage")) {
        return this.statuses.filter((status) => status != "failed");
      }
      return ["delivered"];
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    statusIsLoading() {
      return this.isLoading["status"];
    },
    deliverymenIsLoading() {
      return this.isLoading["deliverymen"];
    },
    chargeIsLoading() {
      return this.isLoading["charge"];
    },
    refundIsLoading() {
      return this.isLoading["refund"];
    },
    ...mapGetters("orders", [
      "orderObject",
      "allDeliverymen",
      "isLoading",
      "serverErrors",
    ]),
  },
  methods: {
    handleRefund() {
      fireConfirm(() => {
        this.refundUser(this.orderObject);
      });
    },
    handleDeliverymanRemove() {
      if (
        this.orderObject.status == "out_for_delivery" ||
        this.orderObject.status == "delivered"
      ) {
        fireAlert(
          "error",
          "Validation",
          translate("admin.deliverymanRequired")
        );
        return;
      }
      this.updateOrder({
        id: this.orderObject.id,
        deliveryman_id: null,
        status: this.orderObject.status,
        loading: "deliverymen",
      });
    },
    handleDeliverymanSelect(selectedOption) {
      this.updateOrder({
        id: this.orderObject.id,
        deliveryman_id: selectedOption.id,
        status: this.orderObject.status,
        loading: "deliverymen",
      });
    },
    handleStatusSelect(selectedOption) {
      if (
        !this.orderObject.deliveryman_id &&
        (selectedOption == "out_for_delivery" || selectedOption == "delivered")
      ) {
        fireAlert(
          "error",
          "Validation",
          translate("admin.deliverymanRequired")
        );
        return;
      }
      const updatedOrder = {
        id: this.orderObject.id,
        status: selectedOption,
        deliveryman_id: this.orderObject.deliveryman_id,
        loading: "status",
      };
      if (selectedOption == "cancelled") {
        fireConfirm(() => {
          this.updateOrder(updatedOrder);
        });
        return;
      }
      this.updateOrder(updatedOrder);
    },

    ...mapActions("orders", [
      "fetchOrder",
      "fetchDeliverymen",
      "updateOrder",
      "chargeUser",
      "refundUser",
    ]),
  },

  mounted() {
    this.$store.commit("orders/clearOrder");
    this.$store.commit("orders/clearServerErrors");
    if (this.$gate.can("manage")) {
      this.fetchDeliverymen();
    }
    this.fetchOrder(this.$route.params.id);
  },
};
</script>

<style scoped>
a {
  color: rgb(13, 82, 139) !important;
}
a:hover {
  text-decoration: underline;
}
</style>
