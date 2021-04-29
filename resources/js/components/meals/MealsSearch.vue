<template>
  <div
    class="row mb-1"
    id="search-bar"
    style="position: -webkit-sticky; position: sticky; top: 50px; z-index: 100"
  >
      <form @submit.prevent="handleSearch" >
    <div class="d-flex flex-sm-row flex-column align-items-start wrapper">
        <h4 style="flex-basis: 40%" class="mb-4 d-none d-lg-block">
          {{ translate("front.searchTitle") }}
        </h4>
        <div class="form-group">
          <input
            type="text"
            v-model="filters.search_query"
            class="form-control"
            :placeholder="translate('front.search')"
          />
        </div>
        <div class="form-group ml-sm-3">
          <select
            class="form-control has-cool-scrollbar"
            v-model="filters.category"
          >
            <option :value="undefined" selected>
              {{
                translate("front.allFem") + " " + translate("front.categories")
              }}
            </option>
            <option
              v-for="category in allCategories"
              :key="category.id"
              :value="category.slug"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
        <div class="form-group mx-sm-3">
          <div class="dropdown">
            <button
              class="form-control dropdown-toggle"
              type="button"
              id="dropdownMenuButton"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              {{ translate("front.filters") }} <i class="fa fa-sliders-h"></i>
            </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <div class="px-4 container py-1">
                <h6 class="lead">Budget</h6>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    v-model="filters.max_price"
                    :value="undefined"
                  />
                  <label class="form-check-label">
                    {{ translate("front.all") }} Budgets</label
                  >
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    v-model="filters.max_price"
                    :value="50"
                  />
                  <label class="form-check-label"> max : 50 dhs</label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    v-model="filters.max_price"
                    :value="80"
                  />
                  <label class="form-check-label"> max : 80 dhs</label>
                </div>
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="radio"
                    v-model="filters.max_price"
                    :value="200"
                  />
                  <label class="form-check-label"> max : 200 dhs</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="btn-orange btn-square" >
          <i class="fa fa-search"></i>
        </button>
    </div>
      </form>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      filters: {},
    };
  },
  watch: {
    // if search query is an empty string. assign undefined to it to remove it from the query param
    "filters.search_query": function (newVal, oldVal) {
      if (newVal === "") {
        this.filters.search_query = undefined;
      }
    },
  },
  computed: {
    ...mapGetters("meals", ["allCategories"]),
  },
  methods: {
    handleSearch() {
      this.$router
        .push({ path: "/meals", query: { ...this.filters } })
        .catch(() => {});
    },
    ...mapActions("meals", ["fetchCategories", "fetchMeals"]),
  },
  mounted() {
    this.fetchCategories();
    if (this.$route.query) [(this.filters = { ...this.$route.query })];
  },
};
</script>

<style>
</style>
