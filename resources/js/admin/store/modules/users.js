import axios from "axios";
import nProgress from "nprogress";
import router from "../../router";
import {
    fireToast,
    fireConfirm,
    redirectToErrorPageIfNeeded
} from "../../helpers";
const state = {
    users: [],
    deliverymen: [],
    roles: [],
    user: {},
    loading: {
        get: false,
        post: false,
        roles : false
    },
    serverErrors: null
};
const getters = {
    allUsers(state) {
        return state.users;
    },
    allDeliverymen(state) {
        return state.deliverymen;
    },
    allRoles(state) {
        return state.roles;
    },
    userObject(state) {
        return state.user;
    },

    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchUsers(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/api/users");
            store.commit("setUsers", res.data.users);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "get");
    },

    async fetchRoles(store) {
        try {
            store.commit("setLoading", "roles");
            const res = await axios.get("/api/users/roles");
            store.commit("setRoles", res.data.roles);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "roles");
    },
    deleteUser(store, id) {
        fireConfirm(async () => {
            try {
                nProgress.start();
                await axios.delete(`/api/users/${id}`);
                store.commit("removeUser", id);
                fireToast(
                    "success",
                    translate("admin.deleted", {
                        item: translate("admin.user")
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
    async addUser(store, newUser) {
        try {
            store.commit("setLoading", "post");
            const res = await axios.post("/api/users", newUser);
            store.commit("addUser", res.data.user);
            store.commit("clearUser");
            fireToast(
                "success",
                translate("admin.created", {
                    item: translate("admin.user")
                })
            );
            router.push("/admin/users");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    async fetchUser(store, id) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get(`/api/users/${id}`);
            store.commit("setUser", res.data.user);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },

    async updateUser(store, updatedUser) {
        try {
            store.commit("setLoading", "post");

            const res = await axios.put(
                `/api/users/${updatedUser.id}`,
                updatedUser
            );
            store.commit("updateUser", res.data.user);
            // if (res.data.user.id == store.rootState.auth.authUser.id) {
            //     store.commit("auth/setAuthUser", res.data.user, {
            //         root: true
            //     });
            // }
            fireToast(
                "success",
                translate("admin.updated", {
                    item: translate("admin.user")
                })
            );
            router.push("/admin/users");
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    },
    bulkDeleteUsers(store, selectedItems) {
        return new Promise(async resolve => {
            try {
                store.commit("setLoading", "post");
                await axios.delete("/api/users/bulk/" + selectedItems);
                store.commit("bulkRemoveUsers", selectedItems);
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
    setUsers(state, users) {
        state.users = users;
    },
    setRoles(state, roles) {
        state.roles = roles;
    },
    removeUser(state, id) {
        state.users = state.users.filter(user => user.id !== id);
    },
    addUser(state, newUser) {
        state.users = [newUser, ...state.users];
    },
    setUser(state, user) {
        //this change is intended to fit the  stupid toggle switcher
        user.is_admin = Boolean(user.is_admin);
        state.user = user;
    },
    clearUser(state) {
        state.user = {};
    },
    updateUser(state, updatedUser) {
        state.users = state.users.map(user => {
            return user.id === updatedUser.id ? updatedUser : user;
        });
    },
    bulkRemoveUsers(state, selectedItems) {
        selectedItems.forEach(id => {
            state.users = state.users.filter(user => {
                return user.id !== id;
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
