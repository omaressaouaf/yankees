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
                <i class="material-icons" v-if="isCreateMode">add_box</i>
                <i class="material-icons" v-else>create</i>
              </div>
              <h4 class="card-title" v-if="isCreateMode">
                {{ translate("admin.add") + " " + translate("admin.category") }}
              </h4>
              <h4 class="card-title" v-else>
                {{
                  translate("admin.edit") + " " + translate("admin.category")
                }}
              </h4>
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->

              <router-link :to="{ name: 'categories' }">
                <button class="btn btn-outline-danger mr-2">
                  <i class="fa fa-arrow-alt-circle-left"></i>
                  <span> {{ translate("admin.discard") }}</span>
                </button>
              </router-link>
            </div>
          </div>
          <div class="card-body">
            <div v-if="getIsLoading" class="text-center py-5">
              <vue-loaders-ball-scale-ripple-multiple
                color="#2B51C4"
                scale="1"
              ></vue-loaders-ball-scale-ripple-multiple>
            </div>
            <form @submit.prevent="handleSubmit" v-else>
              <server-error-alert
                :serverErrors="serverErrors"
                v-if="serverErrors"
              >
              </server-error-alert>
              <form-group :validator="$v.form.name" name="name">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">category</i>
                    </span>
                  </div>

                  <input
                    type="text"
                    @input="$v.form.name.$touch()"
                    :placeholder="printPlaceholder('name')"
                    class="form-control"
                    v-model.trim="$v.form.name.$model"
                  />
                </div>
              </form-group>
              <form-group :validator="$v.form.slug" name="slug">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">category</i>
                    </span>
                  </div>

                  <input
                    type="text"
                    @input="$v.form.slug.$touch()"
                    :placeholder="printPlaceholder('slug')"
                    class="form-control"
                    v-model.trim="$v.form.slug.$model"
                  />
                </div>
              </form-group>

              <button
                type="submit"
                class="btn btn-warning btn-block"
                v-if="isCreateMode"
                :disabled="postIsLoading"
              >
                <i v-if="postIsLoading" class="fa fa-circle-notch fa-spin"></i>
                Ajouter
              </button>
              <button
                type="submit"
                class="btn btn-warning btn-block"
                v-else
                :disabled="postIsLoading"
              >
                <i v-if="postIsLoading" class="fa fa-circle-notch fa-spin"></i>

                Sauvegarder
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
import { required } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      form: { name: "", slug: "" },
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      slug: {
        required,
      },
    },
  },
  watch: {
    categoryObject() {
      this.form = { ...this.form, ...this.categoryObject };
    },
  },
  computed: {
    isCreateMode() {
      return this.$route.name == "categories.create";
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("categories", [
      "categoryObject",
      "isLoading",
      "serverErrors",
    ]),
  },
  methods: {
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (this.isCreateMode) {
          this.addCategory(this.form);
        } else {
          this.updateCategory(this.form);
        }
      }
    },
    ...mapActions("categories", [
      "addCategory",
      "fetchCategory",
      "updateCategory",
    ]),
  },

  mounted() {
    this.$store.commit("categories/clearCategory");
    this.$store.commit("categories/clearServerErrors");
    if (!this.isCreateMode) {
      this.fetchCategory(this.$route.params.id);
    }
  },
};
</script>

<style>
</style>
