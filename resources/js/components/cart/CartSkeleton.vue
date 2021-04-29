<template>
  <div
    class="card"
    style="position: -webkit-sticky; position: sticky; top: 90px"
  >
    <div class="card-body">
      <div>
        <div class="pt-4 wish-list has-cool-scrollbar" id="cartContentWrapper">
          <div
            class="row mb-4"
            v-for="item in [0, 1, 2]"
            :key="item"
          >
            <div class="col-md-2">
              <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                <vue-skeleton-loader

                  type="rect"
                  :width="60"
                  :height="60"
                />
              </div>
            </div>
            <div
              class="col-md-7 col-lg-9 col-xl-9"

            >
              <div class="ml-3">

                    <vue-skeleton-loader
                      :rounded="true"
                      type="rect"
                      width="100%"
                      height="10px"
                    />

              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        style="
          z-index: 1000000000000;
          box-shadow: 0 -5px 5px -5px rgba(32, 32, 32, 0.568);
        "
      >
        <div class="mb-3">
          <div class="pt-4">
            <vue-skeleton-loader type="rect" width="100%" height="50px" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
