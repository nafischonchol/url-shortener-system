import { defineStore } from "pinia";

export const userStore = defineStore("auth", {
    state: () => {
        return {
            user: JSON.parse(localStorage.getItem('user')) || null,
            token: localStorage.getItem('apiToken') || null,
        };
    },
    getters: {
        isLoggedIn: (state) => {
            return !!state.user?.token;
        },
        getUser: (state) => {
            return state.user;
        },
        getToken: (state) => {
            return state.token;
        },
    },
    actions: {
        setUserNull() {
            this.user = null;
            this.token = null;
        },
        setUser(data) {
            this.user = data;
            this.token = data.token;
            localStorage.setItem("user", JSON.stringify(data));
            localStorage.setItem("apiToken", data.token);
        },
        getUserData() {
            return this.user;
        },
    },
});
