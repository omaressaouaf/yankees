// const { default: axios } = require("axios");

require("./bootstrap");
require('bootstrap');

window.Vue = require("vue").default;
import VueRouter from "vue-router";
import store from "./store";
import VueSkeletonLoader from "skeleton-loader-vue";
import Vuelidate from "vuelidate";
import Loading from "vue-loading-overlay";
import InfiniteLoading from "vue-infinite-loading";
import swal from "sweetalert2";
import gate from './admin/gate'




Vue.component(
    "meals-index",
    require("./components/meals/MealsIndex.vue").default
);
Vue.component("vue-skeleton-loader", VueSkeletonLoader);
Vue.component("loading", Loading);
Vue.component('address-selector' , require('./admin/components/addresses/AddressSelector.vue').default);
Vue.component('address-list' , require('./admin/components/addresses/AddressList.vue').default);
Vue.component('checkout-form' , require('./components/CheckoutForm.vue').default);


Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(InfiniteLoading, {
    props : {
    spinner : 'spiral'
    },
    slots: {

        noMore: "",
        noResults: "",
        error : "quelque chose s'est mal passé. essayez d'actualiser la page"
    }
});

// If you want to add to window object
window.translate=require('./VueTranslation/Translation').default.translate;

// If you want to use it in your vue components
Vue.prototype.translate=require('./VueTranslation/Translation').default.translate;
window.swal = swal;
Vue.prototype.$gate = gate;

const router = new VueRouter({
    mode: "history",
    routes: []
});
const app = new Vue({
    el: "#app",
    router,
    store,

});

// template
require("material-dashboard/assets/js/plugins/bootstrap-notify.js");
require("./template/main.js");
