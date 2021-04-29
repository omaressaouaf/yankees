<template>
  <!-- Modal -->
  <div
    class="modal fade"
    id="mealModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="mealModalTitle"
    style="z-index: 1000000000"
    aria-hidden="true"
  >
    <div
      class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
      role="document"
    >
      <div class="modal-content" v-if="mealObject">
        <!-- <div class="modal-header" style="border-bottom: 0 none ;">
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div> -->
        <div class="modal-body has-cool-scrollbar">
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="container px-0 px-md-4 mt-2" v-if="mealObject">
            <h2 class="modal-title font-weight-bold">
              {{ translate("front.customize") }} {{ mealObject.title }}
            </h2>
            <div class="row mt-4">
              <div class="col-md-5">
                <img
                  class="img-fluid w-100 rounded img-thumbnail"
                  :src="mealObject.image"
                  alt="Vans"
                />
              </div>
              <div class="col-md-6 mt-3">
                <h5 class="card-subtitle mb-1">
                  {{ translate("front.category") }}:
                  <span class="tag"> {{ mealObject.category.name }}</span>
                </h5>
                <p class="card-text text-muted">
                  {{ mealObject.desc || translate("front.noDescription") }}
                </p>
                <div class="price text-dark">
                  <h4 class="font-weight-bold">{{ mealObject.price }} DHS</h4>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div
                v-if="mealObject.extras && mealObject.extras.length"
                class="col-md-12"
              >
                <server-error-alert
                  v-if="serverErrors"
                  :serverErrors="serverErrors"
                />
                <div
                  v-for="extra in mealObject.extras"
                  :key="extra.id"
                  class="mb-3 p-3"
                  style="border: 1px solid white"
                  :class="{
                    'red-border':
                      $v.cartItem.extras.$each.$iter[findExtraIndex(extra.id)]
                        .user_selected_options.$error && $v.$dirty,
                  }"
                >
                  <h5 class="text-uppercase">
                    {{ extra.title }}
                  </h5>
                  <hr />

                  <p class="text-small text-muted">
                    Minimum {{ extra.pivot.min }} {{translate('front.and')}} Maximum
                    {{ extra.pivot.max }}
                  </p>
                  <!--  -->
                  <label
                    class="inputcontainer"
                    v-if="extra.pivot.min === 0 && extra.pivot.max === 1"
                    >{{ translate("front.noOption") }}
                    <input
                      class="form-check-input"
                      type="radio"
                      v-model="singleExtraPath(extra.id).user_selected_options"
                      :value="[]"
                    />
                    <span class="radiomark mark"></span>
                  </label>
                  <div v-for="option in extra.options" :key="option.id">
                    <div
                      class="mb-3"
                      v-if="
                        extra.pivot.admin_selected_options.includes(option.id)
                      "
                    >
                      <!-- in case of binding to a radio , the user_selected_options will be transformed to an object (that's just how radio binding works). down here is a quick trick to fix that. we ara binding to the first element of the user_selected_options so we can keep our array in order for the backend to work correctly -->
                      <label class="inputcontainer" v-if="extra.pivot.max === 1"
                        >{{ option.name }}
                        <span v-if="option.price" class="text-success ml-2"
                          >+{{ option.price }} dhs</span
                        >
                        <input
                          class="form-check-input"
                          type="radio"
                          v-model="
                            singleExtraPath(extra.id).user_selected_options[0]
                          "
                          :value="option"
                        />
                        <span class="radiomark mark"></span>
                      </label>
                      <label class="inputcontainer" v-else
                        >{{ option.name }}
                        <span v-if="option.price" class="text-success ml-2"
                          >+{{ option.price }} dhs</span
                        >
                        <input
                          class="form-check-input"
                          type="checkbox"
                          v-model="
                            singleExtraPath(extra.id).user_selected_options
                          "
                          :value="option"
                        />
                        <span class="checkboxmark mark"></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <span
            class="mr-auto px-2"
            :class="{
              'red-border': $v.cartItem.qty.$error,
            }"
          >
            <a
              href="#"
              class="btn-outline-orange"
              style="padding: 5px 7px"
              @click.prevent="decreaseQty"
            >
              <i class="fa fa-minus"></i
            ></a>
            <span style="margin: 0px 1px">{{ cartItem.qty }}</span>
            <a
              href="#"
              class="btn-outline-orange"
              style="padding: 5px 7px"
              @click.prevent="increaseQty"
            >
              <i class="fa fa-plus"></i
            ></a>
          </span>

          <button
            type="button"
            @click="handleAddToCart"
            :disabled="postIsLoading"
            class="btn-orange btn-square"
          >
            <i class="fa fa-spinner fa-spin" v-if="postIsLoading"></i>
            <i class="fa fa-cart-plus" v-else></i>
            {{ translate("front.addToCart") }}
            <span class="text-small">{{ priceWithOptions }} dhs</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import { required, minValue, maxValue } from "vuelidate/lib/validators";
import ServerErrorAlert from "../../admin/components/partials/ServerErrorAlert.vue";
export default {
  components: { ServerErrorAlert },
  data() {
    return {
      cartItem: { id: "", qty: 1, price: 0, extras: [] },
    };
  },
  validations: {
    cartItem: {
      id: { required },
      qty: { required, minValue: minValue(1), maxValue: maxValue(20) },
      price: { required, minValue: minValue(0) },
      extras: {
        required: false,
        $each: {
          user_selected_options: {
            isValid(value, extra) {
              return (
                value.length >= extra.pivot.min &&
                value.length <= extra.pivot.max
              );
            },
          },
        },
      },
    },
  },

  watch: {
    mealObject() {
      if (this.mealObject) {
        // we need to tweek each extra in order to have a user_selected_options **array** so we can bind to it from the inputs
        const extrasWithUserSelectedOptions = this.mealObject.extras.map(
          (extra) => {
            return { ...extra, user_selected_options: [] };
          }
        );
        // and finally overriding it the extras array with the modified one
        this.cartItem = {
          ...this.cartItem,
          id: this.mealObject.id,
          qty: 1,
          price: this.mealObject.price,
          extras: extrasWithUserSelectedOptions,
        };
      }
    },
  },
  computed: {
    priceWithOptions() {
      let priceWithOptions = this.mealObject.price;
      if (this.cartItem.extras) {
        this.cartItem.extras.forEach((extra) => {
          priceWithOptions = extra.user_selected_options.reduce(
            (priceWithOptions, option) => {
              return priceWithOptions + option.price;
            },
            priceWithOptions
          );
        });
      }
      return priceWithOptions * this.cartItem.qty;
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("meals", ["mealObject"]),
    ...mapGetters("cart", ["serverErrors", "isLoading"]),
  },
  methods: {
    increaseQty() {
      if (this.cartItem.qty == 20) return;
      this.cartItem.qty += 1;
    },
    decreaseQty() {
      if (this.cartItem.qty == 1) return;
      this.cartItem.qty -= 1;
    },
    handleAddToCart() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.cartItem.price = this.priceWithOptions;
        this.addToCart(this.cartItem).then(() => {
          this.cartItem = {};
          // this doesn't work now (after resetting the form values in the previous lines)
          //this.$v.$reset()
          // this works even better - using Vue.nextTick method
          this.$nextTick(() => {
            this.$v.$reset();
          });
        });
      }
    },
    findExtraIndex(id) {
      return this.cartItem.extras.findIndex((extra) => extra.id === id);
    },
    singleExtraPath(id) {
      return this.cartItem.extras[this.findExtraIndex(id)];
    },
    ...mapActions("cart", ["addToCart"]),
  },
  mounted() {
    $("#mealModal").on("hidden.bs.modal", (e) => {
      this.$v.$reset();
    });
  },
};
</script>

<style scoped>
/* ___________________________________________________________________________________ */
.red-border {
  border: 1px solid red !important;
  border-radius: 10px;
}
</style>
