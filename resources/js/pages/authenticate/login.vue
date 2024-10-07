<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-body" action="#" @keydown="allErrors.clear($event.target.name)"
                            @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" v-model="form.email" required />
                                <span v-if="allErrors.has('email')"
                                    class="error text-danger text-bold ms-2 mt-2"
                                    v-text="allErrors.get('email')">
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" v-model="form.password"
                                    required />
                                <span v-if="allErrors.has('password')" class="error text-danger text-bold ms-2 mt-2"
                                    v-text="allErrors.get('password')">
                                </span>
                            </div>
                            <button type="submit" class="btn primary-button w-100">
                                Login
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Don't have an account? <router-link :to="{ name: 'register' }">Register
                                here</router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { ref } from 'vue';
import axios from "@/mixins/axios-config";
import Errors from "@/errors/errors.js";
import { userStore } from "@/stores/user.js";
import { useRouter } from 'vue-router';
const router = useRouter();

const allErrors = new Errors();
const auth = userStore();
const form = ref({
	email: "",
	password: "",
});
const submitForm = async () => {
	try {
		const response = await axios.post("/login", form.value);
		auth.setUser(response.data.item);
		router.push({ name: "dashboard" });
		
	} catch (error) {
		if (error && error.response.status === 422) {
			allErrors.record(error.response.data.errors);
		} 
	}
};
</script>

<style scoped>
.card {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
