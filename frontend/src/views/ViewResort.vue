<template>
   <NavBar />
    <main>
      <div class="container p-5">
        <div class="row">
            <div class="col-8 p-2">
                <h1 class="mb-2">{{ resort.name }}</h1>
                <div class="form-group row d-flex align-items-center mb-2">
                    <label for="inputPassword" class="col-sm-3 col-form-label fw-bold">Description :</label>
                    <div class="col-sm-9">
                        <p class="mb-0">{{ resort.description }}</p>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center mb-2">
                    <label for="inputPassword" class="col-sm-3 col-form-label fw-bold">Address :</label>
                    <div class="col-sm-9">
                        <p class="mb-0">{{ resort.address }}</p>
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center mb-2">
                    <label for="inputPassword" class="col-sm-3 col-form-label fw-bold">Location :</label>
                    <div class="col-sm-9">
                        <a href="{{ resort.location }}" target="_blank">{{ resort.location }}</a>
                        
                    </div>
                </div>
                <div class="form-group row d-flex align-items-center mb-2">
                    <label for="inputPassword" class="col-sm-3 col-form-label fw-bold">Price :</label>
                    <div class="col-sm-9">
                        <p class="mb-0">{{ resort.price_per_night }} per night(.tk)</p>
                    </div>
                </div>

                
                <router-link :to="{name: 'ResortBooking' , params:{ id: id }}" type="button" class="btn btn-primary">Booking</router-link>
            </div>
            <div class="col-4 p-2">
                <div class="row">
                    <div class="mb-2 col-6" v-for="item in resort.resort_image" :key="item">
                        <div class="card " >
                            <img :src="item.image" class="card-img-top" >
                        </div>
                    </div>
                </div>
               
            </div>

           
        </div>
      </div>
    </main>

</template>

<script>
    import NavBar from '../components/NavBar.vue'
    import {useRouter} from 'vue-router'
    import { useStore } from 'vuex'
    import axiosClient from '../axios';
    import { ref, onMounted } from 'vue';

    export default {
        name:'ViewResort',
        components : { NavBar },
        setup(){
            const router = useRouter();
            const store = useStore();

            let data = ref({
                isLoading: false,
                error : null,
                success_message : null
            });

            const resort = ref([])

            // Route params
            const id = ref(useRouter().currentRoute.value.params);

            // Load getResort function onMounted
            onMounted(() => {
                getResort()
            });

            /**
            * Get all resort form database
            *
            * @returns {Promise<void>}
            */
            const getResort = async() => {
            await axiosClient.get('/api/view-resort/'+id.value.id)
                .then(res => {
                if (res.data.success) {
                    resort.value = res.data.data;
                }
                })
                .catch(e => {
                data.value.error = e.message
                })
            };
          return { data, resort , id, getResort }
        }

    }
</script>

<style>

</style>