<template>
  <div>
    <div class="row">
      <div class="col-md-4 d-flex">
        <vue-skeleton-loader
          type="rect"
          width="50%"
          height="37px"
          animation="fade"
        />
        <div class="mx-1"></div>
        <vue-skeleton-loader
          type="rect"
          width="50%"
          height="37px"
          animation="fade"
        />
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <vue-skeleton-loader
              type="rect"
              :rounded="true"
              width="20%"
              height="15px"
              animation="fade"
            />
            <div style="margin-top: 36px"></div>
            <hr />
            <div>
              <vue-skeleton-loader
                type="rect"
                :rounded="true"
                width="30%"
                height="15px"
                animation="fade"
              />
              <br />
              <vue-skeleton-loader
                type="rect"
                :rounded="true"
                width="20%"
                height="15px"
                animation="fade"
              />
              <br />
              <vue-skeleton-loader
                type="rect"
                :rounded="true"
                width="40%"
                height="15px"
                animation="fade"
              />
            </div>
            <hr />
            <div class="row">
              <div class="col-md-3 mb-2" style="overflow: hidden">
                <vue-skeleton-loader
                  type="rect"
                  width="100%"
                  height="100px"
                  animation="fade"
                />
              </div>
              <div class="col-md-5 mb-2">
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="100%"
                  height="15px"
                  animation="fade"
                />
                <br />
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="80%"
                  height="15px"
                  animation="fade"
                />
              </div>

              <div class="col-md-2 mb-2">
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="50%"
                  height="15px"
                  animation="fade"
                />
              </div>
              <div class="col-md-2 font-weight-bold">
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="50%"
                  height="15px"
                  animation="fade"
                />
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-md-5 offset-md-7">
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="50%"
                  height="15px"
                  animation="fade"
                />
                <br />
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="60%"
                  height="15px"
                  animation="fade"
                />
                <br />
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="100%"
                  height="15px"
                  animation="fade"
                />
                <hr />
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  width="100%"
                  height="15px"
                  animation="fade"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <vue-skeleton-loader
              type="rect"
              :rounded="true"
              width="30%"
              height="15px"
              animation="fade"
            />
            <div style="margin-top: 36px"></div>
            <hr />
            <div class="d-flex">
              <vue-skeleton-loader
                type="circle"
                :width="50"
                :height="50"
                animation="fade"
              />
              <div class="mt-2 ml-2">
                <vue-skeleton-loader
                  type="rect"
                  :rounded="true"
                  :width="100"
                  :height="15"
                  animation="fade"
                />
              </div>
            </div>
            <hr />

            <div
              v-for="item in [0, 1, 2]"
              :key="item"
              class="d-flex align-items-center mb-3"
            >
              <vue-skeleton-loader
                type="circle"
                :width="20"
                :height="20"
                animation="fade"
              />
              <span class="mx-1"></span>
              <vue-skeleton-loader
                type="rect"
                :rounded="true"
                :width="200"
                :height="10"
                animation="fade"
              />
            </div>
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
