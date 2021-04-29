<template>
  <div
    class="form-group label-floating mb-4"
    :class="{ 'has-danger': hasErrors }"
  >
    <slot />
    <div>
      <label
        v-if="hasErrors"
        class="control-label ml-5 text-danger text-muted"
        >{{ activeErrorMessages[0] }}</label
      >
    </div>
  </div>
</template>

<script>
import { singleErrorExtractorMixin } from "vuelidate-error-extractor";
export default {
  mixins: [singleErrorExtractorMixin],
};
</script>

<style scoped>
.has-danger input {
  background-image: none !important ;
  border-bottom: red 2px solid !important;
}
.has-danger input:focus {
  border-bottom: none !important;
  border-bottom: red 2px solid !important;

}
</style>

