<template>
  <div>
    <carousel
      :items="4"
      :margin="10"
      :responsive="{
        0: {
          items: 1,
        },
        768: {
          items: 2,
        },
        900: {
          items: 3,
        },
      }"
      :autoplay="true"
      :nav="false"
    >
      <div class="mb-5" v-for="meal in meals" :key="meal.id">
        <meals-item :meal="meal" :show-image-placeholder="false" />
      </div>
    </carousel>
  </div>
</template>

<script>
import carousel from "vue-owl-carousel";
export default {
  components: { carousel },
  props: ["meals"],
};
</script>

<style>
</style>
