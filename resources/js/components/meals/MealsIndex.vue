<template>
  <section>
    <div class="px-5">
      <div class="row">
        <div
          v-if="cartObject.count || cartIsLoading"
          class="col-xl-4 order-xl-2 mt-3 mb-4"
        >
          <div id="cartWrapper">
            <cart />
          </div>
        </div>

        <div
          :class="[
            cartObject.count || cartIsLoading ? 'col-xl-8' : 'col-xl-12',
          ]"
          class="order-xl-1 menu"
        >
          <meals-list
            :cols-four="cartObject.count > 0 || cartIsLoading"
            :categories="allCategories"
          />
          <meals-single />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Cart from "../cart/Cart.vue";

export default {
  components: { Cart },
  computed: {
    cartIsLoading() {
      return this.isLoading["get"];
    },

    ...mapGetters("cart", ["cartObject", "isLoading"]),
    ...mapGetters("meals", ["allCategories"]),
  },
  methods: {
    ...mapActions("cart", ["fetchCart"]),
    ...mapActions("meals", ["fetchCategoriesWithMeals"]),
  },
  mounted() {
    if (this.$gate.can("shop")) {
      this.fetchCart();
    }
    this.fetchCategoriesWithMeals();
  },
};
</script>


<style scoped>
#cartWrapper {
  position: -webkit-sticky;
  position: sticky;
  top: 90px;
}
@media (min-width: 1024px) and (max-height: 657px) {
  #cartWrapper {
    overflow-y: auto;
    max-height: 800px;
  }
  #cartWrapper::-webkit-scrollbar {
    display: none;
  }

  /* Hide scrollbar for IE, Edge and Firefox */
  #cartWrapper {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }
}
</style>
