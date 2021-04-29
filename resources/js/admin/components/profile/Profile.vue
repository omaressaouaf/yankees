<template>
  <div class="container-fluid">
    <the-breadcrumb>
      <li class="breadcrumb-item active">Profil</li>
    </the-breadcrumb>

    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-warning">
            <h4 class="card-title">{{ translate("admin.profile") }}</h4>
            <a href="/account/profile" class="card-category">{{
              translate("admin.manageProfile")
            }}</a>
          </div>
          <div class="card-body">
            <div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">{{
                      translate("admin.name")
                    }}</label>
                    <input
                      type="text"
                      class="form-control"
                      disabled
                      :value="authUser.name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">Email</label>
                    <input
                      type="text"
                      class="form-control"
                      disabled
                      :value="authUser.email"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">{{
                      translate("admin.phone")
                    }}</label>
                    <input
                      type="text"
                      class="form-control"
                      disabled
                      :value="authUser.phone"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="bmd-label-floating">{{
                      translate("admin.role")
                    }}</label>
                    <div>
                      <h4>
                        <span class="badge badge-success">
                          {{ authUser.role }}
                        </span>
                      </h4>
                    </div>
                  </div>
                </div>
              </div>

              <a class="btn btn-link p-0 mx-0" href="/account/profile">
               <u>{{translate('admin.manageProfile')}}</u>
              </a>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-profile">
          <div class="card-avatar">
            <a href="javascript:;">
              <img
                class="img"
                src="/storage/images/design/avatarplaceholder.png"
              />
            </a>
          </div>
          <div class="card-body">
            <h4 class="card-title">{{authUser.name}}</h4>
            <h6 class="card-category text-gray">{{authUser.email}}</h6>
            <p class="card-description">
              Don't be scared of the truth because we need to restart the human
              foundation in truth And I love you like Kanye loves Kanye I love
              Rick Owens’ bed design but the back is...
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters("auth", ["authUser"]),
  },
};
</script>

<style>
</style>
