import Vue from "vue";
import Vuex from "vuex";
import meals from "./modules/meals";
import cart from "./modules/cart";
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        deliveryZoneBounds: window.deliveryZoneBounds
    },
    modules: {
        meals,
        cart
    }
});
export default store;
