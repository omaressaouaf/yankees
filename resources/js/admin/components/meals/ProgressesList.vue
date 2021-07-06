<template>
  <div class="px-5" v-if="uploadProgresses.length">
    <h2 className="text-info">
      {{ translate("admin.uploading") }} 2 {{ translate("admin.menu") }}(s)
    </h2>
    <div v-for="progress in uploadProgresses" :key="progress.identifier">
      <h4>{{ progress.title }}</h4>
      <progress-bar :percentage="progress.percentage" />
      <button
        :disabled="progress.percentage === 100"
        @click="cancelUpload(progress.source)"
        class="btn btn-danger btn-sm mt-2"
      >
        {{ translate("admin.cancel") }}
      </button>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import ProgressBar from "./ProgressBar.vue";
export default {
  components: { ProgressBar },
  computed: {
    ...mapGetters("meals", ["uploadProgresses"]),
  },
  methods: {
    ...mapActions("meals", ["cancelUpload"]),
  },
};
</script>

<style>
</style>
