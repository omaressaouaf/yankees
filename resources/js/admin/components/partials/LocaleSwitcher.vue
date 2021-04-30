<template>
  <li class="nav-item dropdown">
    <a
      class="nav-link dropdown-toggle text-uppercase"
      href="#"
      id="navbarDropdown"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <img
        :src="`/storage/images/design/${currentLocale}.png`"
        width="30"
        height="20"
        class="mr-2"
        alt=""
      />
      {{ currentLocale }}
    </a>
    <div
      class="dropdown-menu dropdown-menu-right"
      aria-labelledby="navbarDropdown"
    >
      <a
        v-for="(locale, index) in availableLocales"
        :key="index"
        class="dropdown-item text-uppercase"
        :href="
          locale == currentLocale ? `${$route.path}#` : `/setLocale/${locale}`
        "
      >
        <img
          :src="`/storage/images/design/${locale}.png`"
          width="30"
          height="20"
          class="mr-2"
          alt=""
        />
        {{ locale }}
      </a>
    </div>
  </li>
</template>

<script>
export default {
  data() {
    return {
      currentLocale: window.currentLocale,
      availableLocales: window.availableLocales,
    };
  },
};
</script>

<style>
</style>
