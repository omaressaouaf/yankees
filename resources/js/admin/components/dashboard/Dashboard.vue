<template>
  <div class="container-fluid">
    <the-breadcrumb />
    <carts />
    <charts />


  </div>
</template>

<script>
import Carts from "./Carts.vue";
import Charts from "./Charts.vue";

export default {
  components: { Carts, Charts },
};
</script>
<style >
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.ball-clip-rotate > div {
  margin: -0.5px !important;

  display: block !important;
}
</style>
