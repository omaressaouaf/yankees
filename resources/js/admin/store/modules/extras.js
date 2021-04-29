import axios from "axios";
import nProgress from "nprogress";
import router from "../../router";
import {
    fireToast,
    fireConfirm,
    redirectToErrorPageIfNeeded
} from "../../helpers";

const state = {
    extras: [],
    extra: {},
    loading: {
        get: false,
        post: false
    },
    serverErrors: null
};
const getters = {
    allExtras(state) {
        return state.extras;
    },
    extraObject(state) {
        return state.extra;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchExtras(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/api/extras");
            store.commit("setExtras", res.data.extras);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate('front.errorMessage'));
        }
        store.commit("clearLoading", "get");
    },
    deleteExtra(store, id) {
        fireConfirm(async () => {
            try {
                nProgress.start();
                await axios.delete(`/api/extras/${id}`);
                store.commit("removeExtra", id);
                fireToast(
                    "success",
                    translate("admin.deleted", {
                        item: translate("admin.extra")
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
    async addExtra(store, newExtra) {
        try {
            store.commit("setLoading", "post");
            const res = await axios.post("/api/extras", newExtra);
            store.commit("addExtra", res.data.extra);
            store.commit("clearExtra");
            fireToast(
                "success",
                translate("admin.created", {
                    item: translate("admin.extra")
                })
            );
            router.push("/admin/extras");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    async fetchExtra(store, id) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get(`/api/extras/${id}`);
            store.commit("setExtra", res.data.extra);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },

    async updateExtra(store, updatedExtra) {
        try {
            store.commit("setLoading", "post");

            const res = await axios.put(
                `/api/extras/${updatedExtra.id}`,
                updatedExtra
            );
            store.commit("updateExtra", res.data.extra);

            fireToast(
                "success",
                translate("admin.updated", {
                    item: translate("admin.extra")
                })
            );
            router.push("/admin/extras");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    bulkDeleteExtras(store, selectedItems) {
        return new Promise(async resolve => {
            try {
                store.commit("setLoading", "post");
                await axios.delete("/api/extras/bulk/" + selectedItems);
                store.commit("bulkRemoveExtras", selectedItems);
                fireToast("success", translate('admin.bulkDeleted'));
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
    setExtras(state, extras) {
        state.extras = extras;
    },
    removeExtra(state, id) {
        state.extras = state.extras.filter(extra => extra.id !== id);
    },
    addExtra(state, newExtra) {
        state.extras = [newExtra, ...state.extras];
    },
    setExtra(state, extra) {
        extra.multi = Boolean(extra.multi);
        state.extra = extra;
    },
    clearExtra(state) {
        state.extra = {};
    },
    updateExtra(state, updatedExtra) {
        state.extras = state.extras.map(extra => {
            return extra.id === updatedExtra.id ? updatedExtra : extra;
        });
    },
    bulkRemoveExtras(state, selectedItems) {
        selectedItems.forEach(id => {
            state.extras = state.extras.filter(extra => {
                return extra.id !== id;
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
