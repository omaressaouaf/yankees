<template>
  <div
    class="col-sm-8 col-lg-3 col-xl-3 mt-2"

  >
    <div class="card">
      <vue-skeleton-loader type="rect" width="100%" height="247px" />

      <div class="card-body">
        <div v-for="item in [1, 2, 3]" :key="item">
          <vue-skeleton-loader
            :rounded="true"
            type="rect"
            width="95%"
            height="10px"
          />
          <br />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["colsFour"],
};
</script>

<style>
</style>
