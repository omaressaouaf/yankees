<template>
  <div>
    <meals-search />
    <div class="row" v-if="getIsLoading">
      <meals-skeleton v-for="item in [1, 2, 3, 4, 5, 6]" :key="item" />
    </div>
    <transition name="fade">
      <div class="row" v-if="!getIsLoading">
        <div v-if="!allMeals.length" class="col-12 text-center mt-4">
          <i class="fa fa-utensils text-muted fa-3x mb-3"></i>
          <h3>{{ translate("front.noMeals") }}.</h3>
          <h5 class="text-muted">{{ translate("front.noMealsText") }}</h5>
        </div>
        <div
          v-for="meal in allMeals"
          :key="meal.id"
          class="col-12 col-sm-8 col-md-6 col-lg-4 mt-2"
        >
          <meals-item :meal="meal" />
        </div>
        <div class="col-md-12">
          <infinite-loading @infinite="infiniteHandler" />
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import MealsItem from "./MealsItem.vue";
import MealsSearch from "./MealsSearch.vue";
import MealsSkeleton from "./MealsSkeleton.vue";

export default {
  components: { MealsSkeleton, MealsSearch, MealsItem },
  data() {
    return {
      page: 1,
    };
  },
  computed: {
    getIsLoading() {
      return this.isLoading["get"];
    },

    ...mapGetters("meals", ["allMeals", "isLoading"]),
  },
  watch: {
    // $route watcher will execute immediately after the component creation and when the route params/query changes
    $route: {
      immediate: true,
      handler() {
        // always reset the page to 1 when the route changes (in case of filtering)
        this.page = 1;
        // increment the page if the api call went through successfully
        this.fetchMeals({ page: this.page, ...this.$route.query }).then(
          () => (this.page += 1)
        );
      },
    },
  },
  methods: {
    infiniteHandler($state) {
      if (this.allMeals.length) {
        this.fetchMeals({ page: this.page, ...this.$route.query }).then(
          (nextPageUrl) => {
            if (nextPageUrl) {
              this.page += 1;
              $state.loaded();
            } else {
              $state.complete();
            }
          }
        );
      } else {
        $state.complete();
      }
    },

    ...mapActions("meals", ["fetchMeals"]),
  },
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.6s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
