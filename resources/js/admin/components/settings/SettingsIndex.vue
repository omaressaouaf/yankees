<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">
        {{ translate("admin.settings") }}
      </li>
    </the-breadcrumb>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-nav-tabs">
          <div
            class="card-header card-header-"
            style="background-color: black !important; opacity: 0.83"
          >
            <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
            <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                <ul class="nav nav-tabs" data-tabs="tabs">
                  <li class="nav-item">
                    <a
                      class="nav-link active show"
                      href="#application"
                      data-toggle="tab"
                    >
                      <i class="material-icons">admin_panel_settings</i>
                      Application
                      <div class="ripple-container"></div
                    ></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#schedule" data-toggle="tab">
                      <i class="material-icons">event_available</i>
                      {{ translate("admin.openingHours") }}
                      <div class="ripple-container"></div
                    ></a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" href="#delivery" data-toggle="tab">
                      <i class="material-icons">delivery_dining</i>
                      {{ translate("front.delivery") }}
                      <div class="ripple-container"></div
                    ></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#cart" data-toggle="tab">
                      <i class="material-icons">shopping_cart</i>
                      {{ translate("admin.cart") }}
                      <div class="ripple-container"></div
                    ></a>
                  </li>
                  <li v-if="$gate.can('manage-fully')" class="nav-item">
                    <a class="nav-link" href="#payment" data-toggle="tab">
                      <i class="material-icons">credit_score</i>
                      {{ translate("admin.payment") }}
                      <div class="ripple-container"></div
                    ></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content" v-if="loading">
              <div class="tab-pane active text-center py-5" id="application">
                <vue-loaders-ball-scale-ripple-multiple
                  color="#2B51C4"
                  scale="1"
                ></vue-loaders-ball-scale-ripple-multiple>
              </div>
            </div>
            <div class="tab-content" v-else>
              <div class="tab-pane active" id="application">
                <app-form :app-settings="settings.app" />
              </div>
              <div class="tab-pane" id="schedule">
                <schedule-form :schedule-settings="settings.schedule" />
              </div>
              <div class="tab-pane" id="delivery">
                <delivery-form :delivery-settings="settings.delivery" />
              </div>
              <div class="tab-pane" id="cart">
                <cart-form :cart-settings="settings.cart" />
              </div>
              <div v-if="$gate.can('manage-fully')" class="tab-pane" id="payment">
                <payment-form :payment-settings="settings.payment" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppForm from "./AppForm.vue";
import DeliveryForm from "./DeliveryForm.vue";
import CartForm from "./CartForm.vue";
import ScheduleForm from "./ScheduleForm.vue";
import PaymentForm from "./PaymentForm.vue";

export default {
  components: { AppForm, DeliveryForm, CartForm, ScheduleForm , PaymentForm },
  data() {
    return {
      settings: [],
      loading: false,
    };
  },
  methods: {
    fetchSettings() {
      this.loading = true;
      axios
        .get("/api/settings")
        .then((res) => {
          this.settings = res.data.settings;
          this.$store.commit("setAppName", this.settings.app.name);
        })
        .catch((err) => {
          fireToast("danger", translate("front.errorMessage"));
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
  mounted() {
    this.fetchSettings();
  },
};
</script>

<style>
</style>
