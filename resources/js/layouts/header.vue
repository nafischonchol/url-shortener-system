<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">URL Shortener System</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" :to="{ name: 'login' }">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" :to="{ name: 'register' }">Sign Up</router-link>
                    </li>

                    <li class="nav-item dropdown" v-if="isLoggedIn">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ user?.name }}
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
import axios from "@/mixins/axios-config";

const router = useRouter();
const auth = userStore();
const user  = ref(auth.getUserData());

const isLoggedIn = user.value ? ref(true) : ref(false);

const logout = async () => {
	try {
		await axios.post("/logout");
        isLoggedIn.value = false;
  
        localStorage.clear();
        auth.setUserNull();
        router.push({ name: "login" });
		
	} catch (error) {
	}
};
</script>


<style scoped>
.navbar {
    margin-bottom: 20px;
}
</style>
