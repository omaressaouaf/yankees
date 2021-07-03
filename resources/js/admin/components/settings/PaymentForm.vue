<template>
  <form @submit.prevent="handleSubmit">
    <form-group :validator="$v.form.tax" name="tax">
      <label class="ml-5">{{ translate("admin.stripeEnabled") }}</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">credit_score</i>
          </span>
        </div>
        <toggle-button
          v-model.trim="$v.form.stripeEnabled.$model"
          :value="$v.form.stripeEnabled.$model"
          :sync="true"
        />
      </div>
    </form-group>

    <button class="btn btn-warning ml-5" :disabled="loading || !formChanged">
      <i v-if="loading" class="fa fa-circle-notch fa-spin mr-1"></i>
      {{ translate("admin.save") }}
    </button>
  </form>
</template>

<script>
import axios from "axios";
import { required } from "vuelidate/lib/validators";
import { fireToast } from "../../helpers";

export default {
  props: ["paymentSettings"],
  data() {
    return {
      form: this.paymentSettings,
      loading: false,
      formChanged: false,
    };
  },
  validations: {
    form: {
      stripeEnabled: {
        required,
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
    handleSubmit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.loading = true;
        axios
          .post("/api/settings/payment", this.form)
          .then((res) => {
            fireToast(
              "success",
              translate("admin.updated", { item: translate("admin.settings") })
            );
          })
          .catch((err) => {
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
