<template>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg d-print-none navbar-absolute fixed-top">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-minimize">
          <button
            id="minimizeSidebar"
            class="btn btn-just-icon btn-white btn-fab btn-round"
          >
            <i
              class="
                material-icons
                text_align-center
                visible-on-sidebar-regular
              "
              >more_vert</i
            >
            <i
              class="
                material-icons
                design_bullet-list-67
                visible-on-sidebar-mini
              "
              >view_list</i
            >
            <div class="ripple-container"></div>
          </button>
        </div>

        <a class="navbar-brand d-none d-xl-block" href="javascript:;"
          >Admin Dashboard</a
        >
      </div>
      <ul class="d-flex flex-row d-lg-none navbar-nav align-items-center">
        <notifications-list dropdown-unique-id="mobile"/>
        <locale-switcher />
        <global-search v-if="$gate.can('manage-partially')" />
      </ul>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        aria-controls="navigation-index"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <global-search v-if="$gate.can('manage-partially')" />

        <ul class="navbar-nav">
          <notifications-list dropdown-unique-id="desktop"/>
          <li class="nav-item dropdown d-none d-lg-block">
            <a
              class="nav-link"
              href="javascript:;"
              id="navbarDropdownProfile"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <i class="fa fa-user-circle"></i>
            </a>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="navbarDropdownProfile"
            >
              <router-link class="dropdown-item" :to="{ name: 'profile' }">{{
                translate("admin.profile")
              }}</router-link>
              <router-link
                v-if="$gate.can('manage-partially')"
                class="dropdown-item"
                :to="{ name: 'settings' }"
                >{{ translate("admin.settings") }}</router-link
              >
              <div class="dropdown-divider"></div>
              <a
                class="dropdown-item"
                href="#"
                onclick="event.preventDefault();
                                 document.querySelector('.logout-form').submit();"
                >{{ translate("admin.logout") }}</a
              >
              <form
                class="logout-form"
                action="/logout"
                method="POST"
                style="display: none"
              >
                <input type="hidden" name="_token" :value="csrf" />
              </form>
            </div>
          </li>
          <locale-switcher />
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
import NotificationsList from "../notifications/NotificationsList.vue";
import LocaleSwitcher from "./LocaleSwitcher.vue";
import GlobalSearch from "./GlobalSearch.vue";

export default {
  components: { NotificationsList, LocaleSwitcher, GlobalSearch },
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').content,
      currentLocale: window.currentLocale,
      availableLocales: window.availableLocales,
    };
  },
};
</script>

<style>
</style>
