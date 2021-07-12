import nProgress from "nprogress";
nProgress.configure({ easing: 'ease', speed: 300 });
import { fireToast } from "../../admin/helpers";
const state = {
    meal: null,
    categories: [],
    loading: {
        get: false,
        post: false
    }
};
const getters = {
    mealObject(state) {
        return state.meal;
    },
    allCategories(state) {
        return state.categories;
    },
    isLoading(state) {
        return state.loading;
    }
};
const actions = {

    async fetchCategories(store) {
        try {
            const res = await axios.get("/meals");
            store.commit("setCategories", res.data.categories);
        } catch (err) {
            fireToast("danger", translate('front.successMessage'));
        }
    }
};
const mutations = {

    setCategories(state, categories) {
        state.categories = categories;
    },
    setMeal(state, meal) {
        state.meal = meal;
    },
    setLoading(state, method) {
        state.loading[method] = true;
    },
    clearLoading(state, method) {
        state.loading[method] = false;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
