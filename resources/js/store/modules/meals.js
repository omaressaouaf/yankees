import nProgress from "nprogress";
nProgress.configure({ easing: 'ease', speed: 300 });
import { fireToast } from "../../admin/helpers";
const state = {
    meals: [],
    meal: null,
    categories: [],
    loading: {
        get: false,
        post: false
    }
};
const getters = {
    allMeals(state) {
        return state.meals;
    },
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
    fetchMeals(store, filters) {
        return new Promise(async (resolve, reject) => {
            try {
                if (filters.page == 1) {
                    nProgress.start();
                    store.commit("setLoading", "get");
                }
                const res = await axios.get("/meals", {
                    params: filters
                });
                store.commit("setMeals", res.data.meals);
                // resolve with data length to check if it's empty in order to prevent more infinite loading api calls
                resolve(res.data.meals.next_page_url);
            } catch (err) {
                fireToast("danger", translate('front.successMessage'));
            }
            if (filters.page == 1) {
                nProgress.done();
                store.commit("clearLoading", "get");
            }
        });
    },
    async fetchCategories(store) {
        try {
            const res = await axios.get("/api/categories");
            store.commit("setCategories", res.data.categories);
        } catch (err) {
            fireToast("danger", translate('front.successMessage'));
        }
    }
};
const mutations = {
    setMeals(state, meals) {
        // if this is the first api call. then we wanna reset the meals .  if it's infinite loading call we wanna append to the meals
        if (meals.current_page == 1) {
            state.meals = meals.data;
        } else {
            state.meals.push(...meals.data);
        }
    },
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
