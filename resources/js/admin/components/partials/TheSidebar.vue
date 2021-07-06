<template>
  <div
    class="sidebar ps d-print-none"
    data-color="orange"
    data-background-color="black"
    data-image="/storage/images/design/sidebar-bg.jpg"
  >
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
    <div class="logo d-flex my-3 align-items-center " style="overflow : hidden">
      <a href="/" class="ml-4" >
        <img class="" :src="appLogo" alt="logo" />
      </a>
    </div>
    <div class="sidebar-wrapper ps">
      <ul class="nav">
        <div v-if="$gate.can('manage-partially')">
          <div class="sidebar-heading mb-1">
            {{ translate("admin.overview") }}
          </div>
          <router-link
            :to="{ name: 'dashboard' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">dashboard</i>
                <p>{{ translate("admin.dashboard") }}</p>
              </a>
            </li> </router-link
          >
        <!-- Divider -->
        <hr class="sidebar-divider" />
        </div>

        <div v-if="$gate.can('manage-partially')">
          <!-- Heading -->
          <div class="sidebar-heading mb-1">
            {{ translate("admin.management") }}
          </div>
          <router-link
            :to="{ name: 'users' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">people</i>
                <p>{{ translate("admin.users") }}</p>
              </a>
            </li>
          </router-link>

          <router-link
            :to="{ name: 'categories' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">category</i>
                <p>{{ translate("admin.categories") }}</p>
              </a>
            </li>
          </router-link>
          <router-link
            :to="{ name: 'extras' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">local_cafe</i>
                <p>{{ translate("admin.extras") }}</p>
              </a>
            </li>
          </router-link>
          <router-link
            :to="{ name: 'meals' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">lunch_dining</i>
                <p>{{ translate("admin.menus") }}</p>
              </a>
            </li>
          </router-link>
        </div>

        <router-link
          :to="{ name: 'orders' }"
          v-slot="{ href, navigate, isActive }"
          custom
        >
          <li class="nav-item mb-2" :class="[isActive && 'active']">
            <a class="nav-link" :href="href" @click="navigate">
              <i class="material-icons">shopping_bag</i>
              <p>{{ translate("admin.orders") }}</p>
            </a>
          </li>
        </router-link>
        <div v-if="$gate.can('manage-partially')">
          <router-link
            :to="{ name: 'sections' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">computer</i>
                <p>CMS</p>
              </a>
            </li>
          </router-link>
          <router-link
            :to="{ name: 'settings' }"
            v-slot="{ href, navigate, isActive }"
            custom
          >
            <li class="nav-item" :class="[isActive && 'active']">
              <a class="nav-link" :href="href" @click="navigate">
                <i class="material-icons">settings</i>
                <p>{{ translate("admin.settings") }}</p>
              </a>
            </li>
          </router-link>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider" />
        <!-- Heading -->
        <div class="sidebar-heading mb-1">{{ translate("admin.account") }}</div>

        <router-link
          :to="{ name: 'profile' }"
          v-slot="{ href, navigate, isActive }"
          custom
        >
          <li class="nav-item" :class="[isActive && 'active']">
            <a class="nav-link" :href="href" @click="navigate">
              <i class="material-icons">person</i>
              <p>{{ translate("admin.profile") }}</p>
            </a>
          </li>
        </router-link>

        <li class="nav-item">
          <a
            class="nav-link"
            onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();"
            href="#"
          >
            <form
              id="logout-form"
              action="/logout"
              method="POST"
              style="display: none"
            >
              <input type="hidden" name="_token" :value="csrf" />
            </form>
            <i class="material-icons">power_settings_new</i>
            <p>{{ translate("admin.logout") }}</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      csrf: document.querySelector('meta[name="csrf-token"]').content,
    };
  },
  computed: {
    appName() {
      return this.$store.state.appName;
    },
    appLogo() {
      return this.$store.state.appLogo;
    },
  },
};
</script>

<style scoped >
.sidebar[data-color="orange"] li.active > a {
  background-color: #3f83c0 !important;
  box-shadow: 0 4px 20px 0px rgb(50 92 168 / 14%),
    0 7px 10px -5px rgb(50 92 168 / 40%);
}
.logo img {
    max-height: 40px;
}
</style>
