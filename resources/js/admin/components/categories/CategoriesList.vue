<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">
        {{ translate("admin.categories") }}
      </li>
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
                <i class="material-icons">category</i>
              </div>
              {{ translate("admin.categories") + " Table" }}
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->
              <button
                class="btn btn-danger"
                @click="prepareBulkDeleteCategories"
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

              <router-link :to="{ name: 'categories.create' }">
                <button class="btn btn-outline-success mr-2">
                  <i class="fa fa-plus-circle"></i>
                  <span>
                    {{
                      translate("admin.add") + " " + translate("admin.category")
                    }}</span
                  >
                </button>
              </router-link>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="">
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
                    <th>{{ translate("admin.name") }}</th>
                    <th>Slug</th>
                    <th>Menus</th>
                    <th>{{ translate("admin.createdAt") }}</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody v-if="getIsLoading">
                  <tr>
                    <td colspan="7" class="text-center py-5">
                      <vue-loaders-ball-scale-ripple-multiple
                        color="#2B51C4"
                        scale="1"
                      ></vue-loaders-ball-scale-ripple-multiple>
                    </td>
                  </tr>
                </tbody>
                <draggable
                  @change="updateCategoriesOrders"
                  element="tbody"
                  :list="allCategories"
                  :options="{ animation: 400, handle: '.btn-drag' }"
                  v-else
                >
                  <tr v-for="category in allCategories" :key="category.id">
                    <td>
                      <input
                        type="checkbox"
                        v-model="selectedItems"
                        :value="category.id"
                      />
                    </td>
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td>{{ category.slug }}</td>
                    <td>
                      <h5>
                        <span
                          class="badge"
                          :class="[
                            !category.meals_count
                              ? 'badge-danger'
                              : 'badge-primary',
                          ]"
                          >{{ category.meals_count }}</span
                        >
                      </h5>
                    </td>
                    <td>{{ category.created_at | formatDate }}</td>

                    <td>
                      <i
                        class="
                          fa fa-arrows-alt fa-lg
                          text-secondary
                          btn-drag
                          mr-4
                        "
                      ></i>
                      <router-link
                        class="mr-4"
                        :to="{
                          name: 'categories.edit',
                          params: { id: category.id },
                        }"
                        ><i class="fa fa-pen text-success"></i
                      ></router-link>
                      <a href="#" @click.prevent="deleteCategory(category.id)"
                        ><i class="fa fa-trash text-danger"></i
                      ></a>
                    </td>
                  </tr>
                </draggable>
              </table>
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
import draggable from "vuedraggable";

export default {
  components: {
    draggable,
  },
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
        this.selectedItems.length === this.allCategories.length ? true : false;
    },
  },
  computed: {
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },

    ...mapGetters("categories", ["allCategories", "isLoading"]),
  },
  methods: {
    selectOrUnSelectAll() {
      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.allCategories.forEach((category) => {
          this.selectedItems.push(category.id);
        });
      }
    },
    prepareBulkDeleteCategories() {
      if (!this.selectedItems.length) {
        return;
      }
      fireConfirm(async () => {
        await this.bulkDeleteCategories(this.selectedItems);
        this.selectedItems = [];
      });
    },
    ...mapActions("categories", [
      "fetchCategories",
      "deleteCategory",
      "bulkDeleteCategories",
      "updateCategoriesOrders",
    ]),
  },

  created() {
    this.fetchCategories();
  },
};
</script>

<style scoped>
.btn-drag {
  cursor: pointer;
}
</style>
