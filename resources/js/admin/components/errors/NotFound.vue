<template>
  <div class="container-fluid">
    <!-- 404 Error Text -->
    <div class="text-center">
      <h1 class="mx-auto display-1 ">404</h1>
      <p class="lead text-gray-800 mb-5">{{translate('admin.notFound')}}</p>
      <p class="text-gray-500 mb-0">{{translate('admin.lostText')}}</p>
      <router-link :to="{ name: 'dashboard' }"
        >&larr; {{translate('admin.goHome')}}</router-link
      >
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
