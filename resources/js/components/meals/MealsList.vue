<template>
  <div class="w-100">
    <div class="row w-100" >
      <div class="col-md-12 d-flex justify-content-start mb-3">
        <ul id="menu-flters">
          <li
            @click="handleClick()"
            :class="[!selectedCategoryId ? 'filter-active' : '']"
            class="mr-1"
          >
            {{ translate("front.all") }}
          </li>
          <li
            @click="handleClick(category.id)"
            class="text-capitalize mr-1"
            :class="[selectedCategoryId == category.id ? 'filter-active' : '']"
            v-for="category in categories"
            :key="category.id"
          >
            {{ category.name }}
          </li>
        </ul>
      </div>
    </div>
    <div class="row" v-if="getIsLoading">
      <meals-skeleton
        :cols-four="colsFour"
        v-for="item in Array(12).keys()"
        :key="item"
      />
    </div>
    <div class="row">
      <transition-group name="categories" tag="div" class="categories">
        <div
          class="category"
          v-for="category in filteredCategories"
          :key="category.id"
        >
          <h3 class="my-4">&middot; {{ category.name }}</h3>
          <div class="row meals-latest-row">
            <div
              v-for="meal in category.meals"
              :key="meal.id"
              class="col-md-6 mb-4 meal"
              :class="[colsFour ? 'col-lg-4 col-xl-4' : 'col-lg-3 col-xl-3']"
            >
              <meals-item :meal="meal"></meals-item>
            </div>
          </div>
          <hr />
        </div>
      </transition-group>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    categories: {
      type: Array,
      required: true,
    },
    colsFour: {
      type: Boolean,
      required: false,
      default: true,
    },
  },
  data() {
    return {
      selectedCategoryId: null,
    };
  },
  computed: {
    filteredCategories() {
      if (!this.selectedCategoryId) return this.categories;
      return this.categories.filter(
        (category) => category.id === this.selectedCategoryId
      );
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    ...mapGetters("meals", ["isLoading"]),
  },
  methods: {
    handleClick(id) {
      this.selectedCategoryId = id;
    },
  },
};
</script>

<style scoped>
.category {
  transition: all 0.35s ease-in-out;
}
.categories-enter {
  transform: scale(0.5) translatey(-80px);
  opacity: 0;
}
.categories-leave-to {
  transform: translatey(30px);
  opacity: 0;
}

.categories-leave-active {
  position: absolute;
  z-index: -1;
}
.categories {
  width :100% !important;
}
</style>
