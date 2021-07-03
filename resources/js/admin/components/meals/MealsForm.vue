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
                <i class="material-icons" v-if="isCreateMode">add_box</i>
                <i class="material-icons" v-else>create</i>
              </div>
              <h4 class="card-title" v-if="isCreateMode">
                {{ translate("admin.add") + " " + translate("admin.menu") }}
              </h4>
              <h4 class="card-title" v-else>
                {{ translate("admin.edit") + " " + translate("admin.menu") }}
              </h4>
            </div>
            <div class="mt-2">
              <!-- <button class="btn btn-secondary"> <i class="fa fa-sync-alt"></i> </button> -->

              <router-link :to="{ name: 'meals' }">
                <button class="btn btn-outline-danger mr-2">
                  <i class="fa fa-arrow-alt-circle-left"></i>
                  <span> {{ translate("admin.discard") }}</span>
                </button>
              </router-link>
            </div>
          </div>
          <div class="card-body">
            <server-error-alert
              :serverErrors="serverErrors"
              v-if="serverErrors"
            >
            </server-error-alert>
            <div v-if="getIsLoading" class="text-center py-5">
              <vue-loaders-ball-scale-ripple-multiple
                color="#2B51C4"
                scale="1"
              ></vue-loaders-ball-scale-ripple-multiple>
            </div>

            <form-wizard
              v-else
              title=""
              subtitle=""
              color="#55AE59"
              @on-complete="handleSubmit"
            >
              <tab-content
                :title="translate('admin.generalInfo')"
                icon="fa fa-hamburger"
                :before-change="() => validateStep(1)"
              >
                <div class="row mb-1">
                  <div class="col-md-6">
                    <form-group :validator="$v.form.title" name="title">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">lunch_dining</i>
                          </span>
                        </div>
                        <input
                          type="text"
                          :placeholder="printPlaceholder('title')"
                          class="form-control"
                          v-model.trim="$v.form.title.$model"
                          @input="$v.form.title.$touch()"
                        />
                      </div>
                    </form-group>
                  </div>
                  <div class="col-md-6">
                    <form-group :validator="$v.form.price" name="price">
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
                          v-model.trim="$v.form.price.$model"
                          @input="$v.form.price.$touch()"
                        />
                      </div>
                    </form-group>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col-md-6">
                    <form-group :validator="$v.form.desc" name="description">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">info</i>
                          </span>
                        </div>
                        <textarea
                          type="text"
                          :placeholder="
                            printPlaceholder('description') +
                            ' (' +
                            translate('admin.optionalFem') +
                            ')'
                          "
                          class="form-control"
                          v-model.trim="$v.form.desc.$model"
                          @input="$v.form.desc.$touch()"
                        ></textarea>
                      </div>
                    </form-group>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group form-file-upload form-file-simple">
                      <input
                        type="file"
                        class="inputFileHidden"
                        @change="handleFileChange"
                      />
                      <div class="input-group">
                        <span class="input-group-btn">
                          <button
                            type="button"
                            class="btn btn-fab btn-round btn-warning"
                          >
                            <i
                              class="material-icons"
                              onclick="$('.inputFileHidden').click()"
                              >attach_file</i
                            >
                          </button>
                        </span>
                        <input
                          type="text"
                          disabled
                          class="form-control inputFileVisible"
                          :placeholder="
                            printPlaceholder('image') +
                            ' (' +
                            translate('admin.optionalFem') +
                            ')'
                          "
                        />
                        <span class="input-group-btn" v-if="newImage">
                          <button
                            type="button"
                            class="btn btn-fab btn-round btn-danger"
                          >
                            <i class="material-icons" @click="cancelImage"
                              >close</i
                            >
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <form-group
                      class="ml-5"
                      :validator="$v.selectedCategory"
                      name="category_id"
                    >
                      <multiselect
                        v-model.trim="$v.selectedCategory.$model"
                        :options="allCategories"
                        :close-on-select="true"
                        :clear-on-select="true"
                        :preserve-search="true"
                        :placeholder="
                          translate('admin.select') +
                          ' ' +
                          translate('validation.attributes.category_id')
                        "
                        label="name"
                        track-by="id"
                      ></multiselect>
                    </form-group>
                    <p
                      class="text-small text-small text-danger ml-5"
                      v-if="!isCreateMode && !form.category_id"
                    >
                      <i class="fa fa-info-circle"></i>
                      {{ translate("admin.noCategoryForMeal") }}
                    </p>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group ml-5" style="margin-bottom: -22px">
                      <label style="margin-bottom: -30px"
                        >{{ translate("admin.active") }} :
                      </label>

                      <toggle-button
                        v-model.trim="$v.form.active.$model"
                        :value="$v.form.active.$model"
                        :sync="true"
                      />
                    </div>
                  </div>
                  <div
                    class="col-lg-3 mt-4 ml-5 mt-lg-0 ml-lg-0"
                    v-if="!isCreateMode"
                  >
                    <img
                      :src="form.resizedImage"
                      width="100"
                      height="100"
                      class="img-fluid rounded"
                      alt=""
                    />
                  </div>
                </div>
              </tab-content>
              <tab-content
                :title="
                  translate('admin.add') + ' ' + translate('admin.extras')
                "
                icon="fa fa-coffee"
                :before-change="() => validateStep(2)"
              >
                <div class="row" v-if="allExtras.length">
                  <div
                    class="col-md-4"
                    v-for="extra in allExtras"
                    :key="extra.id"
                  >
                    <div class="card" id="extra-card">
                      <div
                        class="text-center card-header"
                        :class="[
                          singleExtraPath(extra.id)
                            ? 'card-header-success'
                            : ' card-header-warning',
                        ]"
                      >
                        <h4 class="card-title row">
                          <span class="col-md-9"
                            ><router-link
                              :to="{
                                name: 'extras.edit',
                                params: { id: extra.id },
                              }"
                            >
                              {{ extra.name }}
                            </router-link></span
                          >
                          <a
                            href="#"
                            class="float-right col-md-3"
                            @click.prevent="handleToggleExtra(extra)"
                          >
                            <i
                              class="material-icons"
                              v-if="singleExtraPath(extra.id)"
                              >check_box</i
                            >
                            <i class="material-icons" v-else
                              >check_box_outline_blank
                            </i>
                          </a>
                        </h4>
                      </div>
                      <transition
                        name="transition"
                        enter-active-class="animated animate__fadeIn"
                      >
                        <div class="card-body" v-if="singleExtraPath(extra.id)">
                          <p class="text-small text-muted">
                            {{ translate("admin.title") }} :
                            {{ extra.title }}
                          </p>

                          <form-group
                            :validator="
                              $v.form.extras.$each.$iter[
                                findExtraIndex(extra.id)
                              ].pivot.min
                            "
                            name="min"
                          >
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">remove</i>
                                </span>
                              </div>

                              <input
                                @input="
                                  $v.form.extras.$each.$iter[
                                    findExtraIndex(extra.id)
                                  ].pivot.min.$touch()
                                "
                                type="number"
                                :placeholder="printPlaceholder('min')"
                                class="form-control"
                                v-model.trim="
                                  singleExtraPath(extra.id).pivot.min
                                "
                              />
                            </div>
                          </form-group>

                          <form-group
                            :validator="
                              $v.form.extras.$each.$iter[
                                findExtraIndex(extra.id)
                              ].pivot.max
                            "
                            name="max"
                          >
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">add</i>
                                </span>
                              </div>

                              <input
                                @input="
                                  $v.form.extras.$each.$iter[
                                    findExtraIndex(extra.id)
                                  ].pivot.max.$touch()
                                "
                                type="number"
                                :placeholder="printPlaceholder('max')"
                                class="form-control"
                                v-model.trim="
                                  singleExtraPath(extra.id).pivot.max
                                "
                              />
                            </div>
                          </form-group>
                          <div
                            v-for="option in extra.options"
                            :key="option.id"
                            class="form-check"
                          >
                            <label
                              class="form-check-label d-flex align-items-center flex-row"
                            >
                              <input
                                class="form-check-input"
                                type="checkbox"
                                v-model.trim="
                                  singleExtraPath(extra.id).pivot
                                    .admin_selected_options
                                "
                                @change="checkOptionsLeft(extra.id)"
                                :value="option.id"
                              />
                              {{ option.name }} : {{ option.price }} dhs

                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </div>
                      </transition>
                      <div class="card-footer">
                        <div class="stats text-center">
                          <i class="material-icons">edit</i>
                          <span v-if="singleExtraPath(extra.id)">
                            {{
                              singleExtraPath(extra.id).pivot
                                .admin_selected_options.length
                            }}
                            {{ extra.name }} Option(s)
                            {{ translate("admin.for") }}
                            {{ translate("admin.thisFem") }} Menu</span
                          >
                          <span v-else>{{
                            translate("admin.selectToAdd")
                          }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <div class="alert alert-info">
                    <strong
                      ><i class="fa fa-exclamation-circle text-light"></i
                    ></strong>

                    {{ translate("admin.noExtras") }}

                    <router-link
                      class="btn-link"
                      :to="{ name: 'extras.create' }"
                      >{{
                        translate("admin.add") + " " + translate("admin.new")
                      }}
                    </router-link>
                  </div>
                </div>
              </tab-content>
              <button slot="prev" class="btn btn-warning">
                {{ translate("admin.previous") }}
              </button>
              <button slot="next" class="btn btn-warning">
                {{ translate("admin.next") }}
              </button>
              <button
                slot="finish"
                :disabled="postIsLoading"
                class="btn btn-warning"
              >
                <i v-if="postIsLoading" class="fa fa-circle-notch fa-spin"></i>
                {{
                  isCreateMode
                    ? translate("admin.add")
                    : translate("admin.save")
                }}
              </button>
            </form-wizard>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import { mapGetters, mapActions } from "vuex";
import { FormWizard, TabContent } from "vue-form-wizard";
import { required, integer, minValue } from "vuelidate/lib/validators";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
  data() {
    return {
      selectedCategory: "",
      newImage: null,
      form: {
        title: "",
        price: 0,
        category_id: "",
        active: false,
        desc: "",
        extras: [],
      },
    };
  },
  validations: {
    selectedCategory: {
      required,
    },
    newImage: {
      required: false,
    },
    form: {
      title: {
        required,
      },
      price: {
        required,
        minValue: minValue(0),
        integer,
      },
      category_id: {
        required: false,
      },
      active: {
        required,
      },
      desc: {
        required: false,
      },

      extras: {
        required: false,
        $each: {
          pivot: {
            min: {
              required,
              integer,
              minValue: minValue(0),
            },
            max: {
              required,
              integer,
              minValue: minValue(1),
              isBetweenTheMinAndAdminSelectedOptions: (maxValue, pivot) => {
                return (
                  maxValue >= pivot.min &&
                  maxValue <= pivot.admin_selected_options.length
                );
              },
            },
          },
        },
      },
    },
  },
  components: {
    FormWizard,
    TabContent,
  },
  watch: {
    mealObject() {
      this.form = { ...this.form, ...this.mealObject };
    },
  },
  computed: {
    isCreateMode() {
      return this.$route.name == "meals.create";
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("meals", ["mealObject", "isLoading", "serverErrors"]),
    ...mapGetters("categories", ["allCategories"]),
    ...mapGetters("extras", ["allExtras"]),
  },
  methods: {
    cancelImage() {
      $("#inputFileHidden").val("");
      $(".inputFileVisible").val("");
      this.newImage = null;
    },
    handleFileChange(e) {
      const file = e.target.files[0];
      $(".inputFileVisible").val(file.name);
      this.newImage = file;
    },
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        // create new formdata object
        let formData = new FormData();
        // appending the Image file to the formdata if the file is not null
        if (this.newImage !== null) {
          formData.append("newImage", this.newImage);
        }
        // appending all the form properties to the form data
        _.each(this.form, (value, key) => {
          if (key == "extras") {
            // because extras is an array end form data sends every thing as string so we stringify it in order to parse it in the backend
            formData.append(key, JSON.stringify(value));
          } else {
            formData.append(key, value);
          }
        });
        //to fit multiselect component
        if (this.selectedCategory) {
          formData.append("category_id", this.selectedCategory.id);
        }
        // and passing the form data instead of the product object
        if (this.isCreateMode) {
          this.addMeal(formData);
        } else {
          this.updateMeal(formData);
        }
      }
    },
    // validate form before change wizard step
    validateStep(step) {
      this.$v.$touch();
      // if the extras are invalid and the user navigates back to step 1 . and tries to navigate again to step2 he wont be able to . that's why we added this condition to check if there are some errors in extras to allow the user to go back and fix them.
      if (step == 1 && this.$v.form.extras.$each.$error) {
        return true;
      }
      return this.$v.$invalid ? false : true;
    },
    // check if the user checked out all options. if so remove the extra from the array
    checkOptionsLeft(extraId) {
      if (!this.singleExtraPath(extraId).pivot.admin_selected_options.length) {
        this.form.extras = this.form.extras.filter(
          (extra) => extra.id !== extraId
        );
      }
    },
    // returns a single extra path in the extras array
    singleExtraPath(id) {
      return this.$v.form.extras.$model[this.findExtraIndex(id)];
    },
    // toggle the state of extra(added /removed from/to)  the extras array
    handleToggleExtra(extra) {
      const id = extra.id;
      if (this.singleExtraPath(id)) {
        this.form.extras = this.form.extras.filter((extra) => extra.id !== id);
      } else {
        this.form.extras.push({
          ...extra,
          pivot: {
            admin_selected_options: extra.options.map((option) => option.id),
            min: 1,
            max: extra.options.length,
          },
        });
      }
    },
    // find extra index in the array (handy when binding the selected options checkboxes to a specific extra )
    findExtraIndex(id) {
      return this.form.extras.findIndex((extra) => extra.id === id);
    },
    ...mapActions("meals", ["addMeal", "updateMeal", "fetchMeal"]),
    ...mapActions("categories", ["fetchCategories"]),
    ...mapActions("extras", ["fetchExtras"]),
  },
  mounted() {
    this.$store.commit("meals/clearMeal");
    this.$store.commit("meals/clearServerErrors");
    if (!this.isCreateMode) {
      this.fetchMeal(this.$route.params.id).then(
        () => (this.selectedCategory = this.mealObject.category)
      );
    }
    this.fetchCategories();
    this.fetchExtras();
  },
};
</script>
<style scoped >
@import "https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css";
</style>



