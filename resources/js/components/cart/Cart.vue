<template>
  <div id="cartInnerWrapper">
    <div v-if="getIsLoading">
      <cart-skeleton />
    </div>
    <div v-else class="card" :class="[postIsLoading ? 'div-disabled' : '']">
      <div v-if="$gate.can('shop')" class="card-body">
        <div
          class="w-100"
          style="position: absolute; top: 20%; left: 45%; z-index: 10000"
          v-if="postIsLoading"
        >
          <vue-loaders-ball-scale-ripple-multiple
            color="#2B51C4"
            scale="1"
          ></vue-loaders-ball-scale-ripple-multiple>
        </div>
        <div>
          <div
            class="pt-4 wish-list has-cool-scrollbar"
            id="cartContentWrapper"
          >
            <h5 class="mb-4">
              {{ translate("front.yourCart") }} ({{ cartObject.count }})
            </h5>

            <div v-if="cartObject.count">
              <div
                class="row mb-4"
                v-for="item in cartObject.content"
                :key="item.rowId"
              >
                <div class="col-md-2">
                  <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                    <img
                      class="img-fluid w-100"
                      :src="item.model.resized_image"
                      style="max-height: 100px; max-width: 100px"
                      alt="Sample"
                    />
                  </div>
                </div>
                <div
                  class="col-md-7 col-lg-9 col-xl-9"
                  style="width: 100% !important"
                >
                  <div>
                    <div class="d-flex">
                      <div style="width: 65%">
                        <h5>{{ item.name }}</h5>
                        <p
                          class="text-muted text-uppercase small"
                          v-html="item.options.user_selected_options"
                        ></p>
                        <a
                          href="#"
                          @click.prevent="deleteFromCart(item.rowId)"
                          class="text-danger text-small"
                          ><i class="fa fa-times"></i>
                          {{ translate("front.delete") }}
                        </a>
                      </div>
                      <div class="ml-auto" style="position: relative">
                        <span>
                          <a
                            href="#"
                            class="btn-outline-orange"
                            style="padding: 5px 7px"
                            @click.prevent="
                              updateCart({
                                rowId: item.rowId,
                                qty: item.qty - 1,
                              })
                            "
                          >
                            <i class="fa fa-minus"></i
                          ></a>
                          <span style="margin: 0px 1px">{{ item.qty }}</span>
                          <a
                            href="#"
                            @click.prevent="
                              updateCart({
                                rowId: item.rowId,
                                qty: item.qty + 1,
                              })
                            "
                            class="btn-outline-orange"
                            style="padding: 5px 7px"
                          >
                            <i class="fa fa-plus"></i
                          ></a>
                        </span>
                        <p class="ml-2 mt-3">
                          <span class="text-success"
                            ><strong>{{ item.price * item.qty }} dhs</strong>
                          </span>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <p class="text-primary mb-3">
                <i class="fas fa-info-circle mr-1"></i>
                {{ translate("front.dontDelay") }}.
              </p>
            </div>

            <div v-else class="text-center mt-4 mb-4 alert alert-warning">
              <i class="fa fa-utensils fa-2x text-white mb-3"></i>
              <h4>{{ translate("front.cartEmpty") }}.</h4>
              <h6 class="text-small">
                {{ translate("front.cartEmptyText") }}
              </h6>
            </div>
          </div>
        </div>

        <div
          style="
            z-index: 1000000000000;
            box-shadow: 0 -5px 5px -5px rgba(32, 32, 32, 0.568);
          "
        >
          <div v-if="$gate.can('checkout-with-stripe')" class="mb-3">
            <div class="pt-4">
              <img
                class="mr-2"
                width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                alt="Visa"
              />
              <img
                class="mr-2"
                width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                alt="American Express"
              />
              <img
                class="mr-2"
                width="45px"
                src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                alt="Mastercard"
              />
            </div>
          </div>

          <div class="mb-3">
            <div class="pt-1">
              <ul class="list-group list-group-flush">
                <li
                  class="
                    list-group-item
                    d-flex
                    justify-content-between
                    align-items-center
                    border-0
                    px-0
                    pb-0
                  "
                >
                  {{ translate("front.total") }}
                  <span>{{ cartObject.total }} dhs</span>
                </li>
                <li
                  class="
                    list-group-item
                    d-flex
                    justify-content-between
                    align-items-center
                    px-0
                    border-0
                    pb-0
                  "
                >
                  {{ translate("front.delivery") }}
                  <span>{{ deliveryPrice }} dhs</span>
                </li>
                <li
                  class="
                    list-group-item
                    d-flex
                    justify-content-between
                    align-items-center
                    px-0
                    border-0
                    pb-0
                  "
                >
                  {{ translate("front.delivery") }}
                  {{ translate("admin.time") }}
                  <span>{{ deliveryTime }} mintues</span>
                </li>
                <li
                  v-if="!$gate.can('checkout', { cartObject, minOrderPrice })"
                  class="
                    list-group-item
                    text-danger
                    font-weight-bold
                    d-flex
                    justify-content-between
                    align-items-center
                    px-0
                  "
                >
                  {{ translate("admin.min_order_price") }}

                  <span>{{ minOrderPrice }} dhs</span>
                </li>
              </ul>

              <a
                v-if="$gate.can('checkout', { cartObject, minOrderPrice })"
                href="/checkout"
                class="btn-orange text-center btn-square btn-block mt-2"
              >
                {{ translate("front.checkout") }}
              </a>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="card-body">
        <h5 class="mb-4">
          {{ translate("front.yourCart") }}
        </h5>
        <div class="text-center" style="position : relative">
          <img
            src="/storage/images/design/hamburger.svg"
            alt="Fermé temporairement"
            class="img-fluid"
          />
        <h2>{{translate('front.closedNow')}}</h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import CartSkeleton from "./CartSkeleton.vue";
export default {
  components: { CartSkeleton },
  data() {
    return {
      deliveryPrice: window.deliveryPrice,
      deliveryTime: window.deliveryTime,
      minOrderPrice: window.minOrderPrice,
    };
  },
  computed: {
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("cart", ["cartObject", "isLoading"]),
  },
  methods: {
    ...mapActions("cart", ["deleteFromCart", "updateCart"]),
  },

};
</script>

<style scoped>
@media (min-width: 1024px) and (max-height: 657px) {
  #cartInnerWrapper {
    min-height: 1000px;
  }
}
#cartContentWrapper {
  max-height: 400px;
  overflow-y: scroll;
  overflow-x: hidden;
}
.div-disabled {
  filter: brightness(80%);
  pointer-events: none;
}
</style>
