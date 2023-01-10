<template>

    <div class="container-fluid p-0">
        <div class="d-flex">
            <Sidebar />
            <div class="col">
                <DashboardHeader />
                <main>
                    <div class="container p-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col">
                                    <h4 class="text-start">
                                        <strong>
                                            Create User
                                        </strong>
                                    </h4>
                                </div>
                                <router-link to="/users" class="col-2 btn btn-success">
                                    <i class="fa-solid fa-plus"></i> Back
                                </router-link>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-8">
                                <div class="rounded-3 text-black">
                                    <div class="row g-0">
                                        <div class="col-12">
                                            <div class="card-body p-md-4 mx-md-4">
                                                <!-- Start: Error message alert-->
                                                <div v-if="data.error" class="alert alert-danger" role="alert">
                                                    {{ data.error }}
                                                </div>
                                                <!-- End: Error message alert-->

                                                <!-- Start: form -->
                                                <form @submit.prevent="handleRegister">
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="name">Name</label>
                                                        <input type="text" v-model="form.name" id="name" class="form-control"
                                                            :class="errorHandler('name') ? 'is-invalid' : '' "
                                                            placeholder="Example"/>
                                                        <p v-if="errorHandler('name')" class="text-danger">
                                                            {{ validation_error.name[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="email">Email</label>
                                                        <input type="email" v-model="form.email" id="email" class="form-control"
                                                            :class="errorHandler('email') ? 'is-invalid' : ''"
                                                            placeholder="example@mail.com"/>
                                                        <p v-if="errorHandler('email')" class="text-danger">
                                                            {{ validation_error.email[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="password">Password</label>
                                                        <input type="password" v-model="form.password" id="password"
                                                            :class="errorHandler('password') ? 'is-invalid' : ''"
                                                            class="form-control"/>
                                                        <p v-if="errorHandler('password')" class="text-danger">
                                                            {{ validation_error.password[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="confirm_password">Confirm Password</label>
                                                        <input type="password" v-model="form.confirm_password" id="confirm_password"
                                                            :class="errorHandler('confirm_password') ? 'is-invalid' : ''"
                                                            class="form-control"/>
                                                        <p v-if="errorHandler('confirm_password')" class="text-danger">
                                                            {{ validation_error.confirm_password[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="text-start mb-4">
                                                        <button v-if="data.buttonDisabled"
                                                                class="btn btn-primary btn-block fa-lg gradient-custom-2"
                                                                type="submit">
                                                            Submit
                                                        </button>
                                                        <div v-if="data.isLoading" class="spinner-border text-info" role="status">
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- End: form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive, ref} from 'vue';
    import axiosClient from '../axios';
    import {useRouter} from 'vue-router'
    import { useStore } from 'vuex'
    import Sidebar from '../components/Sidebar.vue';
    import DashboardHeader from '../components/DashboardHeader.vue';


    export default {
        name: "CreateUser",
        components: {
            Sidebar, DashboardHeader
        },
        setup() {
            const router = useRouter();
            const store = useStore();
            let data = ref({
                isLoading: false,
                buttonDisabled: true,
                error : null
            });
            let form = reactive({
                name: '',
                email: '',
                password: '',
                confirm_password: ''
            });
            let validation_error = ref({});

            /**
             * Create new user in database
             *
             * @returns {Promise<void>}
             */
            const handleRegister = async () => {
                data.value.isLoading = true;
                data.value.buttonDisabled = false;
                await axiosClient.post('/api/user/create',form,{headers: {'Authorization': 'Bearer '+store.state.token }},)
                    .then(res => {
                        if (res.data.success) {
                            data.value.isLoading = false;
                            data.value.buttonDisabled = true;
                            router.push({name: 'Home'});
                        }
                    })
                    .catch(e => {
                        data.value.isLoading = false;
                        data.value.buttonDisabled = true;
                        if (e.response.status === 422) {
                            validation_error.value = e.response.data.errors
                        }else {
                            data.value.error = e.message
                        }
                    })
            };

            /**
             * Server return validation show in input field
             *
             * @param value
             * @returns {boolean}
             */
            function errorHandler(value) {
                return validation_error.value.hasOwnProperty(value)
            }

            return {form, validation_error, data, handleRegister, errorHandler}
        },
    }
</script>

<style scoped>
    .card-body img {
        width: 80px;
    }
</style>