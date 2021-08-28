<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">{{ translate("admin.menus") }}</li>
    </the-breadcrumb>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="d-flex">
            <div
              class="card-header card-header-icon card-header-warning"
              style="flex-grow: 1 !important"
            >
              <div class="card-icon card-icon-custom">
                <i class="material-icons">lunch_dining</i>
              </div>
              <h4 class="card-title">
                {{ translate("admin.menus") + " Table" }}
              </h4>
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->
              <button
                class="btn btn-danger"
                @click="prepareBulkDeleteMeals"
                :disabled="postIsLoading"
              >
                <span>
                  <i
                    v-if="postIsLoading"
                    class="fa fa-circle-notch fa-spin"
                  ></i>
                  <i v-else class="fa fa-dumpster"></i>
                  {{ translate("admin.delete") }}
                </span>
              </button>

              <router-link :to="{ name: 'meals.create' }">
                <button class="btn btn-outline-success mr-2">
                  <i class="fa fa-plus-circle"></i>
                  <span>
                    {{
                      translate("admin.add") + " " + translate("admin.menu")
                    }}</span
                  >
                </button>
              </router-link>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th>
                      <input
                        :disabled="getIsLoading"
                        type="checkbox"
                        v-model="allSelected"
                        @click="selectOrUnSelectAll"
                      />
                    </th>
                    <th>ID</th>
                    <th>{{ translate("admin.title") }}</th>
                    <th>{{ translate("admin.price") }}</th>
                    <th>{{ translate("admin.active") }}</th>
                    <th>{{ translate("admin.category") }}</th>
                    <th>Image</th>
                    <th>Extras</th>
                    <th>{{ translate("admin.createdAt") }}</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="getIsLoading">
                    <td colspan="10" class="text-center py-5">
                      <vue-loaders-ball-scale-ripple-multiple
                        color="#2B51C4"
                        scale="1"
                      ></vue-loaders-ball-scale-ripple-multiple>
                    </td>
                  </tr>
                  <tr v-for="meal in allMeals" :key="meal.id" v-else>
                    <td>
                      <input
                        type="checkbox"
                        v-model="selectedItems"
                        :value="meal.id"
                      />
                    </td>
                    <td>{{ meal.id }}</td>
                    <td>{{ meal.title }}</td>
                    <td>{{ meal.price }} DH</td>
                    <td>
                      <i
                        :class="[
                          meal.active
                            ? 'fa fa-check text-success'
                            : 'fa fa-times text-danger',
                        ]"
                      ></i>
                    </td>
                    <td :class="{ 'text-danger': !meal.category.id }">
                      <i v-if="!meal.category.id" class="fa fa-info-circle"></i>
                      {{ meal.category.name }}
                    </td>
                    <td>
                      <img
                        width="80"
                        height="80"
                        class="img-fluid rounded"
                        :src="meal.resized_image"
                        :alt="meal.title"
                      />
                    </td>
                    <td class="text-center">
                      <h5>
                        <span
                          class="badge"
                          :class="[
                            !meal.extras_count
                              ? 'badge-danger'
                              : 'badge-primary',
                          ]"
                          >{{ meal.extras_count }}</span
                        >
                      </h5>
                    </td>
                    <td>{{ meal.created_at | formatDate }}</td>
                    <td>
                      <router-link
                        class="mr-4"
                        :to="{
                          name: 'meals.edit',
                          params: { id: meal.id },
                        }"
                        ><i class="fa fa-pen text-success"></i
                      ></router-link>
                      <a href="#" @click.prevent="deleteMeal(meal.id)"
                        ><i class="fa fa-trash text-danger"></i
                      ></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-5">
              <progresses-list />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { dataTableMixin } from "../../mixins";
import { mapGetters, mapActions } from "vuex";
import { fireConfirm } from "../../helpers";
import ProgressesList from "./ProgressesList.vue";

export default {
  components: { ProgressesList },
  mixins: [dataTableMixin],
  data() {
    return {
      selectedItems: [],
      allSelected: false,
    };
  },
  watch: {
    selectedItems() {
      this.allSelected =
        this.selectedItems.length === this.allMeals.length ? true : false;
    },
  },
  computed: {
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },

    ...mapGetters("meals", ["allMeals", "isLoading"]),
  },
  methods: {
    selectOrUnSelectAll() {
      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.allMeals.forEach((meal) => {
          this.selectedItems.push(meal.id);
        });
      }
    },
    prepareBulkDeleteMeals() {
      if (!this.selectedItems.length) {
        return;
      }
      fireConfirm(async () => {
        await this.bulkDeleteMeals(this.selectedItems);
        this.selectedItems = [];
      });
    },
    ...mapActions("meals", ["fetchMeals", "deleteMeal", "bulkDeleteMeals"]),
  },

  created() {
    this.fetchMeals();
  },
};
</script>

<style>
</style>
