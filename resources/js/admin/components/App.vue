<template>
  <layout>
    <transition name="fade" mode="out-in">
      <router-view v-if="$online" :key="$route.fullPath"></router-view>
      <offline v-else></offline>
    </transition>
  </layout>
</template>

<script>
import Layout from "./layouts/Layout.vue";
import Offline from "./errors/Offline";
import { mapGetters } from "vuex";

export default {
  components: { Layout, Offline },
  computed: {
    ...mapGetters("meals", ["uploadProgresses"]),
  },
  created() {
    window.addEventListener("beforeunload", (event) => {
      if (!this.uploadProgresses.length) return;
      event.preventDefault();
      // Chrome requires returnValue to be set.
      event.returnValue = "";
    });
  },
};
</script>

<style scoped>
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
