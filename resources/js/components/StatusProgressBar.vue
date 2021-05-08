<template>
  <div class="progress my-2">
    <div
      class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
      role="progressbar"
      :aria-valuenow="percentage[orderObject.status]"
      aria-valuemin="0"
      aria-valuemax="100"
      :style="{ width: percentage[orderObject.status] + '%' }"
    ></div>
  </div>
</template>

<script>
export default {
  props: ["order"],
  data() {
    return {
      orderObject: { ...this.order },
      percentage: {
        pending: 20,
        processing: 50,
        out_for_delivery: 70,
        delivered: 100,
      },
    };
  },
  methods: {
    handleBroadcast(order) {},
  },
  created() {
    Echo.channel(`orders.${this.orderObject.id}`).listen(
      "OrderStatusChanged",
      (e) => {
        console.log(e.order);
      }
    );
  },
};
</script>

<style>
</style>
