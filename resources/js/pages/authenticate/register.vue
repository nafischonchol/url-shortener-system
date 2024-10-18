<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Sign Up</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-body" action="#" @keydown="allErrors.clear($event.target.name)"
                            @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    v-model="form.name"
                                    required
                                />
                                <span v-if="allErrors.has('name')"
                                    class="error text-danger text-bold ms-2 mt-2"
                                    v-text="allErrors.get('name')">
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    v-model="form.email"
                                    required
                                />
                                <span v-if="allErrors.has('email')"
                                    class="error text-danger text-bold ms-2 mt-2"
                                    v-text="allErrors.get('email')">
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    v-model="form.phone"
                                    required
                                />
                                <span v-if="allErrors.has('phone')"
                                    class="error text-danger text-bold ms-2 mt-2"
                                    v-text="allErrors.get('phone')">
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    v-model="form.password"
                                    required
                                />
                                <span v-if="allErrors.has('password')"
                                    class="error text-danger text-bold ms-2 mt-2"
                                    v-text="allErrors.get('password')">
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Confirm Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    required
                                />
                            </div>
                            <button type="submit" class="btn primary-button w-100">
                                Sign Up
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Already have an account? <router-link :to="{ name: 'login' }">Login here</router-link></p>
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

const allErrors = ref(new Errors());
const auth = userStore();
const form = ref({
    username: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const submitForm = async () => {
	try {
		const response = await axios.post("/register", form.value);
		auth.setUser(response.data.item);
		router.push({ name: "dashboard" });
		
	} catch (error) {
		if (error && error.response.status === 422) {
			allErrors.value.record(error.response.data.errors);
		} 
	}
};

</script>
