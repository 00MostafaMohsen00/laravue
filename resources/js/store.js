import { createStore } from "vuex";

const store = createStore({
    state() {
        return {
            lastSearch: null,
            isSearchActive: false
        };
    },
    mutations: {
        setLastSearch(state,payload) {
            state.lastSearch = payload;
        },
        getLastSearch(state) {
            return state.lastSearch;
        },
        setisSearchActive(state,payload) {
            state.isSearchActive = payload;
        },
        getisSearchActive(state) {
            return state.isSearchActive;
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
        },
        setisSearchActive({commit},payload) {
            commit('setisSearchActive',payload);
            localStorage.setItem('isSearchActive',JSON.stringify(payload));
        },
        loadisSearchActive({commit}) {
            let isSearchActive = localStorage.getItem('isSearchActive');
            if(isSearchActive) {
                commit('setisSearchActive',JSON.parse(isSearchActive));
            }else{
                commit('setisSearchActive',false);
            }
        }
    },
    getters: {
        lastSearch(state) {
            return state.lastSearch;
        },
        isSearchActive(state) {
            return state.isSearchActive;
        }
    }
});

export default store;
