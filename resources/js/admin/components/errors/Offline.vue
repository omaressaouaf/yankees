<template>
  <div class="" style="margin-top: -30px">
    <div class="row">
      <div
        class="col-sm-12 offline-div text-center bg-danger text-light"
        style="padding: 16px"
      >
        <span class="lead"
          ><i class="fa fa-power-off"></i>
          {{ translate("admin.noInternet") }}</span
        >
      </div>
    </div>
    <div class="content-wrapper mt-5">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1 class="lead display-4 h3 text-gray-800">
              <i class="fa fa-plug"></i> {{ translate("admin.notConnected") }}
            </h1>
            <p>
              {{ translate("admin.notConnectedText", { appName  }) }}
            </p>
            <b class="ml-3">{{ translate("admin.try") }} :</b>
            <ul class="mt-2">
              <li>{{ translate("admin.checkCables") }}</li>
              <li>{{ translate("admin.checkNetwork") }}</li>
              <li>
                <button @click="reload" style="padding: 0" class="btn btn-link btn-info">
                  {{ translate("admin.refreshPage") }}
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
      return {
        appName: this.$store.state.appName,
      };
    },
  methods: {
    reload() {
      location.reload();
    },
  },
};
</script>
