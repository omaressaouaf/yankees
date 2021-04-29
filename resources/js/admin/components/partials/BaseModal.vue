<template>
  <div
    class="modal fade"
    :id="modalId"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    :class="{'high-z-index' :  modalIsAddressSelector  }"
  >
    <div class="modal-dialog modal-lg"  role="document">
      <div class="modal-content">
        <div class="modal-body">
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            data-target="#addressSelectorModal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["modalId"],
  computed: {
    modalIsAddressSelector() {
      return this.modalId == "addressSelectorModal";
    },
  },
};
</script>

<style scoped>
.high-z-index {
    z-index: 1060 !important;
}
@media (min-width: 768px) {
  .modal-xl {
    width: 90%;
   max-width:1200px;
  }
}
</style>
