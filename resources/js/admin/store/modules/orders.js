import axios from "axios";
import nProgress from "nprogress";
import router from "../../router";
import {
    fireToast,
    fireConfirm,
    redirectToErrorPageIfNeeded,
    fireAlert
} from "../../helpers";

const state = {
    orders: [],
    order: { user: {} },
    deliverymen: [],

    loading: {
        get: false,
        post: false,
        status: false,
        deliverymen: false,
        charge: false,
        refund: false
    },
    serverErrors: null
};
const getters = {
    allOrders(state) {
        return state.orders;
    },
    orderObject(state) {
        return state.order;
    },
    allDeliverymen(state) {
        return state.deliverymen;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchOrders(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/api/orders");
            store.commit("setOrders", res.data.orders);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "get");
    },
    deleteOrder(store, id) {
        fireConfirm(async () => {
            try {
                nProgress.start();
                await axios.delete(`/api/orders/${id}`);
                store.commit("removeOrder", id);
                fireToast(
                    "success",
                    translate("admin.deleted", {
                        item: translate("admin.order")
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

    bulkDeleteOrders(store, selectedItems) {
        return new Promise(async resolve => {
            try {
                store.commit("setLoading", "post");
                await axios.delete("/api/orders/bulk/" + selectedItems);
                store.commit("bulkRemoveOrders", selectedItems);
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
    async fetchOrder(store, id) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get(`/api/orders/${id}`);
            store.commit("setOrder", res.data.order);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },
    async updateOrder(store, updatedOrder) {
        try {
            store.commit("setLoading", updatedOrder.loading);
            const res = await axios.put(
                `/api/orders/${updatedOrder.id}`,
                updatedOrder
            );
            store.commit("updateOrder", res.data.order);
            fireToast(
                "success",
                translate("admin.updated", {
                    item: translate("admin.order")
                })
            );
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", updatedOrder.loading);
    },
    async fetchDeliverymen(store) {
        try {
            store.commit("setLoading", "deliverymen");
            const res = await axios.get("/api/users/deliverymen");
            store.commit("setDeliverymen", res.data.deliverymen);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            fireToast("danger", translate("front.errorMessage"));
        }
        store.commit("clearLoading", "deliverymen");
    },
    async chargeUser(store) {
        try {
            nProgress.start();
            store.commit("setLoading", "charge");
            await axios.put(`/api/orders/charge/${store.state.order.id}`);
            fireToast("success", translate("admin.paymentSuccessful"));
            store.commit("updateOrder", { user_charged: true });
        } catch (err) {
            const status = err.response.status;
            if (status == 400) {
                fireAlert(
                    "error",
                    translate("admin.failure"),
                    err.response.data.msg
                );
                store.commit("updateOrder", { status: "failed" });
            }
            if (status == 406) {
                fireAlert(
                    "warning",
                    translate("admin.failure"),
                    err.response.data.msg
                );
                store.commit("updateOrder", {
                    payment_confirmation_required: true
                });
            }
            if (status == 500) {
                fireToast("danger", translate("front.errorMessage"));
            }
            redirectToErrorPageIfNeeded(status);
        }
        store.commit("clearLoading", "charge");
        nProgress.done();
    },
    async refundUser(store) {
        try {
            nProgress.start();
            store.commit("setLoading", "refund");
            await axios.put(`/api/orders/refund/${store.state.order.id}`);
            fireToast("success", translate("admin.refundSuccessful"));
            store.commit("updateOrder", { user_refunded: true });
        } catch (err) {
            const status = err.response.status;
            if (status == 400) {
                fireAlert(
                    "error",
                    translate("admin.failure"),
                    err.response.data.msg
                );
            }
            if (status == 500) {
                fireToast("danger", translate("front.errorMessage"));
            }
            redirectToErrorPageIfNeeded(status);
        }
        store.commit("clearLoading", "refund");
        nProgress.done();
    }
};
const mutations = {
    setOrders(state, orders) {
        state.orders = orders;
    },
    addOrder(state, newOrder) {
        state.orders.unshift(newOrder);
    },
    removeOrder(state, id) {
        state.orders = state.orders.filter(order => order.id !== id);
    },
    bulkRemoveOrders(state, selectedItems) {
        selectedItems.forEach(id => {
            state.orders = state.orders.filter(order => {
                return order.id !== id;
            });
        });
    },
    setOrder(state, order) {
        state.order = order;
    },
    clearOrder(state) {
        state.order = {};
    },
    updateOrder(state, newValues) {
        state.order = { ...state.order, ...newValues };
    },
    setDeliverymen(state, deliverymen) {
        state.deliverymen = deliverymen;
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
