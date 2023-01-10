
<template>
  <NavBar />
    <main>
      <div class="container p-5">
        <div class="row d-flex justify-content-between">
          <div class="col-4 p-3" v-for="resort in resorts" :key="resort">
            <div class="card">
              
              <div v-for="item in resort.resort_image.slice(0,1)" :key="item" >
                <img v-if="item" :src="item.image" class="card-img-top" alt="...">
              </div>
              <div class="card-body">
                <h5 class="card-title">{{ resort.name }}</h5>
                <p class="card-text">{{ resort.description }}</p>
                <router-link :to="{name: 'ViewResort' , params:{ id: resort.id }}" type="button" class="btn btn-primary">View</router-link>
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
      name : "Home",
      components : {NavBar},

      setup() {

        const router = useRouter();
        const store = useStore();

        let data = ref({
          isLoading: false,
          error : null,
          success_message : null
        });

        const resorts = ref([])

        // Load getResorts function onMounted
        onMounted(() => {
          getResorts()
        });

        /**
        * Get all Resorts form database
        *
        * @returns {Promise<void>}
        */
        const getResorts = async() => {
          await axiosClient.get('/api/all-resorts')
            .then(res => {
              if (res.data.success) {
                resorts.value = res.data.data;
              }
            })
            .catch(e => {
              data.value.error = e.message
            })
          };


          return { data, resorts, getResorts }
      }
  }
</script>



<style scoped>
  
</style>>

