import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            lastSearch: null
        };
    },
    mutations: {
        setLastSearch(state,payload) {
            state.lastSearch = payload;
        },
        getLastSearch(state) {
            return state.lastSearch;
        }
    },
    actions: {
        setLastSearch({commit},payload) {
            commit('setLastSearch',payload);
            localStorage.setItem('lastSearch',JSON.stringify(payload));
        },
        loadLastSearch({commit}) {
            let lastSearch = localStorage.getItem('lastSearch');
            if(lastSearch) {
                commit('setLastSearch',JSON.parse(lastSearch));
            }
        }
    },
    getters: {
        lastSearch(state) {
            return state.lastSearch;
        }
    }
});

export default store;
