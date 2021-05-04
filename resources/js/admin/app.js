require("../bootstrap");
window.Vue = require("vue").default;
import router from "./router";
import store from "./store";
import ToggleButton from "vue-js-toggle-button";
import swal from "sweetalert2";
import dayjs from "dayjs";
import relativeTime from 'dayjs/plugin/relativeTime'
dayjs.extend(relativeTime)
import "dayjs/locale/fr";
import Vuelidate from "vuelidate";
import vuelidateErrorExtractor from "vuelidate-error-extractor";
import ClientErrorAlert from "./components/partials/ClientErrorAlert.vue";
import Multiselect from "vue-multiselect";
import * as WebFont from "webfontloader";
import VueSkeletonLoader from "skeleton-loader-vue";
import gate from "./gate";
import VueLoaders from 'vue-loaders';
import "vue-loaders/dist/vue-loaders.css";
// ______________________________________________State Commit Mutations for The authenticated user______________________________________________
store.commit("auth/setAuthUser", window.authUser);
// ______________________________________________Component global registration______________________________
Vue.component("app", require("./components/App.vue").default);
Vue.component(
    "the-breadcrumb",
    require("./components/partials/TheBreadcrumb.vue").default
);
Vue.component(
    "server-error-alert",
    require("./components/partials/ServerErrorAlert").default
);
Vue.component("multiselect", Multiselect);
Vue.component(
    "address-selector",
    require("./components/addresses/AddressSelector.vue").default
);
Vue.component(
    "address-list",
    require("./components/addresses/AddressList.vue").default
);
Vue.component("vue-skeleton-loader", VueSkeletonLoader);


// ______________________________________________Global mixins______________________________________________

Vue.mixin({
    methods: {
        printPlaceholder(attr) {
            return (
                translate("admin.enter") +
                " " +
                translate("validation.attributes." + attr)
            );
        }
    }
});

// ______________________________________________Directives______________________________________________
Vue.directive("focus", {
    update: function(el) {
        el.focus();
    }
});

// ______________________________________________Filters______________________________________________
Vue.filter("formatDate", function(dt) {
    return document.documentElement.lang == "fr"
        ? dayjs(dt).format("MMMM D, YYYY H:mm ")
        : dayjs(dt).format("MMMM D, YYYY h:mm A ");
});
Vue.filter("formateDateTimeago", function(dt , hideAgo = false) {
    return dayjs(dt).fromNow(hideAgo)
});

// ______________________________________________Vue and packages Config___________

Vue.use(ToggleButton);
window.swal = swal;
if (document.documentElement.lang == "fr") {
    dayjs.locale("fr");
}
Vue.use(Vuelidate);

// translation package
window.translate = require("../VueTranslation/Translation").default.translate;
Vue.prototype.translate = require("../VueTranslation/Translation").default.translate;

// vuelidate error extractor
Vue.use(vuelidateErrorExtractor, {
    template: ClientErrorAlert,
    /**
     * the attributes property is used to map to the attribute given to the form-group.
     * so we must define each attribute and it's custom form : (ex : {name : 'the Name'}).
     * which is cubersome. instead we can get all the attributes from the backend using the method below
     * that will get all the attributes depending on the lang
     */
    attributes: require("../VueTranslation/Translation").default
        .backendValidationAttributes,
    messages: {
        required: `${translate("validation.required", {
            attribute: "{attribute}"
        })}`,
        email: `${translate("validation.email", {
            attribute: "{attribute}"
        })}`,
        minLength: `${translate("validation.min.string", {
            attribute: "{attribute}",
            min: "{min}"
        })}`,
        integer: `${translate("validation.integer", {
            attribute: "{attribute}"
        })}`,
        minValue: `${translate("validation.min.numeric", {
            attribute: "{attribute}",
            min: "{min}"
        })}`,
        isBetweenTheMinAndAdminSelectedOptions: `${translate(
            "validation.isBetweenTheMinAndAdminSelectedOptions",
            {
                attribute: "{attribute}"
            }
        )}`
    }
});
Vue.prototype.$gate = gate;
window.gate = gate;
Vue.use(VueLoaders);

const app = new Vue({
    el: "#app",
    router,
    store
});

// ________________________________Material Dashboard and custom scripts__________________________________
require("material-dashboard/assets/js/core/bootstrap-material-design.min.js");
require("material-dashboard/assets/js/plugins/perfect-scrollbar.jquery.min.js");
require("material-dashboard/assets/js/plugins/bootstrap-notify.js");
require("material-dashboard/assets/js/material-dashboard.min.js");
require("./custom");
WebFont.load({
    custom: { families: ["Material Icons", "Material Icons Outline"] }
});
