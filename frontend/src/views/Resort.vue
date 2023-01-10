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
                                                All Resort
                                            </strong>
                                        </h4>
                                    </div>
                                    <router-link to="/resort/create" class="col-2 btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Add Resort
                                    </router-link>
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Cost Per Night</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="resort in resorts" :key="resort.id">
                                            <th scope="row">{{ resort.id }}</th>
                                            <td>{{ resort.name }}</td>
                                            <td>{{  resort.address }}</td>
                                            <td>{{  resort.price_per_night }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <router-link :to="{name: 'UpdateResort' , params:{ id: resort.id }}" type="button" class="btn btn-info">Update</router-link>
                                                    <button type="button" class="btn btn-danger" @click.prevent="deleteResort(resort.id)">Delete</button>
                                                
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
        name: "Resort",  
        components: { Sidebar, DashboardHeader },
        setup() {
            const store = useStore();

            let data = ref({
                isLoading: false,
                error : null,
                success_message : null
            });

            const resorts = ref([])

            // Get all users
            onMounted(() => {
                getResorts()
            })

            // Get all users
            const getResorts = async() => {
                await axiosClient.get('/api/resorts',{ headers: {'Authorization': 'Bearer '+store.state.token }})
                .then(res => {
                    if (res.data.success) {
                        resorts.value = res.data.data;
                    }
                })
                .catch(e => {
                    data.value.error = e.message
                })
            }

            const deleteResort = async (id) => {
                console.log(id)
                await axiosClient.delete('/api/resort/delete/'+id,{ headers: {'Authorization': 'Bearer '+store.state.token }})
                .then(res => {
                    if (res.data.success) {
                        data.value.success_message = res.data.message
                        getResorts()
                    }
                })
                .catch(e => {
                    data.value.error = e.message
                })
            }

            const closeAlert = () => {
                data.value.success_message = null
            }

            return{resorts,data,deleteResort,getResorts,closeAlert}

        },
    
}
</script>

<style>

</style>