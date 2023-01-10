<script>

    import {reactive, ref} from 'vue';
    import axiosClient from '../axios';
    import {useRouter} from 'vue-router'
    import { useStore } from 'vuex'

    export default {
        name: "Login",
        setup() {
            const router = useRouter();
            const store = useStore();

            let data = ref({
                isLoading: false,
                buttonDisabled: true,
                error: null
            });
            let form = reactive({
                email: '',
                password: ''
            });
            let validation_error = ref({});

            const handleLogin = async () => {
                data.value.isLoading = true;
                data.value.buttonDisabled = false;
                await axiosClient.post('/api/login', form)
                    .then(res => {
                        if (res.data.success) {
                            data.value.isLoading = false;
                            data.value.buttonDisabled = true;
                            store.dispatch('setToken', res.data.data.token);
                            store.dispatch('setUserId', res.data.data.user_id);
                            router.push({name: 'Home'})
                        }
                    })
                    .catch(e => {
                        data.value.isLoading = false;
                        data.value.buttonDisabled = true;
                        if (e.response.status === 422) {
                            validation_error.value = e.response.data.errors
                            console.log(validation_error.value.email)
                        } else {
                            data.value.error = e.response.data.message
                        }
                    })
            };

            function errorHandler(value) {
                return validation_error.value.hasOwnProperty(value)
            }

            return {form, validation_error, data, handleLogin, errorHandler}
        },
    }

</script>


<template>
    <section class="vh-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-5 col-md-6 col-12">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="card-body p-md-4 mx-md-4">
                                    <div class="text-center">
                                        <img src="../assets/logo.png" alt="logo">
                                    </div>
                                    <div v-if="data.error" class="alert alert-danger" role="alert">
                                        {{ data.error }}
                                    </div>
                                    <form @submit.prevent="handleLogin">
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" v-model="form.email" id="email" class="form-control"
                                                   :class="errorHandler('email') ? 'is-invalid' : '' "
                                                   placeholder="example@mail.com"/>
                                            <p v-if="errorHandler('email')" class="text-danger">
                                                {{ validation_error.email[0] }}
                                            </p>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" v-model="form.password" id="password"
                                                   class="form-control"
                                                   :class="errorHandler('password') ? 'is-invalid' : '' "/>
                                            <p v-if="errorHandler('password')" class="text-danger">
                                                {{ validation_error.password[0] }}
                                            </p>
                                        </div>
                                        <div class="text-center d-flex justify-content-between align-items-center mb-4">
                                            <button v-if="data.buttonDisabled"
                                                    class="btn btn-primary btn-block fa-lg gradient-custom-2"
                                                    type="submit">
                                                Login
                                            </button>
                                            <div v-if="data.isLoading" class="spinner-border text-info" role="status">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
    .card-body img {
        width: 80px;
    }
</style>>
