<template>
  <div class="wrapper">
    <the-sidebar />

    <div class="main-panel">
      <the-navbar />
      <div class="content">
        <slot></slot>
      </div>
      <the-footer />
    </div>
  </div>
</template>

<script>
import TheNavbar from "../partials/TheNavbar.vue";
import TheSidebar from "../partials/TheSidebar.vue";
import TheFooter from "../partials/TheFooter.vue";

export default {
  components: { TheNavbar, TheSidebar, TheFooter },
};
</script>

<style>
</style>
