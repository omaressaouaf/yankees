import { fireToast, redirectToErrorPageIfNeeded } from "../../helpers";


const state = {
    sections: [],
    loading: {
        get: false,
        post: false
    },
    serverErrors: null
};
const getters = {
    allSections(state) {
        return state.sections;
    },
    isLoading(state) {
        return state.loading;
    },
    serverErrors(state) {
        return state.serverErrors;
    }
};
const actions = {
    async fetchSections(store) {
        try {
            store.commit("setLoading", "get");
            const res = await axios.get("/api/sections");
            store.commit("setSections", res.data.sections);
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "get");
    },
    async updateSection(store, selectedSection) {
        try {
            store.commit("setLoading", "post");
            const res = await axios.put(
                `/api/sections/${selectedSection.id}`,
                selectedSection
            );
            store.commit("updateSection", res.data.section);
            fireToast(
                "success",
                translate("admin.updated", {
                    item: 'Section'
                })
            );
        } catch (err) {
            redirectToErrorPageIfNeeded(err.response.status);
            store.commit("setServerErrors", err);
        }
        store.commit("clearLoading", "post");
    }
};
const mutations = {
    setSections(state, sections) {
        state.sections = sections;
    },
    updateSection(state, selectedSection) {
        state.sections = state.sections.map(section => {
            return section.id === selectedSection.id
                ? selectedSection
                : section;
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
