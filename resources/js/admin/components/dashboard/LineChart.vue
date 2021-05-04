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
  data() {
    return {
      chartOptions: {
        lineSmooth: Chartist.Interpolation.cardinal({
          tension: 0,
        }),
        low: 0,
        high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
        chartPadding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0,
        },
      },
    };
  },
  watch: {
    chartLoading(newVal) {
      if (!newVal) {
        this.chartOptions.high = Math.max(...this.chartData.series[0]) + 5;
        this.initLineChart();
      }
    },
  },
  methods: {
    initLineChart() {
      const lineChart = new Chartist.Line(
        `#${this.chartId}`,
        this.chartData,
        this.chartOptions
      );
      md.startAnimationForLineChart(lineChart);
    },
  },
  mounted() {
    this.initLineChart();
  },
};
</script>


