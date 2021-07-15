import axios from "axios";
import nProgress from "nprogress";
import router from "../../router";
import {
    fireToast,
    fireConfirm,
    redirectToErrorPageIfNeeded
} from "../../helpers";

const state = {
    categories: [],
    category: {},
    loading: {
        get: false,
        post: false
    },
    serverErrors: null
};
const getters = {
    allCategories(state) {
        return state.categories;
    },
    categoryObject(state) {
        return state.category;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchCategories(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/categories");
            store.commit("setCategories", res.data.categories);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "get");
    },
    deleteCategory(store, id) {
        fireConfirm(async () => {
            try {
                nProgress.start();
                await axios.delete(`/categories/${id}`);
                store.commit("removeCategory", id);
                fireToast(
                    "success",
                    translate("admin.deleted", {
                        item: translate("admin.category")
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
    async addCategory(store, newCategory) {
        try {
            store.commit("setLoading", "post");
            const res = await axios.post("/categories", newCategory);
            store.commit("addCategory", res.data.category);
            store.commit("clearCategory");
            fireToast(
                "success",
                translate("admin.created", {
                    item: translate("admin.category")
                })
            );
            router.push("/admin/categories");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    async fetchCategory(store, id) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get(`/categories/${id}`);
            store.commit("setCategory", res.data.category);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },

    async updateCategory(store, updatedCategory) {
        try {
            store.commit("setLoading", "post");

            const res = await axios.put(
                `/categories/${updatedCategory.id}`,
                updatedCategory
            );
            store.commit("updateCategory", res.data.category);

            fireToast(
                "success",
                translate("admin.updated", {
                    item: translate("admin.category")
                })
            );
            router.push("/admin/categories");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    bulkDeleteCategories(store, selectedItems) {
        return new Promise(async resolve => {
            try {
                store.commit("setLoading", "post");
                await axios.delete("/categories/bulk/" + selectedItems);
                store.commit("bulkRemoveCategories", selectedItems);
                fireToast("success", translate("admin.bulkDeleted"));
                store.commit("clearLoading", "post");
                resolve();
            } catch (err) {
                redirectToErrorPageIfNeeded(err.response.status);
                fireToast("danger", translate("front.errorMessage"));
            }
            store.commit("clearLoading", "post");
        });
    },
    async updateCategoriesOrders(store) {
        try {
            nProgress.start();
            store.commit("updateCategoriesOrders");
            await axios.put("/categories/updateOrders", {
                categories: store.state.categories
            });
            nProgress.done();
            fireToast(
                "success",
                translate("admin.updated", {
                    item: translate("admin.categories")
                })
            );

        }catch(err) {
            fireToast("danger", translate("front.errorMessage"));
        }
    }
};
const mutations = {
    setCategories(state, categories) {
        state.categories = categories;
    },
    removeCategory(state, id) {
        state.categories = state.categories.filter(
            category => category.id !== id
        );
    },
    addCategory(state, newCategory) {
        state.categories = [newCategory, ...state.categories];
    },
    setCategory(state, category) {
        state.category = category;
    },
    clearCategory(state) {
        state.category = {};
    },
    updateCategory(state, updatedCategory) {
        state.categories = state.categories.map(category => {
            return category.id === updatedCategory.id
                ? updatedCategory
                : category;
        });
    },
    bulkRemoveCategories(state, selectedItems) {
        selectedItems.forEach(id => {
            state.categories = state.categories.filter(category => {
                return category.id !== id;
            });
        });
    },
    updateCategoriesOrders(state) {
        state.categories = state.categories.map((category, index) => {
            return { ...category, order: index + 1 };
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
