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
              class="material-icons text_align-center visible-on-sidebar-regular"
              >more_vert</i
            >
            <i
              class="material-icons design_bullet-list-67 visible-on-sidebar-mini"
              >view_list</i
            >
            <div class="ripple-container"></div>
          </button>
        </div>

        <a class="navbar-brand" href="javascript:;">Admin Dashboard</a>
      </div>
      <!-- <div class="navbar-wrapper">
        <a href="#"><span class="material-icons">menu</span></a>
        <a class="navbar-brand" href="javascript:;">Admin Dashboard</a>
      </div> -->

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
        <form class="navbar-form">
          <div class="input-group no-border">
            <input
              type="text"
              value=""
              class="form-control"
              placeholder="Search..."
            />
            <button type="submit" class="btn btn-white btn-round btn-just-icon">
              <i class="material-icons">search</i>
              <div class="ripple-container"></div>
            </button>
          </div>
        </form>
        <ul class="navbar-nav">
          <notifications-list />
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
              <router-link v-if="$gate.can('manage')" class="dropdown-item" :to="{ name: 'settings' }">{{
                translate("admin.settings")
              }}</router-link>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#"        onclick="event.preventDefault();
                                 document.querySelector('.logout-form').submit();">{{
                translate("admin.logout")
              }}</a>
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
import LocaleSwitcher from './LocaleSwitcher.vue';

export default {
  components: { NotificationsList, LocaleSwitcher },
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
