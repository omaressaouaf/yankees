<template>
  <div id="map" class="w-100"></div>
</template>

<script>
export default {
  props: {
    mapOptions: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {};
  },
  mounted() {
    mapboxgl.accessToken = process.env.MIX_MAPBOX_TOKEN;
    this.map = new mapboxgl.Map({
      container: "map",
      ...this.mapOptions,
    });
    // Add zoom and rotation controls to the map.
    this.map.addControl(new mapboxgl.NavigationControl(), "bottom-right");
    this.map.on("load", () => {
      this.$emit("map-load", this.map);
    });
  },
};
</script>

<style>
</style>
