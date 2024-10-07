<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">URL Shortener System</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" to="/register">Sign Up</router-link>
                    </li>

                    <!-- If the user is logged in -->
                    <li class="nav-item dropdown" v-if="isLoggedIn">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <button class="dropdown-item" @click="logout">Logout</button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script setup>
import { ref } from 'vue';
import { userStore } from "@/stores/user.js";
import { useRouter } from 'vue-router';

const router = useRouter();
const isLoggedIn = ref(true);
const username = ref("Nafis");

const logout = async () => {
   isLoggedIn.value = false;
   const auth = userStore();
   localStorage.clear();
   auth.setUserNull();
   router.push({ name: "login" });
};
</script>


<style scoped>
/* You can add any custom styles here */
.navbar {
    margin-bottom: 20px;
}
</style>
