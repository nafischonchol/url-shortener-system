import { userStore } from "@/stores/user.js";
export default {
    data() {
        return {
            auth: userStore(),
            user: {},
        };
    },
    methods: {
        isLoggedIn() {
            this.user = this.auth.getUserData();
            return this.user ? true : false;
        },
    },
};
