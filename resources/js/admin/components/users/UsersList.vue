<template>
  <div class="container-fluid">
    <address-list
      v-if="clickedUserId"
      :user-id="clickedUserId"
      :apply-front-theme="false"
    />

    <the-breadcrumb>
      <li class="breadcrumb-item active">{{ translate("admin.users") }}</li>
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
                <i class="material-icons">people</i>
              </div>
              <h4 class="card-title">
                {{ translate("admin.users") + " Table" }}
              </h4>
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->
              <button
                class="btn btn-danger"
                @click="prepareBulkDeleteUsers"
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

              <router-link :to="{ name: 'users.create' }">
                <button class="btn btn-outline-success mr-2">
                  <i class="fa fa-plus-circle"></i>
                  <span>
                    {{
                      translate("admin.add") + " " + translate("admin.user")
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
                    <th>{{ translate("admin.name") }}</th>
                    <th>Email</th>
                    <th>{{ translate("admin.phone") }}</th>
                    <th>{{ translate("admin.roles") }}</th>
                    <th>{{ translate("admin.joinedAt") }}</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="getIsLoading">
                    <td colspan="8" class="text-center py-5">
                      <vue-loaders-ball-scale-ripple-multiple
                        color="#2B51C4"
                        scale="1"
                      ></vue-loaders-ball-scale-ripple-multiple>
                    </td>
                  </tr>
                  <tr v-for="user in allUsers" :key="user.id" v-else>
                    <td>
                      <input
                        type="checkbox"
                        v-model="selectedItems"
                        :value="user.id"
                      />
                    </td>
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                      <h4>
                        <span class="badge badge-info"> {{ user.phone }}</span>
                      </h4>
                    </td>
                    <td>
                      <h5>
                        <span
                          v-for="role in user.roles"
                          :key="role.id"
                          class="badge badge-success mr-1"
                          >{{ translate("admin." + role.name) }}</span
                        >
                      </h5>
                    </td>

                    <td>{{ user.created_at | formatDate }}</td>

                    <td>
                      <a
                        href="#"
                        @click.prevent="handleClickAddressBtn(user.id)"
                        data-toggle="modal"
                        data-target="#addressListModal"
                        class="mr-4"
                        ><i class="fa fa-map-marker-alt text-info"></i
                      ></a>
                      <router-link
                        class="mr-4"
                        :to="{
                          name: 'users.edit',
                          params: { id: user.id },
                        }"
                        ><i class="fa fa-pen text-success"></i
                      ></router-link>
                      <a href="#" @click.prevent="deleteUser(user.id)"
                        ><i class="fa fa-trash text-danger"></i
                      ></a>
                    </td>
                  </tr>
                </tbody>
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
import AddressList from "../addresses/AddressList.vue";

export default {
  mixins: [dataTableMixin],
  components: {
    AddressList,
  },
  data() {
    return {
      selectedItems: [],
      allSelected: false,
      clickedUserId: null,
    };
  },
  watch: {
    selectedItems() {
      this.allSelected =
        this.selectedItems.length === this.allUsers.length ? true : false;
    },
  },
  computed: {
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },

    ...mapGetters("users", ["allUsers", "isLoading"]),
  },
  methods: {
    handleClickAddressBtn(userId) {
      this.clickedUserId = userId;
    },
    selectOrUnSelectAll() {
      if (this.allSelected) {
        this.selectedItems = [];
      } else {
        this.allUsers.forEach((user) => {
          this.selectedItems.push(user.id);
        });
      }
    },
    prepareBulkDeleteUsers() {
      if (!this.selectedItems.length) {
        return;
      }
      fireConfirm(async () => {
        await this.bulkDeleteUsers(this.selectedItems);
        this.selectedItems = [];
      });
    },
    ...mapActions("users", ["fetchUsers", "deleteUser", "bulkDeleteUsers"]),
  },

  created() {
    this.fetchUsers();
  },
};
</script>
