<template>
  <form @submit.prevent="handleSubmit">
    <div class="row">
      <div class="col-md-4">
        <form-group :validator="$v.form.price" name="price">
          <label class="ml-5">{{ translate("admin.price") }}</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">attach_money</i>
              </span>
            </div>
            <input
              type="number"
              @input="$v.form.price.$touch()"
              class="form-control"
              v-model.trim="$v.form.price.$model"
            />
          </div>
        </form-group>
        <form-group :validator="$v.form.time" name="time">
          <label class="ml-5">{{ translate("admin.time") }}</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">watch_later</i>
              </span>
            </div>
            <input
              type="number"
              @input="$v.form.time.$touch()"
              class="form-control"
              v-model.trim="$v.form.time.$model"
            />
          </div>
        </form-group>
        <button
          class="btn btn-warning ml-5"
          :disabled="loading || !formChanged"
        >
          <i v-if="loading" class="fa fa-circle-notch fa-spin mr-1"></i>
          {{ translate("admin.save") }}
        </button>
      </div>
      <div class="col-md-8">
        <map-box-gl
          @map-load="mapLoaded"
          :map-options="{
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [
              deliveryZoneBounds.south_west.longitude,
              deliveryZoneBounds.south_west.latitude,
            ],
            zoom: 6,
          }"
        />
      </div>
    </div>
  </form>
</template>

<script>
import axios from "axios";
import { required, integer, minValue } from "vuelidate/lib/validators";
import { fireAlert, fireToast } from "../../helpers";
import MapBoxGl from "../partials/MapBoxGl";

export default {
  components: {
    MapBoxGl,
  },
  props: ["deliverySettings"],
  data() {
    return {
      deliveryZoneBounds: this.$store.state.deliveryZoneBounds,
      form: { ...this.deliverySettings, newZoneBounds: null },
      loading: false,
      formChanged: false,
    };
  },
  validations: {
    form: {
      price: {
        required,
        integer,
        minValue: minValue(0),
      },
      time: {
        required,
        integer,
        minValue: minValue(0),
      },
    },
  },
  computed: {},
  watch: {
    form: {
      handler() {
        this.formChanged = true;
      },
      deep: true,
    },
  },
  methods: {
    mapLoaded(map) {
      this.map = map;
      // resize the map if the tab opens up before it loads
      this.map.resize();
      // if the tab opens up after it loads
      $('a[data-toggle="tab"]').on("shown.bs.tab", (e) => {
        if (e.target.getAttribute("href") == "#delivery") {
          this.map.resize();
        }
      });

      // create polygon using turf
      const polygon = turf.bboxPolygon([
        this.form.zone_bounds.south_west.longitude,
        this.form.zone_bounds.south_west.latitude,
        this.form.zone_bounds.north_east.longitude,
        this.form.zone_bounds.north_east.latitude,
      ]);

      // Add a data source containing GeoJSON data.
      map.addSource("delivery", {
        type: "geojson",
        data: { ...polygon },
      });

      // Add a new layer to visualize the polygon.
      this.map.addLayer({
        id: "delivery",
        type: "fill",
        source: "delivery", // reference the data source
        layout: {},
        paint: {
          "fill-color": "#0080ff", // blue color fill
          "fill-opacity": 0.5,
        },
      });
      // Add a black outline around the polygon.
      this.map.addLayer({
        id: "outline",
        type: "line",
        source: "delivery",
        layout: {},
        paint: {
          "line-color": "#000",
          "line-width": 3,
        },
      });

      //  add a drawer to edit the delivery zone
      this.draw = new MapboxDraw({
        displayControlsDefault: false,
        controls: {
          polygon: true,
          trash: true,
        },
        // defaultMode: "draw_polygon",
      });
      this.map.addControl(this.draw);
      this.map.on("draw.create", this.handleDraw);
      this.map.on("draw.update", this.handleDraw);
      this.map.on("draw.delete", this.handleDraw);
      this.map.on("draw.selectionchange", this.handleDraw);
    },
    handleDraw(e) {
      if (e.type == "draw.delete") {
        this.form.newZoneBounds = null;
        return;
      }
      const bbox = turf.bbox(this.draw.getSelected());
      this.form.newZoneBounds = {
        south_west: {
          longitude: bbox[0],
          latitude: bbox[1],
        },
        north_east: {
          longitude: bbox[2],
          latitude: bbox[3],
        },
      };
    },
    handleSubmit() {
      if (
        this.draw.getAll().features.length &&
        !this.draw.getSelected().features.length
      ) {
        fireAlert("error", translate("admin.selectPolygon"));
        return;
      }
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.loading = true;
        axios
          .post("/api/settings/delivery", this.form)
          .then((res) => {
            fireToast(
              "success",
              translate("admin.updated", { item: translate("admin.settings") })
            );
            const polygon = turf.bboxPolygon([
              res.data.zone_bounds.south_west.longitude,
              res.data.zone_bounds.south_west.latitude,
              res.data.zone_bounds.north_east.longitude,
              res.data.zone_bounds.north_east.latitude,
            ]);
            this.map.getSource("delivery").setData({
              ...polygon,
            });
            this.form.zone_bounds = res.data.zone_bounds;
            this.$store.commit("setDeliveryZoneBounds", res.data.zone_bounds, {
              root: true,
            });
            this.draw.deleteAll();
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

  mounted() {},
};
</script>

<style scoped>
#map {
  height: 500px;
}
</style>
