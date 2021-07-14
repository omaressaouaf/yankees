import axios from "axios";
import { fireToast } from "../../admin/helpers";

const state = {
    cart: {},
    loading: {
        get: false,
        post: false
    },
    serverErrors: null
};
const getters = {
    cartObject(state) {
        return state.cart;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchCart(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/cart");
            store.commit("setCart", {
                content: res.data.content,
                total: res.data.total,
                count: res.data.count
            });
        } catch (err) {
            console.log(err);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "get");
    },
    addToCart(store, newCartItem) {
        return new Promise(async (resolve, reject) => {
            try {
                store.commit("setLoading", "post");
                const res = await axios.post("/cart", newCartItem);
                store.commit("setCart", {
                    content: res.data.content,
                    total: res.data.total,
                    count: res.data.count
                });
                store.commit("meals/setMeal", null, { root: true });
                store.commit("clearServerErrors");
                $("#mealModal").modal("hide");

                if (window.location.pathname === "/meals") {
                    fireToast("success", translate("front.successMessage"));
                } else {
                    fireToast(
                        "success",
                        `<a href="/meals" > ${translate(
                            "front.successMessage"
                        )} <u class="font-weight-bold">${translate(
                            "front.seeCart"
                        )}</u></a>`
                    );
                }
                resolve();
            } catch (err) {
                if (err.response.status != "422") {
                    $("#mealModal").modal("hide");
                    fireToast("danger", translate("front.errorMessage"));
                }
                store.commit("setServerErrors", err);
                reject(err);
            }
            store.commit("clearLoading", "post");
        });
    },
    async deleteFromCart(store, rowId) {
        try {
            store.commit("setLoading", "post");
            const res = await axios.delete("/cart/" + rowId);
            store.commit("setCart", {
                content: res.data.content,
                total: res.data.total,
                count: res.data.count
            });
        } catch (err) {
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "post");
    },
    async updateCart(store, updatedItem) {
        if (updatedItem.qty == 0) {
            store.dispatch("deleteFromCart", updatedItem.rowId);
            return;
        }
        try {
            store.commit("setLoading", "post");
            const res = await axios.put(
                `/cart/${updatedItem.rowId}`,
                updatedItem
            );
            store.commit("setCart", {
                content: res.data.content,
                total: res.data.total,
                count: res.data.count
            });
        } catch (err) {
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "post");
    }
};
const mutations = {
    setCart(state, cart) {
        state.cart = cart;
    },
    setLoading(state, method) {
        state.loading[method] = true;
    },
    clearLoading(state, method) {
        state.loading[method] = false;
    },
    setServerErrors(state, err) {
        if (err.response.data.errors) {
            state.serverErrors = Object.keys(err.response.data.errors);
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
