<template>
  <base-modal modal-id="addressDirectionsModal">
    <div>
      <div class="container px-0 px-md-4 mt-2">
        <h2 class="modal-title font-weight-bold text-center">
          {{ translate("front.addressDirections") }}
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
                  v-if="startAddressLine.length"
                  class="mt-2"
                  style="flex-basis: 90%"
                >
                  {{ startAddressLine }}
                  <i class="fa fa-long-arrow-alt-right"></i>
                  {{ endAddressLine }} / {{ endAddressDetails }}
                </p>
                <p v-else class="mt-2 text-muted" style="flex-basis: 90%">
                  {{ translate("front.detectAddresses") }}
                </p>
              </div>
            </div>
            <button
              @click="toggleInstruction"
              class="btn btn-info btn-block"
              type="button"
            >
              {{translate('front.toggleInstructions')}}
            </button>
          </div>
        </div>
      </div>
    </div>
  </base-modal>
</template>

<script>
import axios from "axios";
import BaseModal from "../partials/BaseModal.vue";
import MapBoxGl from "../partials/MapBoxGl.vue";
import { fireAlert } from '../../helpers';

export default {
  components: { BaseModal, MapBoxGl },
  props: ["endAddressLine", "endAddressDetails"],
  data() {
    return {
      token: process.env.MIX_MAPBOX_TOKEN,
      deliveryZoneBounds: this.$store.state.deliveryZoneBounds,
      getLoading: false,
      postLoading: false,
      startAddressLine: "",
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
    toggleInstruction() {
      let instructions = document.getElementsByClassName(
        "directions-control-instructions"
      );
      instructions[0].hidden = !instructions[0].hidden;
    },
    mapLoaded(map) {
      this.map = map;
      if (!this.directions) {
        this.directions = new MapboxDirections({
          accessToken: this.token,
        });
      }
      this.map.addControl(this.directions, "top-left");

      // resize the map if the modal opens up before it loads
      this.map.resize();
      //   if the modal opens up after it loads
      $("#addressDirectionsModal").on("shown.bs.modal", () => {
        this.map.resize();
      });
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
            this.startAddressLine = await this.getAddressFromLatLong(
              position.coords
            );
            this.directions.setOrigin(this.startAddressLine);
          } catch (err) {
            console.log(err);
            fireAlert("error", translate("front.errorMessage"));
          }
          this.directions.setDestination(this.endAddressLine);
          this.getLoading = false;
        },
        (error) => {
          fireAlert("error", translate("front.permissionDenied"));
          this.directions.setDestination(this.endAddressLine);
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
};
</script>

<style lang="scss" >
#map {
  height: 600px;
}

.bg-grey {
  background: rgb(233, 233, 233);
}
.mapbox-directions-route-summary {
  z-index: 0 !important;
}
</style>
