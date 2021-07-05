<template>
  <div>
    <carousel
      :items="4"
      :responsive="{
		0: {
		  items: 1
		},
		768: {
		  items: 2
		},
		900: {
		  items: 4,
		}
      }"
      :autoplay="true"
      :nav="false"
    >
      <meals-item
        v-for="meal in meals"
        :key="meal.id"
        :meal="meal"
        :show-image-placeholder="false"
      />
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
