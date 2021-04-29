<template>
  <div class="row mt-4">
    <div class="col-md-12 col-xl-5">
      <div class="business-hours">
        <!-- <div class="w-100 text-light" style="position : absolute ; z-index : 100 ; top : 40% ; left : 30%">
          <h4 class="m-auto">
             <i class="fa fa-ban fa-lg"></i>  {{translate('admin.forcedClose')}}
          </h4>

        </div> -->
        <div
          class="w-100"
          style="position: absolute; top: 45%; left: 44%; z-index: 1000"
        >
          <loading
            color="#2B51C4"
            :active.sync="schedule.forcedClose"
            :is-full-page="false"
          >
            <h4 class="text-dark">
              <i class="fa fa-ban fa-4x text-danger"></i>
            </h4>
          </loading>
        </div>
        <div :class="{ 'low-opacity': schedule.forcedClose }">
          <h2 class="title">{{ translate("admin.openingHours") }}</h2>
          <ul class="list-unstyled opening-hours">
            <li
              v-for="(value, key) in schedule.openingHours"
              :key="key"
              class="text-capitalize"
            >
              {{ translate(`admin.${key}`) }}
              <span class="float-right" v-if="value[0]"
                >{{ value[0] }} {{ value[1] ? `/ ${value[1]}` : "" }}</span
              >
              <span class="float-right" v-else>{{
                translate("admin.closed")
              }}</span>
            </li>
          </ul>
        </div>
      </div>
      <button
        :disabled="loading"
        v-if="formChanged"
        @click="handleSubmit"
        class="btn btn-warning btn-block"
      >
        <i v-if="loading" class="fa fa-circle-notch fa-spin mr-1"></i>
        {{ translate("admin.save") }}
      </button>
    </div>
    <div class="col-md-12 col-xl-7">
      <form class="">
        <h3 class="text-center mb-4">
          {{ translate("admin.addOpeningHours") }}
        </h3>
        <div
          class="form-row d-flex justify-content-between py-4 px-3"
          :class="{ 'red-border': $v.selectedDays.$error }"
        >
          <div
            class="form-check mr-2"
            v-for="(day, index) in allDays"
            :key="index"
          >
            <label class="form-check-label text-capitalize">
              <input
                v-model="selectedDays"
                :value="day"
                class="form-check-input"
                type="checkbox"
              />
              {{ translate(`admin.${day}`) }}
              <span class="form-check-sign">
                <span class="check"></span>
              </span>
            </label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <form-group :validator="$v.start1" name="start">
              <input
                type="time"
                v-model.trim="$v.start1.$model"
                @input="$v.start1.$touch()"
                class="form-control"
              />
            </form-group>
          </div>
          <div class="col-md-6">
            <form-group :validator="$v.end1" name="end">
              <input
                type="time"
                v-model.trim="$v.end1.$model"
                @input="$v.end1.$touch()"
                class="form-control"
              />
            </form-group>
          </div>
        </div>
        <h6>
          {{ translate("admin.splitHours") }} ({{
            translate("admin.optional")
          }})
        </h6>
        <div class="row">
          <div class="col-md-6">
            <form-group :validator="$v.start2" name="start">
              <input
                type="time"
                v-model.trim="$v.start2.$model"
                @input="$v.start2.$touch()"
                class="form-control"
              />
            </form-group>
          </div>
          <div class="col-md-6">
            <form-group :validator="$v.end2" name="end">
              <input
                type="time"
                v-model.trim="$v.end2.$model"
                @input="$v.end2.$touch()"
                class="form-control"
              />
            </form-group>
          </div>
        </div>

        <a class="text-success mr-4" href="#" @click.prevent="handleSave"
          ><u> <i class="fa fa-plus"></i> {{ translate("admin.save") }}</u></a
        >
        <a class="text-danger" href="#" @click.prevent="handleSetAsClosed"
          ><u>
            <i class="fa fa-times"></i> {{ translate("admin.setAsClosed") }}</u
          ></a
        >
        <div class="form-group" style="margin-bottom: -22px">
          <label style="margin-bottom: -30px"
            >{{ translate("admin.forcedClose") }} ({{
              translate("admin.forcedCloseText")
            }}) :
          </label>

          <toggle-button
            v-model="schedule.forcedClose"
            :value="schedule.forcedClose"
            :sync="true"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { required, requiredIf } from "vuelidate/lib/validators";
import { fireAlert, fireToast } from "../../helpers";

export default {
  props: ["scheduleSettings"],
  data() {
    return {
      formChanged: false,
      loading: false,
      allDays: [
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday",
        "saturday",
        "sunday",
      ],
      selectedDays: [],
      start1: "08:00",
      end1: "17:00",
      start2: "",
      end2: "",
      schedule: { ...this.scheduleSettings },
    };
  },
  validations: {
    selectedDays: {
      required,
    },
    start1: {
      required,
    },
    end1: {
      required,
    },
    start2: {
      required: requiredIf(function (nested) {
        return nested.end2.length;
      }),
    },
    end2: {
      required: requiredIf(function (nested) {
        return nested.start2.length;
      }),
    },
  },
  watch: {
    schedule: {
      handler() {
        this.formChanged = true;
      },
      deep: true,
    },
  },
  methods: {
    handleSubmit() {
      this.loading = true;
      axios
        .post("/api/settings/schedule", this.schedule)
        .then((res) => {
          fireToast(
            "success",
            translate("admin.updated", { item: translate("admin.settings") })
          );
          this.formChanged = false;
        })
        .catch((err) => {
          if (err.response.status == 400) {
            fireAlert("error", err.response.data.error);
          } else {
            fireToast("danger", translate("front.errorMessage"));
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    handleSetAsClosed() {
      this.$v.selectedDays.$touch();
      this.selectedDays.forEach((day) => {
        this.$set(this.schedule.openingHours, day, []);
      });
    },
    handleSave() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.selectedDays.forEach((day) => {
          this.$set(this.schedule.openingHours, day, [
            this.start1 + "-" + this.end1,
          ]);
          if (this.start2.length && this.end2.length) {
            this.$set(this.schedule.openingHours, day, [
              ...this.schedule.openingHours[day],
              this.start2 + "-" + this.end2,
            ]);
          }
        });
      }
    },
  },
  mounted() {},
};
</script>

<style>
.low-opacity {
  opacity: 0.4;
}
.red-border {
  border: 1px solid red !important;
  border-radius: 10px;
}

.business-hours {
  border-radius: 3px !important;
  background: #222;
  padding: 40px 14px;
  margin-top: -15px;
  position: relative;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.356),
    0 3px 1px -2px rgba(0, 0, 0, 0.534), 0 1px 5px 0 rgba(0, 0, 0, 0.548);
}
.business-hours:before {
  content: "";
  width: 23px;
  height: 23px;
  background: #111;
  position: absolute;
  top: 5px;
  left: -12px;
  transform: rotate(-45deg);
  z-index: -1;
}
.business-hours .title {
  font-size: 20px;
  color: #bbb;
  text-transform: uppercase;
  padding-left: 5px;
  border-left: 4px solid #ffac0c;
}
.business-hours li {
  color: #888;
  line-height: 30px;
  border-bottom: 1px solid #333;
}
.business-hours li:last-child {
  border-bottom: none;
}
.business-hours .opening-hours li.today {
  color: #ffac0c;
}
</style>
