<template>
  <form @submit.prevent="handleSubmit">
    <server-error-alert v-if="serverErrors" :server-errors="serverErrors" />

    <div class="row">
      <div class="col-md-6">
        <form-group :validator="$v.form.name" name="name">
          <label class="ml-5">{{ translate("admin.name") }}</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">dns</i>
              </span>
            </div>
            <input
              type="text"
              @input="$v.form.name.$touch()"
              class="form-control"
              v-model.trim="$v.form.name.$model"
            />
          </div>
          <small class="form-text text-muted ml-5"
            >{{ translate("admin.appNameDesc") }}.</small
          >
        </form-group>
      </div>
      <div class="col-md-4">
        <div class="form-group form-file-upload form-file-simple">
          <label class="ml-5">Logo</label>

          <input
            type="file"
            class="inputFileHidden"
            @change="handleFileChange"
          />
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" class="btn btn-fab btn-round btn-success">
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
              :placeholder="printPlaceholder('image')"
            />
            <span class="input-group-btn" v-if="form.newLogo">
              <button type="button" class="btn btn-fab btn-round btn-danger">
                <i class="material-icons" @click="clearLogo">close</i>
              </button>
            </span>
          </div>
          <small class="form-text text-muted ml-5">
            {{
              translate("admin.logoAdvice") +
              " " +
              translate("validation.attributes.max")
            }}: 1062 * 235.</small
          >
        </div>
      </div>
      <div class="col-md-2 mt-4">
        <img
          :src="$v.form.logo.$model"
          width="100"
          height="100"
          class="img-fluid rounded"
          alt=""
        />
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <form-group :validator="$v.form.contact.email" name="email">
          <label class="ml-5">Email</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">email</i>
              </span>
            </div>
            <input
              type="text"
              @input="$v.form.contact.email.$touch()"
              class="form-control"
              v-model.trim="$v.form.contact.email.$model"
            />
          </div>
        </form-group>
      </div>
      <div class="col-md-4">
        <form-group :validator="$v.form.contact.phone" name="phone">
          <label class="ml-5">{{
            translate("validation.attributes.phone")
          }}</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">call</i>
              </span>
            </div>
            <input
              type="text"
              @input="$v.form.contact.phone.$touch()"
              class="form-control"
              v-model.trim="$v.form.contact.phone.$model"
            />
          </div>
        </form-group>
      </div>
      <div class="col-md-4">
        <form-group :validator="$v.form.contact.address" name="address">
          <label class="ml-5">{{
            translate("validation.attributes.address")
          }}</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">place</i>
              </span>
            </div>
            <input
              type="text"
              @input="$v.form.contact.address.$touch()"
              class="form-control"
              v-model.trim="$v.form.contact.address.$model"
            />
          </div>
        </form-group>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <form-group
          :validator="$v.form.contact.social_media.facebook"
          name="facebook"
        >
          <label class="ml-5">Facebook</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">facebook</i>
              </span>
            </div>
            <input
              type="text"
              @input="$v.form.contact.social_media.facebook.$touch()"
              class="form-control"
              v-model.trim="$v.form.contact.social_media.facebook.$model"
            />
          </div>
        </form-group>
      </div>
      <div class="col-md-6">
        <form-group
          :validator="$v.form.contact.social_media.instagram"
          name="instagram"
        >
          <label class="ml-5">Instagram</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fab fa-instagram fa-lg"></i>
              </span>
            </div>
            <input
              type="text"
              @input="$v.form.contact.social_media.instagram.$touch()"
              class="form-control"
              v-model.trim="$v.form.contact.social_media.instagram.$model"
            />
          </div>
        </form-group>
      </div>
    </div>

    <button class="btn btn-warning ml-5" :disabled="loading || !formChanged">
      <i v-if="loading" class="fa fa-circle-notch fa-spin mr-1"></i>
      {{ translate("admin.save") }}
    </button>
  </form>
</template>

<script>
import axios from "axios";
import { required, email, url } from "vuelidate/lib/validators";
import { fireToast, imageIsValid } from "../../helpers";

export default {
  props: ["appSettings"],
  data() {
    return {
      serverErrors: null,
      form: { ...this.appSettings, newLogo: null },
      loading: false,
      formChanged: false,
    };
  },
  validations: {
    form: {
      name: {
        required,
      },
      logo: {
        required,
      },
      contact: {
        email: {
          required: false,
          email,
        },
        phone: {
          required: false,
        },
        address: {
          required: false,
        },
        social_media: {
          facebook: {
            required: false,
            url,
          },
          instagram: {
            required: false,
            url,
          },
        },
      },
    },
  },
  watch: {
    form: {
      handler() {
        this.formChanged = true;
      },
      deep: true,
    },
  },
  methods: {
    clearLogo() {
      $("#inputFileHidden").val("");
      $(".inputFileVisible").val("");
      this.form.newLogo = null;
    },
    handleFileChange(e) {
      const file = e.target.files[0];
      if (!imageIsValid(file)) return fireToast("danger", "Invalid Image");

      $(".inputFileVisible").val(file.name);
      this.form.newLogo = file;
    },
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.loading = true;
        // create new formdata object
        let formData = new FormData();
        // appending all the form properties to the form data
        _.each(this.form, (value, key) => {
          if (key == "contact") {
            // because contact is an object end form data sends every thing as string so we stringify it in order to parse it in the backend
            formData.append(key, JSON.stringify(value));
          } else {
            if (value !== null) {
              formData.append(key, value);
            }
          }
        });
        axios
          .post("/settings/app", formData)
          .then((res) => {
            fireToast(
              "success",
              translate("admin.updated", { item: translate("admin.settings") })
            );
            this.$store.commit("setAppName", this.form.name);

            if (this.form.newLogo !== null) {
              this.clearLogo();
              this.form.logo = res.data.logo;
              this.$store.commit("setAppLogo", res.data.logo);
            }
          })
          .catch((err) => {
            this.serverErrors = Object.values(err.response.data.errors) || null;
            fireToast("danger", translate("front.errorMessage"));
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },
  },
};
</script>

<style>
</style>
