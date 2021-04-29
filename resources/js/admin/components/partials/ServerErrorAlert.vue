<template>
  <div class="alert alert-danger ">
    <strong><i class="fa fa-exclamation-circle text-light"></i></strong> {{translate('front.errorMessage')}}
    <ul>
      <li v-for="(error, key) in serverErrors" :key="key">{{  error[0] }}</li>
    </ul>

  </div>
</template>

<script>
export default {
  props: {
    serverErrors: Array,
  },
};
</script>

<style>
</style>
