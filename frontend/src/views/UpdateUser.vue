<template>

    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between">
            <Sidebar />
            <div class="w-75">
                <DashboardHeader />
                <main>
                    <div class="container p-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col">
                                    <h4 class="text-start">
                                        <strong>
                                            User Update
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
                                                <div v-if="setupData.error" class="alert alert-danger" role="alert">
                                                    {{ setupData.error }}
                                                </div>
                                                <form @submit.prevent="updateUser">
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="name">Name</label>
                                                        <input type="text" v-model="user.name" id="name" class="form-control"
                                                            :class="errorHandler('name') ? 'is-invalid' : '' "
                                                            placeholder="Example"/>
                                                        <p v-if="errorHandler('name')" class="text-danger">
                                                            {{ validation_error.name[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="email">Email</label>
                                                        <input type="email" v-model="user.email" id="email" class="form-control"
                                                            :class="errorHandler('email') ? 'is-invalid' : ''"
                                                            placeholder="example@mail.com"/>
                                                        <p v-if="errorHandler('email')" class="text-danger">
                                                            {{ validation_error.email[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="old_password">Old Password</label>
                                                        <input type="password" v-model="user.old_password" id="old_password"
                                                            :class="errorHandler('old_password') ? 'is-invalid' : ''"
                                                            class="form-control"/>
                                                        <p v-if="errorHandler('old_password')" class="text-danger">
                                                            {{ validation_error.old_password[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="password">Password</label>
                                                        <input type="password" v-model="user.password" id="password"
                                                            :class="errorHandler('password') ? 'is-invalid' : ''"
                                                            class="form-control"/>
                                                        <p v-if="errorHandler('password')" class="text-danger">
                                                            {{ validation_error.password[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="confirm_password">Confirm Password</label>
                                                        <input type="password" v-model="user.confirm_password" id="confirm_password"
                                                            :class="errorHandler('confirm_password') ? 'is-invalid' : ''"
                                                            class="form-control"/>
                                                        <p v-if="errorHandler('confirm_password')" class="text-danger">
                                                            {{ validation_error.confirm_password[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="text-start mb-4">
                                                        <button v-if="setupData.buttonDisabled"
                                                                class="btn btn-primary btn-block fa-lg gradient-custom-2"
                                                                type="submit">
                                                            Submit
                                                        </button>
                                                        <div v-if="setupData.isLoading" class="spinner-border text-info" role="status">
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
                    
                </main>
            </div>
        </div>
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import {useRouter} from 'vue-router'
    import { ref, onMounted } from 'vue';
    import axiosClient from '../axios';
    import Sidebar from '../components/Sidebar.vue';
    import DashboardHeader from '../components/DashboardHeader.vue';

    export default {
        name:'UpdateUser',
        components:{ Sidebar, DashboardHeader },
        setup() {
            const router = useRouter();
            const store = useStore();
            let setupData = ref({
                isLoading: false,
                buttonDisabled: true,
                error : null
            });

            // Get validation data
            let validation_error = ref({});

            // User data
            let user = ref({
                name: '',
                email: '',
                password: '',
                old_password: '',
                confirm_password: ''
            });

            // Route params
            const id = ref(useRouter().currentRoute.value.params);

            // Get User Data
            onMounted(async () => {
                await axiosClient.get('/api/user/'+id.value.id,{ headers: {'Authorization': 'Bearer '+store.state.token }})
                .then(res => {
                    if (res.data.success) {
                        user.value = res.data.data;
                    }
                })
                .catch(e => {
                    setupData.value.error = e.message
                })
            })


            // Update User Data 
            const updateUser = async () => {
                setupData.value.isLoading = true;
                setupData.value.buttonDisabled = false;
                await axiosClient.post('/api/user/update/'+id.value.id,user.value,{headers: {'Authorization': 'Bearer '+store.state.token }})
                    .then(res => {
                        if (res.data.success === true) {
                            router.push({name: 'User'});
                        }else{
                            setupData.value.error = res.data.message
                        }
                        setupData.value.isLoading = false;
                        setupData.value.buttonDisabled = true;
                       
                    })
                    .catch(e => {
                        setupData.value.isLoading = false;
                        setupData.value.buttonDisabled = true;
                        if (e.response.status === 422) {
                            validation_error.value = e.response.data.errors
                        }else {
                            setupData.value.error = e.message
                        }
                    })
            };
            function errorHandler(value) {
                return validation_error.value.hasOwnProperty(value)
            }
            return {validation_error, setupData,user,id, updateUser, errorHandler}
        },
    }
</script>

<style >

</style>