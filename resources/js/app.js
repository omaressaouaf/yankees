// const { default: axios } = require("axios");

require("./bootstrap");
require("bootstrap");

window.Vue = require("vue").default;
import VueRouter from "vue-router";
import store from "./store";
import VueSkeletonLoader from "skeleton-loader-vue";
import Vuelidate from "vuelidate";
import InfiniteLoading from "vue-infinite-loading";
import swal from "sweetalert2";
import gate from "./admin/gate";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime);
import "dayjs/locale/fr";

import VueLoaders from "vue-loaders";
import "vue-loaders/dist/vue-loaders.css";
import axios from "axios";

// ______________________________________________Component global registration______________________________


Vue.component("vue-skeleton-loader", VueSkeletonLoader);
Vue.component(
    "address-selector",
    require("./admin/components/addresses/AddressSelector.vue").default
);

Vue.component(
    "checkout-form",
    require("./components/orders/CheckoutForm.vue").default
);
Vue.component(
    "notifications-list",
    require("./admin/components/notifications/NotificationsList.vue").default
);
Vue.component(
    "locale-switcher",
    require("./admin/components/partials/LocaleSwitcher.vue").default
);

Vue.component(
    "order-tracker",
    require("./components/orders/OrderTracker.vue").default
);
Vue.component(
    "meals-index",
    require("./components/meals/MealsIndex.vue").default
);
Vue.component(
    "meals-item",
    require("./components/meals/MealsItem.vue").default
);

Vue.component(
    "meals-single",
    require("./components/meals/MealsSingle.vue").default
);

Vue.component(
    "meals-slider",
    require("./components/meals/MealsSlider.vue").default
);

Vue.component(
    "meals-list",
    require("./components/meals/MealsList.vue").default
);
Vue.component(
    "meals-skeleton",
    require("./components/meals/MealsSkeleton.vue").default
);
Vue.component(
    "address-list",
    require("./admin/components/addresses/AddressList.vue").default
);

// ______________________________________________Filters______________________________________________

Vue.filter("formateDateTimeago", function(dt) {
    return dayjs(dt).fromNow();
});
Vue.filter("formatDate", function(dt) {
    return document.documentElement.lang == "fr"
        ? dayjs(dt).format("MMMM D, YYYY H:mm ")
        : dayjs(dt).format("MMMM D, YYYY h:mm A ");
});
Vue.filter("truncate", function(str) {
    if (str.length < 100) return str;
    return str.substring(0, 100) + "...";
});
// ______________________________________________Vue and packages Config___________
if (document.documentElement.lang == "fr") {
    dayjs.locale("fr");
}
Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(InfiniteLoading, {
    props: {
        spinner: "spiral"
    },
    slots: {
        noMore: "",
        noResults: "",
        error: "quelque chose s'est mal passé. essayez d'actualiser la page"
    }
});

// If you want to add to window object
window.translate = require("./VueTranslation/Translation").default.translate;

// If you want to use it in your vue components
Vue.prototype.translate = require("./VueTranslation/Translation").default.translate;
window.swal = swal;
Vue.prototype.$gate = gate;
if (document.documentElement.lang == "fr") {
    dayjs.locale("fr");
}
Vue.use(VueLoaders);


axios.defaults.baseURL ="/api/v1/client" ;

const router = new VueRouter({
    mode: "history",
    routes: []
});
const app = new Vue({
    el: "#app",
    router,
    store
});

// template
require("material-dashboard/assets/js/plugins/bootstrap-notify.js");
require("./template/main.js");
