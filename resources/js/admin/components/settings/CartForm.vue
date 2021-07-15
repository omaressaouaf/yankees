<template>
  <form @submit.prevent="handleSubmit">
    <form-group :validator="$v.form.tax" name="tax">
      <label class="ml-5">{{ translate("admin.tax") }}</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">trending_up</i>
          </span>
        </div>
        <input
          type="number"
          @input="$v.form.tax.$touch()"
          class="form-control"
          v-model.trim="$v.form.tax.$model"
        />
      </div>
    </form-group>
    <form-group :validator="$v.form.min_order_price" name="price">
      <label class="ml-5">{{ translate("admin.min_order_price") }}</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="material-icons">credit_score</i>
          </span>
        </div>
        <input
          type="number"
          @input="$v.form.min_order_price.$touch()"
          class="form-control"
          v-model.trim="$v.form.min_order_price.$model"
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
import {
  required,
  integer,
  minValue,
  maxValue,
} from "vuelidate/lib/validators";
import { fireToast } from "../../helpers";

export default {
  props: ["cartSettings"],
  data() {
    return {
      form: this.cartSettings,
      loading: false,
      formChanged: false,
    };
  },
  validations: {
    form: {
      tax: {
        required,
        integer,
        minValue: minValue(0),
        maxValue: maxValue(100),
      },
      min_order_price: {
        required,
        integer,
        minValue: minValue(0),
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
          .post("/settings/cart", this.form)
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
