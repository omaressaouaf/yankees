<template>
  <base-modal modal-id="addressSelectorModal">
    <form @submit.prevent="handleSubmit">
      <div class="container px-0 px-md-4 mt-2">
        <h2 class="modal-title font-weight-bold text-center">
          {{ translate("front.chooseAddress") }}
        </h2>
        <div class="row mt-4">
          <div class="col-md-12">
            <div id="map" class="mt-4">
              <map-box-gl
                @map-load="mapLoaded"
                :map-options="{
                  style: 'mapbox://styles/mapbox/streets-v11',
                  center: [
                    this.deliveryZoneBounds.south_west.longitude,
                    this.deliveryZoneBounds.south_west.latitude,
                  ],
                  zoom: 9,
                  maxBounds: this.mapBounds,
                }"
              />
            </div>

            <div class="input-group mt-3">
              <div class="bg-grey d-flex w-100">
                <button
                  @click="fetchCurrentAddress"
                  class="btn btn-success px-3 mr-2"
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Browser Location"
                  type="button"
                  :disabled="getLoading"
                >
                  <i class="fa fa-spinner fa-spin" v-if="getLoading"></i>

                  <i class="fa fa-map-marker-alt" v-else></i>
                </button>
                <p
                  v-if="address.line.length"
                  class="mt-2"
                  style="flex-basis: 90%"
                >
                  {{ address.line }}
                </p>
                <p v-else class="mt-2 text-muted" style="flex-basis: 90%">
                  {{ translate("front.chooseAddressText") }}
                </p>
              </div>
            </div>
            <div class="input-group mt-2">
              <div class="input-group-prepend">
                <div class="input-group-text px-3">
                  <i class="fa fa-info"></i>
                </div>
              </div>
              <input
                type="text"
                :placeholder="translate('front.addressDetails')"
                class="form-control"
                style="padding-bottom: 25px; padding-top: 20px"
                v-model="address.details"
              />
            </div>
          </div>
        </div>
      </div>
      <button
        :disabled="
          !address.line.length || !address.details.length || postLoading
        "
        type="submit"
        class="float-right mx-3 mt-3"
        :class="[applyFrontTheme ? 'btn-orange btn-square' : 'btn btn-warning']"
      >
        <i v-if="postLoading" class="fa fa-spinner fa-spin"></i>
        {{ translate("admin.add") }}
      </button>
    </form>
  </base-modal>
</template>

<script>
import axios from "axios";
import { fireAlert } from "../../helpers";
import BaseModal from "../partials/BaseModal.vue";
import MapBoxGl from "../partials/MapBoxGl.vue";
export default {
  components: { BaseModal, MapBoxGl },
  props: ["userId", "applyFrontTheme"],
  data() {
    return {
      token: process.env.MIX_MAPBOX_TOKEN,
      deliveryZoneBounds: this.$store.state.deliveryZoneBounds,
      getLoading: false,
      postLoading: false,
      address: {
        line: "",
        details: "",
        longitude: null,
        latitude: null,
      },
    };
  },
  computed: {
    mapBounds() {
      return [
        [
          this.deliveryZoneBounds.south_west.longitude,
          this.deliveryZoneBounds.south_west.latitude,
        ],
        [
          this.deliveryZoneBounds.north_east.longitude,
          this.deliveryZoneBounds.north_east.latitude,
        ],
      ];
    },
    geocoderBounds() {
      return [
        this.deliveryZoneBounds.south_west.longitude,
        this.deliveryZoneBounds.south_west.latitude,
        this.deliveryZoneBounds.north_east.longitude,
        this.deliveryZoneBounds.north_east.latitude,
      ];
    },
  },
  methods: {
    handleSubmit() {
      this.postLoading = true;
      axios
        .post(`/api/addresses?userId=${this.userId}`, this.address)
        .then((res) => {
          this.$emit("addressAdded", res.data.address);
          $("#addressSelectorModal").modal("hide");
          this.address.line = "";
          this.address.details = "";
        })
        .catch((err) => {
          if (err.response.data.errors.address) {
            fireAlert("error", translate("front.outOfDeliveryZone"));
          } else {
            fireAlert("error", translate("front.errorMessage"));
          }
        })
        .finally(() => {
          this.postLoading = false;
        });
    },
    setMarker(center) {
      if (this.marker) {
        this.marker.remove();
      }
      this.marker = new mapboxgl.Marker({
        draggable: true,
      })
        .setLngLat(center)
        .addTo(this.map);
      this.marker.on("dragend", this.markerDragged);
    },
    addressSelected({ result }) {
      this.setMarker(result.center);
      this.address.line = result.place_name;
      this.address.longitude = result.center[0];
      this.address.latitude = result.center[1];
    },
    async markerDragged() {
      this.getLoading = true;
      try {
        const lngLat = this.marker.getLngLat();
        this.address.line = await this.getAddressFromLatLong({
          longitude: lngLat.lng,
          latitude: lngLat.lat,
        });
        this.address.longitude = lngLat.lng;
        this.address.latitude = lngLat.lat;
        this.getLoading = false;
      } catch (err) {
        fireAlert("error", translate("front.errorMessage"));
      }
      this.getLoading = false;
    },
    mapLoaded(map) {
      this.map = map;
      // resize the map if the modal opens up before it loads
      this.map.resize();
      // if the modal opens up after it loads
      $("#addressSelectorModal").on("shown.bs.modal", () => {
        this.map.resize();
      });

      this.setMarker([this.map.getCenter().lng, this.map.getCenter().lat]);

      this.geocoder = new MapboxGeocoder({
        accessToken: this.token,
        mapboxgl: mapboxgl,
        // limit to morroco / casablanca settat
        countries: "ma",
        bbox: this.geocoderBounds,
        marker: false,
      });
      this.map.addControl(this.geocoder);
      this.geocoder.on("result", this.addressSelected);
    },
    fetchCurrentAddress() {
      if (!navigator.geolocation) {
        fireAlert(
          "error",
          fireAlert("error", translate("front.geolocationNotSupported"))
        );
        return;
      }
      this.getLoading = true;
      navigator.geolocation.getCurrentPosition(
        async (position) => {
          try {
            const southWest = new mapboxgl.LngLat(
              this.deliveryZoneBounds.south_west.longitude,
              this.deliveryZoneBounds.south_west.latitude
            );
            const northEast = new mapboxgl.LngLat(
              this.deliveryZoneBounds.north_east.longitude,
              this.deliveryZoneBounds.north_east.latitude
            );
            const boundingBox = new mapboxgl.LngLatBounds(southWest, northEast);
            if (
              !boundingBox.contains([
                position.coords.longitude,
                position.coords.latitude,
              ])
            ) {
              fireAlert("error", translate("front.outOfDeliveryZone"));
              this.getLoading = false;
              return;
            }
            this.address.line = await this.getAddressFromLatLong(
              position.coords
            );
            this.address.longitude = position.coords.longitude;
            this.address.latitude = position.coords.latitude;
            // $(".mapboxgl-ctrl-geocoder--input").val(this.address.line);

            this.map.flyTo({
              center: [this.address.longitude, this.address.latitude],
            });
            this.setMarker([this.address.longitude, this.address.latitude]);
          } catch (err) {

            console.log(err)
            fireAlert("error", translate("front.errorMessage"));
          }
          this.getLoading = false;
        },
        (error) => {
          fireAlert("error", translate("front.permissionDenied"));
          this.getLoading = false;
        },
        {
          enableHighAccuracy: true,
        }
      );
    },
    getAddressFromLatLong({ longitude, latitude }) {
      return new Promise((resolve, reject) => {
        axios
          .get(
            `https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=${this.token}&limit=1`
          )
          .then((res) => {
            resolve(res.data.features[0].place_name);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
  },
  created() {},
};
</script>

<style lang="scss">
#map {
  height: 300px;
}
.bg-grey {
  background: rgb(233, 233, 233);
}
</style>
