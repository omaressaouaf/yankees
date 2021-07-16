<template>
  <div class="container padding-bottom-3x mb-1">
    <div class="card mb-3">
      <div class="p-4 text-center text-white text-lg rounded-top" style="background-color : #141515">
        <span>{{ translate("admin.order") }} #</span
        ><span class="text-medium">{{ order.id }}</span>
      </div>
      <div
        class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary"
      >
        <div class="w-100 text-center py-1 px-2">
          <span class="text-medium">{{ translate("admin.paymentMode") }}:</span>
          {{ order.payment_mode == "stripe" ? "Credit Card" : "Cash" }}
        </div>
        <div class="w-100 text-center py-1 px-2">
          <span class="text-medium">{{ translate("admin.status") }}:</span>
          {{ translate("admin." + order.status) }}
        </div>
        <div class="w-100 text-center py-1 px-2">
          <span class="text-medium"> {{ translate("admin.passedAt") }}:</span>
           {{order.created_at | formatDate}}
        </div>
      </div>
      <div class="card-body">
        <div
          class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x"
        >
          <div
            class="step"
            :class="{ completed: determineCompleted(status) }"
            v-for="(status, index) in statuses"
            :key="index"
          >
            <div class="step-icon-wrap">
              <div class="step-icon"><i :class="status.icon"></i></div>
            </div>
            <h4 class="step-title">{{ translate("admin." + status.name) }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div
      class="d-flex flex-wrap  justify-content-between align-items-center"
    >

        <button


          class="btn btn-outline-danger btn-rounded btn-sm"
          @click="cancelOrder"
          data-toggle="modal"
          data-target="#orderDetails"
          :disabled="loading || !$gate.can('cancel_order', order)"
        >
          <i class="fa fa-spinner fa-spin" v-if="loading"></i>
          <i class="fa fa-times" v-else></i>
          {{ translate("admin.cancelOrder") }}
        </button>
      <p class="text-info mt-2 small">
        <i class="fa fa-info-circle"></i>
        {{ translate("admin.cancelOrderGuide") }}
      </p>

    </div>
  </div>
</template>

<script>
import axios from "axios";
import { fireToast } from "../../admin/helpers";
export default {
  props: ["trackedOrder"],
  data() {
    return {
      deliveryTime: window.deliveryTime,
      loading: false,
      order: { ...this.trackedOrder },
      statuses: [
        {
          name: "pending",
          icon: "fa fa-clock",
          perc: 20,
        },
        {
          name: "processing",
          icon: "fa fa-cog",
          perc: 50,
        },
        {
          name: "out_for_delivery",
          icon: "fa fa-truck",
          perc: 80,
        },
        {
          name: "delivered",
          icon: "fa fa-home",
          perc: 100,
        },
      ],
    };
  },
  computed: {
    determineCompleted() {
      return (status) => {
        const orderStatus = this.statuses.find(
          (status) => status.name == this.order.status
        );
        return status.perc <= orderStatus.perc;
      };
    },
  },
  methods: {
    cancelOrder() {
      this.loading = true;
      axios
        .put(`/account/orders/${this.order.id}/cancel`)
        .then((res) => {
          fireToast("success", translate("admin.cancelledSuccessfully"));
          setTimeout(() => {
            window.location.href = "/account/orders";
          }, 2000);
        })
        .catch((err) => {
          fireToast("danger", translate("front.errorMessage"));
          this.loading = false;
        });
    },
  },
  created() {
    Echo.private(`orders.${this.order.id}`).listen(
      "OrderStatusChanged",
      (e) => {
        this.order.status = e.order.status;
      }
    );
  },
};
</script>

<style scoped>
.steps .step {
  display: block;
  width: 100%;
  margin-bottom: 35px;
  text-align: center;
}

.steps .step .step-icon-wrap {
  display: block;
  position: relative;
  width: 100%;
  height: 80px;
  text-align: center;
}

.steps .step .step-icon-wrap::before,
.steps .step .step-icon-wrap::after {
  display: block;
  position: absolute;
  top: 50%;
  width: 50%;
  height: 3px;
  margin-top: -1px;
  background-color: #e1e7ec;
  content: "";
  z-index: 1;
}

.steps .step .step-icon-wrap::before {
  left: 0;
}

.steps .step .step-icon-wrap::after {
  right: 0;
}

.steps .step .step-icon {
  display: inline-block;
  position: relative;
  width: 50px;
  height: 50px;
  border: 1px solid #e1e7ec;
  border-radius: 50%;
  background-color: #f5f5f5;
  color: #374250;
  font-size: 20px;
  line-height: 50px;
  z-index: 5;
}

.steps .step .step-title {
  margin-top: 16px;
  margin-bottom: 0;
  color: #606975;
  font-size: 14px;
  font-weight: 500;
}

.steps .step:first-child .step-icon-wrap::before {
  display: none;
}

.steps .step:last-child .step-icon-wrap::after {
  display: none;
}

.steps .step.completed .step-icon-wrap::before,
.steps .step.completed .step-icon-wrap::after {
  background-color: #0da9ef;
}

.steps .step.completed .step-icon {
  background-color: #0da9ef;
  color: #fff;
}

@media (max-width: 576px) {
  .flex-sm-nowrap .step .step-icon-wrap::before,
  .flex-sm-nowrap .step .step-icon-wrap::after {
    display: none;
  }
}

@media (max-width: 768px) {
  .flex-md-nowrap .step .step-icon-wrap::before,
  .flex-md-nowrap .step .step-icon-wrap::after {
    display: none;
  }
}

@media (max-width: 991px) {
  .flex-lg-nowrap .step .step-icon-wrap::before,
  .flex-lg-nowrap .step .step-icon-wrap::after {
    display: none;
  }
}

@media (max-width: 1200px) {
  .flex-xl-nowrap .step .step-icon-wrap::before,
  .flex-xl-nowrap .step .step-icon-wrap::after {
    display: none;
  }
}

.bg-faded,
.bg-secondary {
  background-color: #f5f5f5 !important;
}
</style>
