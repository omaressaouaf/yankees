import axios from "axios";
import nProgress from "nprogress";
import router from "../../router";
import {
    fireToast,
    fireConfirm,
    redirectToErrorPageIfNeeded
} from "../../helpers";

const state = {
    meals: [],
    meal: {},
    loading: {
        get: false,
        post: false
    },
    serverErrors: null
};
const getters = {
    allMeals(state) {
        return state.meals;
    },
    mealObject(state) {
        return state.meal;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchMeals(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/api/meals");
            store.commit("setMeals", res.data.meals);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate('front.errorMessage'));
        }
        store.commit("clearLoading", "get");
    },
    deleteMeal(store, id) {
        fireConfirm(async () => {
            try {
                nProgress.start();
                await axios.delete(`/api/meals/${id}`);
                store.commit("removeMeal", id);
                fireToast(
                    "success",
                    translate("admin.deleted", {
                        item: "Menu"
                    })
                );
            } catch (err) {
                redirectToErrorPageIfNeeded(err.response.status);
                fireToast("danger", translate('front.errorMessage'));
            }
            store.commit("clearLoading");
            nProgress.done();
        });
    },
    async addMeal(store, newMeal) {
        try {
            const config = {
                headers: {
                    "Content-Type":
                        "multipart/form-data; charset=utf-8; boundary=" +
                        Math.random()
                            .toString()
                            .substr(2)
                }
            };
            store.commit("setLoading", "post");
            const res = await axios.post("/api/meals", newMeal, config);
            store.commit("addMeal", res.data.meal);
            store.commit("clearMeal");
            fireToast(
                "success",
                translate("admin.created", {
                    item: "Menu"
                })
            );
            router.push("/admin/meals");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    async fetchMeal(store, id) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get(`/api/meals/${id}`);
            store.commit("setMeal", res.data.meal);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },

    async updateMeal(store, updatedMeal) {
        try {
            const config = {
                headers: {
                    "Content-Type":
                        "multipart/form-data; charset=utf-8; boundary=" +
                        Math.random()
                            .toString()
                            .substr(2)
                }
            };
            store.commit("setLoading", "post");
            // even tho it's supposed to be a PUT method . we replaced it with POST in order for php to parse the form data and proccess it . but we need an additional
            // we appended the put method in order for the route to catch it
            updatedMeal.append("_method", "PUT");
            const res = await axios.post(
                `/api/meals/${updatedMeal.get("id")}`,
                updatedMeal,
                config
            );
            store.commit("updateMeal", res.data.meal);
            fireToast(
                "success",
                translate("admin.updated", {
                    item: "Menu"
                })
            );
            router.push("/admin/meals");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    bulkDeleteMeals(store, selectedItems) {
        return new Promise(async resolve => {
            try {
                store.commit("setLoading", "post");
                await axios.delete("/api/meals/bulk/" + selectedItems);
                store.commit("bulkRemoveMeals", selectedItems);
                fireToast("success", translate("admin.bulkDeleted"));
                store.commit("clearLoading", "post");
                resolve();
            } catch (err) {
                redirectToErrorPageIfNeeded(err.response.status);
                fireToast("danger", translate('front.errorMessage'));
            }
            store.commit("clearLoading", "post");
        });
    }
};
const mutations = {
    setMeals(state, meals) {
        state.meals = meals;
    },
    removeMeal(state, id) {
        state.meals = state.meals.filter(meal => meal.id !== id);
    },
    addMeal(state, newMeal) {
        state.meals = [newMeal, ...state.meals];
    },
    setMeal(state, meal) {
        meal.active = Boolean(meal.active);
        state.meal = meal;
    },
    clearMeal(state) {
        state.meal = {};
    },
    updateMeal(state, updatedMeal) {
        state.meals = state.meals.map(meal => {
            return meal.id === updatedMeal.id ? updatedMeal : meal;
        });
    },
    bulkRemoveMeals(state, selectedItems) {
        selectedItems.forEach(id => {
            state.meals = state.meals.filter(meal => {
                return meal.id !== id;
            });
        });
    },
    setLoading(state, method) {
        state.loading[method] = true;
    },
    clearLoading(state, method) {
        state.loading[method] = false;
    },
    setServerErrors(state, err) {
        if (err.response.data.errors) {
            state.serverErrors = Object.values(err.response.data.errors);
        } else {
            state.serverErrors = [];
        }
    },
    clearServerErrors(state) {
        state.serverErrors = null;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
