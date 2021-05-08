<template>
  <div class="container-fluid">
    <the-breadcrumb />
    <cards />
    <charts />


  </div>
</template>

<script>
import Cards from "./Cards.vue";
import Charts from "./Charts.vue";

export default {
  components: { Cards, Charts },
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

</style>
