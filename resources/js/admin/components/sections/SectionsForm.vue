<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">CMS</li>
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
                <i class="material-icons">create</i>
              </div>
              <h4 class="card-title">CMS</h4>
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
              <div class="form-group row">
                <div class="col-md-6 d-flex">
                  <span class="input-group-text mr-2">
                    <i class="material-icons">fingerprint</i>
                  </span>
                  <multiselect
                    v-model="selectedSection"
                    :options="allSections"
                    :close-on-select="true"
                    :clear-on-select="true"
                    :preserve-search="true"
                    :placeholder="translate('admin.select') + ' Section'"
                    :show-labels="false"
                    :allow-empty="false"
                    label="name"
                    track-by="id"
                  ></multiselect>
                </div>
              </div>
              <div v-for="(locale, index) in availableLocales" :key="index">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">title</i>
                      </span>
                    </div>
                    <input
                      type="text"
                      v-model="selectedSection['title_' + locale]"
                      :placeholder="
                        printPlaceholder('title') + ` (${locale.toUpperCase()})`
                      "
                      class="form-control"
                    />
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="material-icons">content_copy</i>
                      </span>
                    </div>
                    <textarea
                      v-model="selectedSection['content_' + locale]"
                      rows="2"
                      :placeholder="
                        printPlaceholder('title') + ` (${locale.toUpperCase()})`
                      "
                      class="form-control"
                    ></textarea>
                  </div>
                </div>
              </div>

              <button
                type="submit"
                class="btn btn-warning btn-block"
                :disabled="postIsLoading || selectedSectionIsEmpty"
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

export default {
  data() {
    return {
      selectedSection: { name: translate("admin.select") + " Section" },
      availableLocales: window.availableLocales,
    };
  },
  computed: {
    selectedSectionIsEmpty() {
      return !this.selectedSection.id;
    },
    getIsLoading() {
      return this.isLoading["get"];
    },
    postIsLoading() {
      return this.isLoading["post"];
    },
    ...mapGetters("sections", ["allSections", "isLoading", "serverErrors"]),
  },
  methods: {
    handleSubmit() {
      this.updateSection(this.selectedSection);
    },
    ...mapActions("sections", ["fetchSections", "updateSection"]),
  },

  mounted() {
    this.fetchSections();
  },
};
</script>

<style>
</style>
