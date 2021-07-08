<template>
  <div>
    <div
      class="modal fade invoiceModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container">
              <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                  <div class="card p-4">
                    <div class="d-flex flex-row align-items-center">
                      <img :src="appLogo" class="" width="70" height="70" />
                      <div class="d-flex flex-column">
                        <span class="font-weight-bold">{{ appName }}</span>
                        <small>#-{{ orderObject.id }}</small>
                      </div>
                    </div>
                    <hr />
                    <div class="table-responsive p-4">
                      <table class="table table-borderless">
                        <tbody>
                          <tr class="add">
                            <td>{{ translate("admin.to") }}</td>
                            <td>{{ translate("admin.from") }}</td>
                          </tr>
                          <tr class="content">
                            <td class="font-weight-bold">
                              <p v-if="orderObject.user">
                                {{ orderObject.user.name }}
                              </p>
                              <br />{{ orderObject.email }}<br />{{
                                orderObject.address_line +
                                " . " +
                                orderObject.address_details
                              }}
                            </td>
                            <td class="font-weight-bold">
                              {{ appName }} <br />
                             {{appUrl}}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <hr />
                    <div class="products p-2">
                      <table class="table table-borderless">
                        <tbody>
                          <tr class="add">
                            <th>{{ translate("admin.menu") }}</th>
                            <th>{{ translate("admin.extras") }}</th>
                            <th>{{ translate("admin.quantity") }}</th>
                            <th class="text-center">Total</th>
                          </tr>
                          <tr
                            class="content"
                            v-for="meal in orderObject.meals"
                            :key="meal.id"
                          >
                            <td>{{ meal.title }}</td>
                            <td
                              style="white-space: pre-wrap"
                              v-html="meal.pivot.user_selected_options"
                            ></td>
                            <td>{{ meal.pivot.qty }}</td>
                            <td class="text-center">
                              {{ meal.pivot.meal_subtotal }} dhs
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <hr />
                    <div class="products p-2">
                      <table class="table table-borderless">
                        <tbody>
                          <tr class="add">
                            <td></td>
                            <td>{{ translate("admin.subtotal") }}</td>
                            <td>{{ translate("admin.tax") }}</td>
                            <td>{{ translate("front.delivery") }}</td>
                            <td class="text-center">Total</td>
                          </tr>
                          <tr class="content">
                            <td></td>
                            <td>{{ orderObject.subtotal }} dhs</td>
                            <td>{{ orderObject.tax_price }} dhs</td>
                            <td>{{ orderObject.delivery_price }} dhs</td>
                            <td class="text-center">
                              {{ orderObject.total }} dhs
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <hr />
                    <div class="address p-2">
                      <table class="table table-borderless">
                        <tbody>
                          <tr class="add">
                            <td>{{ translate("admin.paymentDetails") }}</td>
                          </tr>
                          <tr class="content">
                            <td>
                              {{ translate("admin.paymentMode") }} :
                              {{ orderObject.payment_mode }}
                              <p v-if="orderObject.name_on_card">
                                {{ translate("admin.nameOnCard") }}:
                                {{ orderObject.name_on_card }}
                              </p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer d-print-none">
            <button type="button" @click="print" class="btn btn-danger">
              <i class="fa fa-print mr-1"></i> {{ translate("admin.print") }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["order"],
  data() {
    return {
      appName: this.$store.state.appName,
      appLogo: this.$store.state.appLogo,
      appUrl : this.$store.state.appUrl,
    };
  },
  watch: {
    order(newVal) {
      this.$store.commit("orders/setOrder", newVal);
    },
  },
  computed: {
    ...mapGetters("orders", ["orderObject"]),
  },
  methods: {
    print() {
      window.print();
    },
  },
};
</script>

<style>
@media print {
  .modal-dialog {
    max-width: 100%;
    width: 100%;
  }
}
</style>
