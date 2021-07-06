<template>
  <div class="progress">
    <div
      class="progress-bar bg-success progress-bar-striped progress-bar-animated"
      role="progressbar"
      :style="{ width: percentage + '%' }"
      :aria-valuenow="percentage"
      aria-valuemin="0"
      aria-valuemax="100"
    >
      {{ percentage }}%
    </div>
  </div>
</template>

<script>
export default {
  props: ["percentage"],
};
</script>

<style>
</style>
