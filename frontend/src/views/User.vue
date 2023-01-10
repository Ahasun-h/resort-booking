<template>
    <div class="container-fluid p-0">
        <div class="d-flex">
            <Sidebar />
            <div class="col">
                <DashboardHeader />
                <main>
                    <section class="gradient-form">
                        <div class="container p-5">
                            <div v-if="data.success_message" class="mb-4 alert alert-success d-flex justify-content-between align-items-center" role="alert">
                                {{ data.success_message }} <span @click.prevent="closeAlert">X</span>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <h4 class="text-start">
                                            <strong>
                                                All Users
                                            </strong>
                                        </h4>
                                    </div>
                                    <router-link to="/user/create" class="col-2 btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Add User
                                    </router-link>
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" :key="user.id">
                                            <th scope="row">{{ user.id }}</th>
                                            <td>{{ user.name }}</td>
                                            <td>{{  user.email }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <router-link :to="{name: 'UpdateUser' , params:{ id: user.id }}" type="button" class="btn btn-info">Update</router-link>
                                                    <button type="button" class="btn btn-danger" @click.prevent="deleteUser(user.id)">Delete</button>
                                                
                                                </div>
                                            </td>
                                        </tr>          
                                    </tbody>
                                </table>
                                                
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>


    
</template>

<script>
    import axiosClient from '../axios';
    import { ref, onMounted } from 'vue';
    import { useStore } from 'vuex'
    import Sidebar from '../components/Sidebar.vue';
    import DashboardHeader from '../components/DashboardHeader.vue';


    export default {
        name: "User",  
        components: { Sidebar, DashboardHeader },
        setup() {
            const store = useStore();

            let data = ref({
                isLoading: false,
                error : null,
                success_message : null
            });

            const users = ref([])

            // Get all users
            onMounted(() => {
                getUsers()
            })

            // Get all users
            const getUsers = async() => {
                await axiosClient.get('/api/users',{ headers: {'Authorization': 'Bearer '+store.state.token }})
                .then(res => {
                    if (res.data.success) {
                        users.value = res.data.data;
                    }
                })
                .catch(e => {
                    data.value.error = e.message
                })
            }

            const deleteUser = async (id) => {
                console.log(id)
                await axiosClient.delete('/api/user/delete/'+id,{ headers: {'Authorization': 'Bearer '+store.state.token }})
                .then(res => {
                    if (res.data.success) {
                        data.value.success_message = res.data.message
                        getUsers()
                    }
                })
                .catch(e => {
                    data.value.error = e.message
                })
            }

            const closeAlert = () => {
                data.value.success_message = null
            }

            return{users,data,deleteUser,getUsers,closeAlert}

        },
    
}
</script>

<style>

</style>