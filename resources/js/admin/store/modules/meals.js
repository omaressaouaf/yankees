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
    progresses: [],
    serverErrors: null
};
const getters = {
    uploadProgresses(state) {
        return state.progresses;
    },
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
            const res = await axios.get("/meals");
            store.commit("setMeals", res.data.meals);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "get");
    },
    deleteMeal(store, id) {
        fireConfirm(async () => {
            try {
                nProgress.start();
                await axios.delete(`/meals/${id}`);
                store.commit("removeMeal", id);
                fireToast(
                    "success",
                    translate("admin.deleted", {
                        item: "Menu"
                    })
                );
            } catch (err) {
                redirectToErrorPageIfNeeded(err.response.status);
                fireToast("danger", translate("front.errorMessage"));
            }
            store.commit("clearLoading");
            nProgress.done();
        });
    },
    async cancelUpload(_, source) {
        source.cancel();
    },
    async addMeal(store, newMeal) {
        const progressIdentifier = Date.now();
        const source = axios.CancelToken.source();

        try {
            if (newMeal.get("newImage")) {
                store.commit("setProgress", {
                    identifier: progressIdentifier,
                    title: newMeal.get("title"),
                    percentage: 0,
                    source
                });
            } else {
                store.commit("setLoading", "post");
            }

            const res = await axios.post("/meals", newMeal, {
                headers: {
                    "Content-Type":
                        "multipart/form-data; charset=utf-8; boundary=" +
                        Math.random()
                            .toString()
                            .substr(2)
                },
                cancelToken: source.token,
                onUploadProgress: newMeal.get("newImage")
                    ? ({ loaded, total }) => {
                          const percentage = parseInt(
                              Math.round((loaded * 100) / total)
                          );
                          store.commit("incrementProgress", {
                              progressIdentifier,
                              percentage
                          });
                      }
                    : () => {}
            });
            store.commit("addMeal", res.data.meal);
            store.commit("clearMeal");

            fireToast(
                "success",
                translate("admin.created", {
                    item: "Menu"
                })
            );
            if (router.currentRoute.name === "meals.create") {
                router.push("/admin/meals");
            }
        } catch (err) {
            if (axios.isCancel(err)) {
                fireToast("info", translate("admin.uploadWasCancelled"));
            } else {
                redirectToErrorPageIfNeeded(err.response.status);
                store.commit("setServerErrors", err);
            }
        } finally {
            store.commit("clearLoading", "post");
            store.commit("clearProgress", progressIdentifier);
        }
    },
    async fetchMeal(store, id) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get(`/meals/${id}`);
            store.commit("setMeal", res.data.meal);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },

    async updateMeal(store, updatedMeal) {
        const progressIdentifier = Date.now();
        const source = axios.CancelToken.source();
        try {
            if (updatedMeal.get("newImage")) {
                store.commit("setProgress", {
                    identifier: progressIdentifier,
                    title: updatedMeal.get("title"),
                    percentage: 0,
                    source
                });
            } else {
                store.commit("setLoading", "post");
            }
            // even tho it's supposed to be a PUT method . we replaced it with POST in order for php to parse the form data and proccess it . but we need an additional
            // we appended the put method in order for the route to catch it
            updatedMeal.append("_method", "PUT");
            const res = await axios.post(
                `/meals/${updatedMeal.get("id")}`,
                updatedMeal,
                {
                    headers: {
                        "Content-Type":
                            "multipart/form-data; charset=utf-8; boundary=" +
                            Math.random()
                                .toString()
                                .substr(2)
                    },
                    cancelToken: source.token,
                    onUploadProgress: updatedMeal.get("newImage")
                        ? ({ loaded, total }) => {
                              const percentage = parseInt(
                                  Math.round((loaded * 100) / total)
                              );
                              store.commit("incrementProgress", {
                                  progressIdentifier,
                                  percentage
                              });
                          }
                        : () => {}
                }
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
            if (axios.isCancel(err)) {
                fireToast("info", translate("admin.uploadWasCancelled"));
            } else {
                redirectToErrorPageIfNeeded(err.response.status);
                store.commit("setServerErrors", err);
            }
        } finally {
            store.commit("clearLoading", "post");
            store.commit("clearProgress", progressIdentifier);
        }
    },
    bulkDeleteMeals(store, selectedItems) {
        return new Promise(async resolve => {
            try {
                store.commit("setLoading", "post");
                await axios.delete("/meals/bulk/" + selectedItems);
                store.commit("bulkRemoveMeals", selectedItems);
                fireToast("success", translate("admin.bulkDeleted"));
                store.commit("clearLoading", "post");
                resolve();
            } catch (err) {
                redirectToErrorPageIfNeeded(err.response.status);
                fireToast("danger", translate("front.errorMessage"));
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
    setProgress(state, progress) {
        state.progresses = [progress, ...state.progresses];
    },
    incrementProgress(state, { progressIdentifier, percentage }) {
        state.progresses = state.progresses.map(prog =>
            prog.identifier === progressIdentifier
                ? { ...prog, percentage }
                : prog
        );
    },
    clearProgress(state, progressIdentifier) {
        state.progresses = state.progresses.filter(
            prog => prog.identifier !== progressIdentifier
        );
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
