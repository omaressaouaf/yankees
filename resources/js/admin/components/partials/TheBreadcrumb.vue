<template>
  <div
    class="d-sm-flex d-print-none align-items-center justify-content-between mb-2"
    style="margin-top: -38px"
  >
    <h1 class="h3 mb-0 text-gray-800">{{translate('admin.adminPanel')}}</h1>

    <ol class="breadcrumb float-sm-right mt-4">
      <li class="breadcrumb-item">
        <router-link :to="{ name: 'dashboard' }">
          <h5 class="text-dark"><i class="material-icons mb-1">dashboard</i> {{translate('admin.dashboard')}}</h5>
        </router-link>
      </li>
      <slot> </slot>
    </ol>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>

</style>
