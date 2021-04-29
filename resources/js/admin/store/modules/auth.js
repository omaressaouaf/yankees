

const state = {
    authUser: null,
    loading: {
        get: false,
        post: false
    },
    serverErrors: null
};
const getters = {
    authUser(state) {
        return state.authUser;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {

};
const mutations = {
    setAuthUser(state, authUser) {
        state.authUser = authUser;
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
