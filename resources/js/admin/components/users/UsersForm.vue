<template>
  <div class="container-fluid">
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
                <i class="material-icons" v-if="isCreateMode">add_box</i>
                <i class="material-icons" v-else>create</i>
              </div>
              <h4 class="card-title" v-if="isCreateMode">
                {{ translate("admin.add") + " " + translate("admin.user") }}
              </h4>
              <h4 class="card-title" v-else>
                {{ translate("admin.edit") + " " + translate("admin.user") }}
              </h4>
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->

              <router-link :to="{ name: 'users' }">
                <button class="btn btn-outline-danger mr-2">
                  <i class="fa fa-arrow-alt-circle-left"></i>
                  <span> {{ translate("admin.discard") }}</span>
                </button>
              </router-link>
            </div>
          </div>
          <div class="card-body">
            <div v-if="getIsLoading" class="text-center">
              <loading
                loader="dots"
                color="#2B51C4"
                :active.sync="getIsLoading"
                :is-full-page="false"
                :width="80"
                :height="200"
              />
            </div>
            <form @submit.prevent="handleSubmit" v-else>
              <server-error-alert
                :serverErrors="serverErrors"
                v-if="serverErrors"
              >
              </server-error-alert>
              <div class="row mb-1">
                <div class="col-md-6">
                  <form-group :validator="$v.form.name" name="name">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">account_circle</i>
                        </span>
                      </div>
                      <input
                        type="text"
                        :placeholder="printPlaceholder('name')"
                        class="form-control"
                        v-model.trim="$v.form.name.$model"
                        @input="$v.form.name.$touch()"
                      />
                    </div>
                  </form-group>
                </div>
                <div class="col-md-6">
                  <form-group :validator="$v.form.email" name="email">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input
                        type="email"
                        :placeholder="printPlaceholder('email')"
                        class="form-control"
                        v-model.trim="$v.form.email.$model"
                        @input="$v.form.email.$touch()"
                      />
                    </div>
                  </form-group>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <form-group :validator="$v.form.phone" name="phone">
                    <div class="input-group form-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">call</i>
                        </span>
                      </div>
                      <input
                        type="text"
                        :placeholder="printPlaceholder('phone')"
                        class="form-control"
                        v-model.trim="$v.form.phone.$model"
                        @input="$v.form.phone.$touch()"
                      />
                    </div>
                  </form-group>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6" v-if="isCreateMode">
                  <form-group :validator="$v.form.password" name="password">
                    <div class="input-group form-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">vpn_key</i>
                        </span>
                      </div>
                      <input
                        type="password"
                        :placeholder="printPlaceholder('password')"
                        class="form-control"
                        v-model.trim="$v.form.password.$model"
                        @input="$v.form.password.$touch()"
                      />
                    </div>
                  </form-group>
                </div>
                <div class="col-md-6">
                  <form-group
                    class="ml-5"
                    :validator="$v.form.role"
                    name="role"
                  >
                    <multiselect
                      v-model.trim="$v.form.role.$model"
                      :options="roles"
                      :close-on-select="true"
                      :clear-on-select="true"
                      :preserve-search="true"
                      :placeholder="
                        translate('admin.select') +
                        ' ' +
                        translate('validation.attributes.role')
                      "
                      :custom-label="customLabel"
                      :show-labels="false"
                    >
                      <template slot="option" slot-scope="props">
                        <div class="option__desc">
                          <span class="option__title">{{
                            translate("admin." + props.option)
                          }}</span>
                        </div>
                      </template>
                    </multiselect>
                  </form-group>
                </div>
              </div>
              <button
                type="submit"
                class="btn btn-warning btn-block"
                v-if="isCreateMode"
                :disabled="postIsLoading"
              >
                <i v-if="postIsLoading" class="fa fa-circle-notch fa-spin"></i>
                {{ translate("admin.add") }}
              </button>
              <button
                type="submit"
                class="btn btn-warning btn-block"
                v-else
                :disabled="postIsLoading"
              >
                <i v-if="postIsLoading" class="fa fa-circle-notch fa-spin"></i>

                {{ translate("admin.save") }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import {
  required,
  email,
  minLength,
  requiredIf,
} from "vuelidate/lib/validators";

export default {
  components: {},
  data() {
    return {
      roles: ["client", "deliveryman", "admin"],
      form: {
        name: "",
        email: "",
        phone: "",
        password: "",
        role: "",
      },
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      email: {
        required,
        email,
      },
      phone: {
        required,
      },
      password: {
        required: requiredIf(function () {
          return this.isCreateMode;
        }),
        minLength: minLength(8),
      },
      role: {
        required,
      },
    },
  },
  watch: {
    userObject() {
      this.form = { ...this.form, ...this.userObject };
    },
  },
  computed: {
    isCreateMode() {
      return this.$route.name == "users.create";
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("users", ["userObject", "isLoading", "serverErrors"]),
  },
  methods: {
    customLabel(option) {
      return translate("admin." + option);
    },
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (this.isCreateMode) {
          this.addUser(this.form);
        } else {
          this.updateUser(this.form);
        }
      }
    },
    ...mapActions("users", ["addUser", "fetchUser", "updateUser"]),
  },

  mounted() {
    this.$store.commit("users/clearUser");
    this.$store.commit("users/clearServerErrors");
    if (!this.isCreateMode) {
      this.fetchUser(this.$route.params.id);
    }
  },
};
</script>

<style>
</style>
