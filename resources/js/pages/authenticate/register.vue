<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>Sign Up</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="handleRegister">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    v-model="username"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    v-model="email"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    v-model="password"
                                    required
                                />
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Sign Up
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Already have an account? <router-link to="/login">Login here</router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            email: '',
            password: '',
        };
    },
    methods: {
        handleRegister() {
            // Handle registration logic here (e.g., API call)
            console.log('Registering with:', this.username, this.email, this.password);
        },
    },
};
</script>
