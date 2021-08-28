<template>
  <button
    v-if="cartCount"
    class="floating-cart-btn btn btn-success"
    id="modal_view_right"
    data-toggle="modal"
    data-target="#cart_modal"
  >
    <span class="position-relative">
      <i class="fa fa-shopping-cart fa-lg"></i>
      <span
        class="badge badge-danger position-absolute"
        style="top: -8px; right: -7px"
      >
        {{ cartCount }}
      </span>
    </span>
  </button>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {
    cartCount() {
      return typeof this.$store.state.cart.cart.count === "undefined"
        ? this.cartInitialCount
        : this.$store.state.cart.cart.count;
    },
  },
  props: ["cartInitialCount"],
};
</script>

<style>
</style>
