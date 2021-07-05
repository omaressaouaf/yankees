<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div class="card card-chart">
          <div
            class="card-header card-header-success"
            data-header-animation="true"
          >
            <line-chart
              chart-id="monthlyOrders"
              :chart-data="ordersByMonth"
              :chart-loading="ordersChartLoading"
            />
          </div>
          <div class="card-body">
            <div class="card-actions">
              <button
                type="button"
                class="btn btn-info btn-link"
                rel="tooltip"
                data-placement="bottom"
                title=""
                data-original-title="Refresh"
                @click="getCharts(['orders'])"
              >
                <i class="material-icons">refresh</i>
              </button>
            </div>
            <h4 class="card-title">{{ translate("admin.monthlySales") }}</h4>
            <p class="card-category">
              {{ translate("admin.monthlySalesText") }}
            </p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i>
              <span v-if="latestOrderDate" class="mr-1">
                {{ latestOrderDate | formateDateTimeago }}
              </span>
              {{ translate("admin.latestOrder") }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-chart">
          <div
            class="card-header card-header-warning"
            data-header-animation="true"
          >
            <bar-chart
              chart-id="monthlyRevenue"
              :chart-data="revenueByMonth"
              :chart-loading="revenueChartLoading"
            />
          </div>
          <div class="card-body">
            <div class="card-actions">
              <button
                type="button"
                class="btn btn-info btn-link"
                rel="tooltip"
                data-placement="bottom"
                title=""
                data-original-title="Refresh"
                @click="getCharts(['revenue'])"
              >
                <i class="material-icons">refresh</i>
              </button>
            </div>
            <h4 class="card-title">{{ translate("admin.monthlyRevenue") }}</h4>
            <p class="card-category">
              {{ translate("admin.monthlyRevenueText") }}
            </p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">sell</i>
              {{ translate("admin.noRevenuHistory") }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-chart">
          <div
            class="card-header card-header-danger"
            data-header-animation="true"
          >
            <line-chart
              chart-id="monthlyUsers"
              :chart-data="usersByMonth"
              :chart-loading="usersChartLoading"
            />
          </div>
          <div class="card-body">
            <div class="card-actions">
              <button
                type="button"
                class="btn btn-info btn-link"
                rel="tooltip"
                data-placement="bottom"
                title=""
                data-original-title="Refresh"
                @click="getCharts(['users'])"
              >
                <i class="material-icons">refresh</i>
              </button>
            </div>
            <h4 class="card-title">{{ translate("admin.monthlyUsers") }}</h4>
            <p class="card-category">
              {{ translate("admin.monthlyUsersText") }}
            </p>
          </div>
          <div class="card-footer">
            <div class="stats">
              <i class="material-icons">access_time</i>
              <span v-if="latestUsers[0]" class="mr-1">
                {{ latestUsers[0].created_at | formateDateTimeago }}
              </span>
              {{ translate("admin.latestUser") }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 col-md-12" >
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">{{ translate("admin.latestUsers") }}</h4>
            <p class="card-category">
              <router-link :to="{ name: 'users' }"
                >{{ translate("admin.manageTheirData") }}
              </router-link>
            </p>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-hover">
              <thead class="text-warning">
                <th>ID</th>
                <th>{{ translate("admin.name") }}</th>
                <th>Email</th>
                <th>{{ translate("admin.phone") }}</th>
              </thead>
              <tbody>
                <tr v-if="usersChartLoading">
                  <td colspan="4" class="text-center py-5">
                    <vue-loaders-ball-scale-ripple-multiple
                      color="#2B51C4"
                      scale="1"
                    ></vue-loaders-ball-scale-ripple-multiple>
                  </td>
                </tr>
                <tr v-for="user in latestUsers" :key="user.id" v-else>
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.phone }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import BarChart from "./BarChart.vue";
import LineChart from "./LineChart.vue";
export default {
  components: { LineChart, BarChart },
  data() {
    return {
      ordersChartLoading: true,
      usersChartLoading: true,
      revenueChartLoading: true,
      ordersByMonth: null,
      usersByMonth: null,
      revenueByMonth: null,
      latestOrderDate: "",
      latestUsers: [],
    };
  },
  methods: {
    getCharts(refreshArray = ["orders", "users", "revenue"]) {
      if (refreshArray.includes("orders")) {
        this.ordersChartLoading = true;
      }
      if (refreshArray.includes("users")) {
        this.usersChartLoading = true;
      }
      if (refreshArray.includes("revenue")) {
        this.revenueChartLoading = true;
      }
      axios
        .get("/api/dashboard/charts")
        .then((res) => {
          if (refreshArray.includes("orders")) {
            (this.ordersByMonth = {
              labels: [],
              series: [[]],
            }),
              res.data.ordersByMonth.forEach((order) => {
                this.ordersByMonth.labels.push(order.month[0].toUpperCase());
                this.ordersByMonth.series[0].push(order.total);
              });
            this.latestOrderDate = res.data.latestOrderDate;
            this.ordersChartLoading = false;
          }
          if (refreshArray.includes("users")) {
            (this.usersByMonth = {
              labels: [],
              series: [[]],
            }),
              res.data.usersByMonth.forEach((user) => {
                this.usersByMonth.labels.push(user.month[0].toUpperCase());
                this.usersByMonth.series[0].push(user.total);
              });
            this.latestUsers = res.data.latestUsers;
            this.usersChartLoading = false;
          }
          if (refreshArray.includes("revenue")) {
            (this.revenueByMonth = {
              labels: [],
              series: [[]],
            }),
              res.data.revenueByMonth.forEach((rev) => {
                this.revenueByMonth.labels.push(rev.month[0].toUpperCase());
                this.revenueByMonth.series[0].push(Number(rev.total));
              });
            this.revenueChartLoading = false;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getCharts();
  },
};
</script>

<style>
</style>
