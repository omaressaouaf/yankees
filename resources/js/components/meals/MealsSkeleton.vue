<template>
  <div class="col-12 col-sm-8 col-md-6 col-lg-4 mt-2">
    <div class="card">
      <vue-skeleton-loader type="rect" width="100%" height="247px" />

      <div class="card-body">
        <div v-for="item in [1, 2, 3]" :key="item" >
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
export default {};
</script>

<style>
</style>
