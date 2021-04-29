<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">{{ translate("admin.extras") }}</li>
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
                {{ translate("admin.add") + " " + translate("admin.extra") }}
              </h4>
              <h4 class="card-title" v-else>
                {{ translate("admin.edit") + " " + translate("admin.extra") }}
              </h4>
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->

              <router-link :to="{ name: 'extras' }">
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
              <form-group :validator="$v.form.name" name="name">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">fingerprint</i>
                    </span>
                  </div>

                  <input
                    type="text"
                    @input="$v.form.name.$touch()"
                    :placeholder="printPlaceholder('name') + ' (ex : panini-sauces)'"
                    class="form-control"
                    v-model.trim="$v.form.name.$model"
                  />
                </div>
              </form-group>
              <form-group :validator="$v.form.label" name="label">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">local_cafe</i>
                    </span>
                  </div>

                  <input
                    type="text"
                    @input="$v.form.label.$touch()"
                    :placeholder="printPlaceholder('label') + ' (ex : Panini Sauces)'"
                    class="form-control"
                    v-model.trim="$v.form.label.$model"
                  />
                </div>
              </form-group>
              <form-group :validator="$v.form.title" name="title">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="material-icons">title</i>
                    </span>
                  </div>

                  <input
                    type="text"
                    @input="$v.form.title.$touch()"
                    :placeholder="
                      printPlaceholder('title') + ' (ex : Choisissez vos sauces panini  )'
                    "
                    class="form-control"
                    v-model.trim="$v.form.title.$model"
                  />
                </div>
              </form-group>

              <br />
              <div class="mx-5">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">
                      {{ translate("admin.add") }} Options
                    </h4>
                  </div>
                  <div class="card-body">
                    <div
                      class="alert alert-danger"
                      v-if="optionsError || $v.form.options.$error"
                    >
                      <strong
                        ><i class="fa fa-exclamation-circle text-light"></i
                      ></strong>
                      {{ optionsError }}
                    </div>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="material-icons">flaky</i>
                              </span>
                            </div>

                            <input
                              type="text"
                              :placeholder="printPlaceholder('name')"
                              class="form-control"
                              v-model.trim="optionsForm.name"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="material-icons">attach_money</i>
                              </span>
                            </div>

                            <input
                              type="number"
                              :placeholder="printPlaceholder('price')"
                              class="form-control"
                              v-model="optionsForm.price"
                            />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group mb-5">
                          <button
                            type="button"
                            class="btn btn-warning btn-round"
                            @click="addOption"
                          >
                            <i class="material-icons">add</i>
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6" v-if="this.form.options.length">
                        <h6 class="ml-4 px-3">
                          {{ translate("admin.oldOptions") }}
                        </h6>
                        <ul class="">
                          <li
                            class="d-flex d-flex"
                            v-for="(option, index) in this.form.options"
                            :key="index"
                          >
                            <h5>
                              {{ option.name }}
                              <span class="text-muted"
                                >{{ option.price }} DH</span
                              >
                            </h5>
                            <a
                              href="#"
                              @click.prevent="deleteOldOption(option.id)"
                              ><i class="material-icons text-danger ml-2 mb-3"
                                >delete</i
                              ></a
                            >
                          </li>
                        </ul>
                      </div>
                      <div class="col-md-6" v-if="this.form.newOptions.length">
                        <h6 class="ml-4 px-3">
                          {{ translate("admin.newOptions") }}
                        </h6>
                        <ul class="">
                          <li
                            class="d-flex d-flex"
                            v-for="(option, index) in this.form.newOptions"
                            :key="index"
                          >
                            <h5>
                              {{ option.name }}
                              <span class="text-muted"
                                >{{ option.price }} DH</span
                              >
                            </h5>
                            <a href="#" @click.prevent="deleteNewOption(index)"
                              ><i class="material-icons text-danger ml-2 mb-3"
                                >delete</i
                              ></a
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

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
import { required, requiredIf } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      form: {
        name: "",
        label : '',
        title: "",
        options: [],
        deletedOptions: [],
        newOptions: [],
      },
      optionsForm: {
        name: "",
        price: 0,
      },
      optionsError: "",
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      label : {
        required
      },
      title: {
        required,
      },
      options: {
        required: false,
      },

      newOptions: {
        required: requiredIf(function () {
          return this.form.options.length === 0;
        }),
      },
    },
  },
  watch: {
    extraObject() {
      this.form = { ...this.form, ...this.extraObject };
    },
  },
  computed: {
    isCreateMode() {
      return this.$route.name == "extras.create";
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("extras", ["extraObject", "isLoading", "serverErrors"]),
  },
  methods: {
    addOption() {
      if (
        !this.optionsForm.name.length ||
        this.optionsForm.price < 0 ||
        this.optionsForm.price === ""
      ) {
        this.optionsError = translate("validation.required", {
          attribute:
            translate("validation.attributes.name") +
            " / " +
            translate("validation.attributes.price"),
        });
        return;
      }
      this.form.newOptions.push(this.optionsForm);
      this.optionsForm = { name: "", price: 0 };
      this.optionsError = "";
    },
    deleteOldOption(id) {
      this.form.options = this.form.options.filter(
        (option) => option.id !== id
      );
      this.form.deletedOptions.push(id);
    },
    deleteNewOption(index) {
      this.form.newOptions.splice(index, 1);
    },
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (this.isCreateMode) {
          this.addExtra(this.form);
        } else {
          this.updateExtra(this.form);
        }
      } else {
        this.optionsError = this.$v.form.newOptions.$error
          ? translate("validation.required", { attribute: " 1 Option" })
          : "";
      }
    },
    ...mapActions("extras", ["addExtra", "fetchExtra", "updateExtra"]),
  },

  mounted() {
    this.$store.commit("extras/clearExtra");
    this.$store.commit("extras/clearServerErrors");
    if (!this.isCreateMode) {
      this.fetchExtra(this.$route.params.id);
    }
  },
};
</script>

<style>
</style>
