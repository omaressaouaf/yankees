<template>
  <div
    id="snackbar"
    :class="[uploadProgresses.length && showToast ? 'visible' : 'unvisible']"
  >
    <div class="content">
      <h4>
        <i class="fa fa-spinner fa-spin mr-2"></i>
        {{ translate("admin.uploading") }} {{ uploadProgresses.length }}
        {{ translate("admin.image") }}(s) / Menu(s)
      </h4>
    </div>
    <div class="close" @click="showToast = false">
      <i class="ml-4 fa fa-times"></i>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      showToast: true,
    };
  },
  computed: {
    ...mapGetters("meals", ["uploadProgresses"]),
  },
};
</script>

<style scoped>
/* The snackbar - position it at the bottom and in the middle of the screen */
#snackbar {
  display: flex;
  min-width: 250px;
  margin-left: -125px;
  background: linear-gradient(60deg, #464642, #3b3b38, #1d1d1b) !important;
  color: #fff !important;
  border-radius: 5px;
  position: fixed;
  right: 2%;
  bottom: 30px;
  z-index: 1000000;
  padding: 8px 17px 8px 7px;
  animation: fadeOut;
  animation-duration: 0.6s;
}
#snackbar .content {
  padding: 26px;
}

#snackbar.unvisible {
  visibility: hidden;
  transition: visibility 0.1s;
}
#snackbar.visible {
  visibility: visible;
  animation: fadeInUp;
  animation-duration: 0.6s;
}
</style>
