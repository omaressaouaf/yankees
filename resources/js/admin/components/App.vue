<template>
  <layout>
    <transition name="fade" mode="out-in">
      <router-view :key="$route.fullPath"></router-view>
    </transition>
  </layout>
</template>

<script>
import Layout from "./layouts/Layout.vue";

export default {
  components: { Layout },
};
</script>

<style>
/* route transitions */
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.3s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>
