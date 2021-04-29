<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">{{ translate("admin.orders") }}</li>
    </the-breadcrumb>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="d-flex flex-wrap">
            <div
              class="card-header card-header-icon card-header-warning"
              style="flex-grow: 1 !important"
            >
              <div class="card-icon card-icon-custom">
                <i class="material-icons">shopping_bag</i>
              </div>
              <h4 class="card-title">
                {{ translate("admin.orders") + " Table" }}
              </h4>
            </div>
            <form class="d-flex" v-if="!getIsLoading">
              <div class="form-group mt-2 mr-2 ml-2">
                <multiselect
                  :options="statuses"
                  v-model="selectedStatuses"
                  :multiple="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :preserve-search="true"
                  :placeholder="
                    translate('admin.filterBy') +
                    ' ' +
                    translate('admin.status')
                  "
                  :custom-label="customMultiselectLabel"
                  :show-labels="false"
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
            </form>
            <div class="mt-1">
              <!-- <button class="btn btn-info" @click="fetchOrders"><i class="fa fa-sync-alt mr-1"></i> Actualiser </button> -->
              <button
                class="btn btn-danger mr-2 ml-2"
                @click="prepareBulkDeleteOrders"
                :disabled="postIsLoading"
                v-if="$gate.can('manage')"
              >
                <span>
                  <i
                    v-if="postIsLoading"
                    class="fa fa-circle-notch fa-spin"
                  ></i>
                  <i v-else class="fa fa-dumpster"></i>
                  {{ translate("admin.delete") }}
                </span>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive d-print-none">
              <table class="table  " id="dataTable">
                <thead>
                  <tr>
                    <th v-if="!getIsLoading">
                      <input
                        type="checkbox"
                        v-model="allSelected"
                        @click="selectOrUnSelectAll"
                      />
                    </th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>{{ translate("admin.phone") }}</th>
                    <th>{{ translate("admin.address") }}</th>
                    <th>Total</th>
                    <th>{{ translate("admin.status") }}</th>
                    <th>{{ translate("admin.paymentMode") }}</th>
                    <th>{{ translate("admin.passedAt") }}</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="getIsLoading">
                    <td colspan="9" class="text-center">
                      <loading
                        loader="dots"
                        color="#2B51C4"
                        :active.sync="getIsLoading"
                        :is-full-page="false"
                        :width="80"
                        :height="200"
                      />
                    </td>
                  </tr>
                  <tr  :class="{'light-orange' : order.status == 'pending'}" v-for="order in filteredOrders" :key="order.id" v-else>
                    <td>
                      <input
                        type="checkbox"
                        v-model="selectedItems"
                        :value="order.id"
                      />
                    </td>
                    <td>{{ order.id }}</td>
                    <td>{{ order.email }}</td>
                    <td>
                      <h6 style="opacity: 0.8">
                        {{ order.phone }}
                      </h6>
                    </td>
                    <td>
                      {{ order.address_line }} . <br />
                      {{ order.address_details }}
                    </td>
                    <td class="">{{ order.total }} dhs</td>
                    <td>
                      <h6>
                        <span
                          style="opacity: 0.8"
                          class="p-2 badge"
                          :class="bindStatusClass(order.status, 'badge')"
                        >
                          <i
                            class="fa"
                            :class="bindStatusClass(order.status, 'icon')"
                          ></i>
                          {{ translate("admin." + order.status) }}
                        </span>
                      </h6>
                    </td>
                    <td>
                      <h4 class="text-capitalize">{{ order.payment_mode }}</h4>
                    </td>
                    <td>{{ order.created_at | formatDate }}</td>
                    <td style="width: 15%">
                      <router-link
                        :to="{ name: 'orders.show', params: { id: order.id } }"
                        ><i class="fa fa-info-circle text-success mr-3"></i>
                      </router-link>
                      <a
                        href="#"
                        data-toggle="modal"
                        data-target="#addressDirectionsModal"
                        @click="clickedOrder = order"
                        ><i class="fa fa-location-arrow text-info mr-3"></i>
                      </a>
                      <a
                        href="#"
                        data-toggle="modal"
                        data-target=".invoiceModal"
                        @click="clickedOrder = order"
                        ><i class="fa fa-print text-secondary mr-3"></i>
                      </a>

                      <a href="#" v-if="$gate.can('manage')" @click.prevent="deleteOrder(order.id)"
                        ><i class="fa fa-trash text-danger"></i
                      ></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
              <orders-invoice :order="clickedOrder" />
              <address-directions
                :end-address-line="clickedOrder.address_line"
                :end-address-details="clickedOrder.address_details"
              />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { dataTableMixin, orderStatusMixin } from "../../mixins";
import { mapGetters, mapActions } from "vuex";
import { fireConfirm } from "../../helpers";
import "vue-multiselect/dist/vue-multiselect.min.css";
import OrdersInvoice from "./OrdersInvoice.vue";
import AddressDirections from "../addresses/AddressDirections.vue";
export default {
  components: { OrdersInvoice, AddressDirections },
  mixins: [dataTableMixin, orderStatusMixin],
  data() {
    return {
      selectedItems: [],
      allSelected: false,
      selectedStatuses: [],
      clickedOrder: {},
    };
  },
  watch: {
    selectedItems() {
      this.allSelected =
        this.selectedItems.length === this.filteredOrders.length ? true : false;
    },
  },
  computed: {
    filteredOrders() {
      if (!this.selectedStatuses.length) {
        return this.allOrders;
      }
      const filtered = this.allOrders.filter((order) => {
        return this.selectedStatuses.includes(order.status);
      });
      return filtered;
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },

    ...mapGetters("orders", ["allOrders", "isLoading"]),
  },
  methods: {
    selectOrUnSelectAll() {
      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.filteredOrders.forEach((order) => {
          this.selectedItems.push(order.id);
        });
      }
    },
    prepareBulkDeleteOrders() {
      if (!this.selectedItems.length) {
        return;
      }
      fireConfirm(async () => {
        await this.bulkDeleteOrders(this.selectedItems);
        this.selectedItems = [];
      });
    },
    ...mapActions("orders", ["fetchOrders", "deleteOrder", "bulkDeleteOrders"]),
  },

  created() {
    this.fetchOrders();
  },
};
</script>

<style scoped>

.light-orange  {
  background-color:  rgb(252, 246, 233);
}
</style>
