<template>
  <div>
    <address-selector
      @addressAdded="addAddress"
      :user-id="userId"
      :apply-front-theme="applyFrontTheme"
    >
    </address-selector>

    <component :is="component" modal-id="addressListModal">
      <button
        v-if="$gate.can('manage-fully') || $gate.user.id === userId"
        :class="[applyFrontTheme ? 'btn-outline-orange' : 'btn btn-warning']"
        data-toggle="modal"
        data-target="#addressSelectorModal"
      >
        <i class="fa fa-plus"></i> {{ translate("front.add") }}
      </button>

      <div v-if="loading" class="text-center mt-4">
        <vue-skeleton-loader
          animation="fade"
          type="rect"
          :rounded="true"
          width="60%"
          height="15px"
        />
        <br />
        <vue-skeleton-loader
          animation="fade"
          type="rect"
          :rounded="true"
          width="100%"
          height="15px"
        />
        <br />
        <vue-skeleton-loader
          animation="fade"
          type="rect"
          :rounded="true"
          width="30%"
          height="15px"
        />
      </div>
      <div v-else>
        <div v-if="!addresses.length">
          <h6 class="lead mt-4 ml-2">
            {{ translate("front.noAddress") }}
          </h6>
        </div>
        <div
          v-for="address in addresses"
          :key="address.id"
          class="d-flex mt-4 p-3 address-box"
        >
          <i
            class="fa fa-location-arrow fa-lg mr-3 mt-2"
            style="opacity: 0.8"
          ></i>
          <div style="flex-basis: 95%">
            <p class="lead">
              {{ address.line }}<br /><span class="text-muted small">{{
                address.details
              }}</span>
            </p>
          </div>
          <a href="#">
            <i
              v-if="$gate.can('manage-fully') || $gate.user.id === userId"
              class="fa fa-trash address-delete-btn"
              @click.prevent="deleteAddress(address.id)"
            ></i>
          </a>
        </div>
      </div>
    </component>
  </div>
</template>

<script>
import { fireAlert, fireConfirm } from "../../helpers";
import nProgress from "nprogress";
import BaseModal from "../partials/BaseModal";
export default {
  props: ["userId", "applyFrontTheme"],
  data() {
    return {
      addresses: [],
      loading: false,
    };
  },
  computed: {
    component() {
      return this.applyFrontTheme ? "div" : BaseModal;
    },
  },
  watch: {
    userId: "fetchAddresses",
  },
  methods: {
    addAddress(address) {
      this.addresses.push(address);
    },
    fetchAddresses() {
      this.loading = true;
      axios
        .get(`/api/addresses?userId=${this.userId}`)
        .then((res) => {
          this.addresses = res.data.addresses;
        })
        .catch((err) => {
          fireAlert("error", translate("front.errorMessage"));
        })
        .finally(() => {
          this.loading = false;
        });
    },
    deleteAddress(id) {
      fireConfirm(() => {
        nProgress.start();
        axios
          .delete(`/api/addresses/${id}`)
          .then((res) => {
            this.addresses = this.addresses.filter(
              (address) => address.id != id
            );
          })
          .catch((err) => {
            fireAlert("error", translate("front.errorMessage"));
          })
          .finally(() => {
            nProgress.done();
          });
      });
    },
  },
  mounted() {
    this.fetchAddresses();
  },
};
</script>

<style scoped>
.address-box {
  border: 1px #3f83c0 solid;
  border-radius: 10px !important;
}
.address-delete-btn {
  color: #3f83c0 !important;
}
</style>
