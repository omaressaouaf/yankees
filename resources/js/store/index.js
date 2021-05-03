import Vue from "vue";
import Vuex from "vuex";
import meals from "./modules/meals";
import cart from "./modules/cart";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        appName: window.appName,
        appLogo: window.appLogo,
        deliveryZoneBounds: window.deliveryZoneBounds
    },
    mutations: {
        setAppName(state, newAppName) {
            state.appName = newAppName;
        },
        setAppLogo(state, newAppLogo) {
            state.appLogo = newAppLogo;
        },
        setDeliveryZoneBounds(state, newZoneBounds) {
            state.deliveryZoneBounds = newZoneBounds;
        }
    },
    modules: {
        meals,
        cart
    }
});
export default store;
