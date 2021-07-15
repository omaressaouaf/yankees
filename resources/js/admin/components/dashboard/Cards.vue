<template>
  <div class="row">
    <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
          <div class="card-icon">
            <i class="material-icons">people</i>
          </div>
          <p class="card-category">{{ translate("admin.registrations") }}</p>
          <transition name="fade" mode="out-in">
            <vue-loaders-ball-clip-rotate
              class="py-0 my-0"
              v-if="countLoading"
              color="#2B51C4"
              scale="1"
            ></vue-loaders-ball-clip-rotate>
            <h3 class="card-title" v-else>+{{ countData.usersCount }}</h3>
          </transition>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons mr-1 text-danger">warning</i>
            {{ translate("admin.promoteApp") }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">store</i>
          </div>
          <p class="card-category">{{ translate("admin.revenue") }}</p>
          <transition name="fade" mode="out-in">
            <vue-loaders-ball-clip-rotate
              class="py-0 my-0"
              v-if="countLoading"
              color="#2B51C4"
              scale="1"
            ></vue-loaders-ball-clip-rotate>
            <h3 class="card-title" v-else>DHS {{ countData.revenueCount }}</h3>
          </transition>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">sell</i>
            {{ translate("admin.noRevenuHistory") }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card card-stats">
        <div class="card-header card-header-danger card-header-icon">
          <div class="card-icon">
            <i class="material-icons">lunch_dining</i>
          </div>
          <p class="card-category">{{ translate("admin.menus") }}</p>
          <transition name="fade" mode="out-in">
            <vue-loaders-ball-clip-rotate
              class="py-0 my-0"
              v-if="countLoading"
              color="#2B51C4"
              scale="1"
            ></vue-loaders-ball-clip-rotate>
            <h3 class="card-title" v-else>{{ countData.mealsCount }}</h3>
          </transition>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">content_copy</i>
            <router-link :to="{ name: 'meals' }" style="color: inherit">
              {{ translate("admin.addMoreMenus") }}
            </router-link>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card card-stats">
        <div class="card-header card-header-dark card-header-icon">
          <div class="card-icon">
            <i class="material-icons">shopping_bag</i>
          </div>
          <p class="card-category">{{ translate("admin.orders") }}</p>
          <transition name="fade" mode="out-in">
            <vue-loaders-ball-clip-rotate
              class="py-0 my-0"
              v-if="countLoading"
              color="#2B51C4"
              scale="1"
            ></vue-loaders-ball-clip-rotate>
            <h3 class="card-title" v-else>+{{ countData.ordersCount }}</h3>
          </transition>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i>
            <router-link :to="{ name: 'orders' }" style="color: inherit">
              {{ translate("admin.checkPendingOrders") }}
            </router-link>
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
      countLoading: true,
      countData: {},
    };
  },
  methods: {
    getCount() {
      this.countLoading = true;
      axios
        .get("/dashboard/count")
        .then((res) => {
          this.countData = res.data;
          this.countLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getCount();
  },
};
</script>

<style>

  .ball-clip-rotate > div {
    margin: -4% !important;
    display: block !important;
  }

</style>
