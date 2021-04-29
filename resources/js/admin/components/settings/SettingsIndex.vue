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
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content" v-if="loading">
              <div class="tab-pane active text-center" id="application">
                <loading
                  loader="dots"
                  color="#2B51C4"
                  :active.sync="loading"
                  :is-full-page="false"
                  :width="80"
                  :height="200"
                />
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

export default {
  components: { AppForm, DeliveryForm, CartForm, ScheduleForm },
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
