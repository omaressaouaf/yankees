<template>
  <div class="card">
    <vue-skeleton-loader
      v-if="imageLoading && showImagePlaceholder"
      type="rect"
      width="100%"
      height="247px"
    />
    <img
      @load="setImageLoading"
      class="card-img"
      :class="[!meal.active ? 'dark-bg' : '']"
      :src="meal.resizedImage"
      style="min-height: 200px"
      alt="Vans"
    />

    <div
      class="card-img-overlay d-flex justify-content-end"
      style="height: 40%"
      v-if="!meal.active"
    >
      <span style="" class="text-light text-uppercase"
        >{{ translate("front.unavailable") }}
        <i class="fas fa-ban card-link text-danger like"></i
      ></span>
    </div>
    <div class="card-body">
      <h4 class="card-title">
        {{ meal.title }}
      </h4>
      <h6 class="card-subtitle mb-2 text-muted">
        {{ translate("front.category") }}: {{ meal.category.name }}
      </h6>
      <p class="card-text">{{ meal.desc | truncate }}</p>
      <div class="buy d-flex justify-content-between align-items-center">
        <div class="price text-success">
          <h5 class="mt-4">{{ meal.price }} dhs</h5>
        </div>
        <button
          class="btn-orange"
          @click="handleClickMeal(meal)"
          v-if="meal.active && $gate.can('shop')"
          :disabled="cartLoading"
        >
          <i class="fa fa-spin fa-spinner" v-if="cartLoading"></i>
          <i v-else class="fa fa-cart-plus"></i>
          {{ translate("front.addToCart") }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      imageLoading: true,
      cartLoading: false,
    };
  },
  props: {
    meal: Object,
    showImagePlaceholder: {
      required: false,
      type: Boolean,
      default: true,
    },
  },
  methods: {
    setImageLoading() {
      this.imageLoading = false;
    },
    handleClickMeal(meal) {
      if (meal.extras && meal.extras.length) {
        this.$store.commit("meals/setMeal", meal);
        $("#mealModal").modal("show");
      } else {
        this.cartLoading = true;
        this.addToCart({
          id: meal.id,
          qty: 1,
          price: meal.price,
          extras: [],
        }).finally(() => {
          this.cartLoading = false;
        });
      }
    },
    ...mapActions("cart", ["addToCart"]),
  },
};
</script>

<style scoped>
.dark-bg {
  filter: brightness(35%);
}
</style>
