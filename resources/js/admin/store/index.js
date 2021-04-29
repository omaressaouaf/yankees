import Vue from "vue";
import Vuex from "vuex";
import users from "./modules/users";
import categories from "./modules/categories";
import extras from "./modules/extras";
import meals from "./modules/meals";
import orders from "./modules/orders";
import sections from "./modules/sections";
import auth from "./modules/auth";

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
        users,
        categories,
        extras,
        meals,
        orders,
        sections,
        auth
    }
});
export default store;
