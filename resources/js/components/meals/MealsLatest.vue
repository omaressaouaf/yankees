<template>
  <div class="w-100">
    <div class="row w-100" data-aos="fade-up" data-aos-delay="100">
      <div class="col-md-12 d-flex justify-content-center mb-3">
        <ul id="menu-flters">
          <li
            @click="handleClick()"
            :class="[!selectedCategory ? 'filter-active' : '']"
            class="mr-1"
          >
            {{ translate("front.all") }}
          </li>
          <li
            @click="handleClick(category.id)"
            class="text-capitalize mr-1"
            :class="[selectedCategory == category.id ? 'filter-active' : '']"
            v-for="category in categories"
            :key="category.id"
          >
            {{ category.name }}
          </li>
        </ul>
      </div>
    </div>
    <div class="row"  data-aos="zoom-in" data-aos-delay="100">
      <transition-group name="meals" tag="div" class="row meals meals-latest-row">
        <div
          v-for="meal in filteredMeals"
          :key="meal.id"
          class="col-md-6 col-lg-4 col-xl-4 mb-4 meal "
        >
          <meals-item :meal="meal"></meals-item>
        </div>
      </transition-group>
    </div>
  </div>
</template>

<script>
export default {
  props: ["categories", "latestMeals"],
  data() {
    return {
      selectedCategory: null,
    };
  },
  computed: {
    filteredMeals() {
      if (!this.selectedCategory) return this.latestMeals;
      return this.latestMeals.filter(
        (meal) => meal.category.id === this.selectedCategory
      );
    },
  },
  methods: {
    handleClick(id) {
      this.selectedCategory = id;
    },
  },
};
</script>

<style scoped>
.meal {
  transition: all 0.35s ease-in-out;
}
.meals-enter {
  transform: scale(0.5) translatey(-80px);
  opacity: 0;
}
.meals-leave-to {
  transform: translatey(30px);
  opacity: 0;
}

.meals-leave-active {
  position: absolute;
  z-index: -1;
}
</style>
