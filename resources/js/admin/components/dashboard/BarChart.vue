<template>
  <div class="ct-chart" :id="chartId">
    <transition name="fade">
      <div v-if="chartLoading" style="position: absolute; right: 10px">
        <vue-loaders-line-scale color="#fff" scale="1"></vue-loaders-line-scale>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: ["chartId", "chartData", "chartLoading"],

  watch: {
      chartLoading(newVal) {
        if (!newVal) {
          this.chartOptions.high = Math.max(...this.chartData.series[0]) + 5;
          this.initBarChart();
        }
      },

  },
  data() {
    return {
      chartOptions: {
        axisX: {
          showGrid: false,
        },
        low: 0,
        high: 50,
        chartPadding: {
          top: 0,
          right: 5,
          bottom: 0,
          left: 0,
        },
      },
      chartResponsiveOptions: [
        [
          "screen and (max-width: 640px)",
          {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              },
            },
          },
        ],
      ],
    };
  },
  methods: {
    initBarChart() {
      const barChart = new Chartist.Bar(
        `#${this.chartId}`,
        this.chartData,
        this.chartOptions,
        this.chartResponsiveOptions
      );
      md.startAnimationForBarChart(barChart);
    },
  },
  mounted() {
    this.initBarChart();
  },
};
</script>

<style>
</style>
