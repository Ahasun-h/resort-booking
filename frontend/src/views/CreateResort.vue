<template>
  <Nav />
  <section class=" gradient-form">
        <div class="container py-5">

            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col">
                        <h4 class="text-start">
                            <strong>
                                Add Resort 
                            </strong>
                        </h4>
                    </div>
                    <router-link to="/home" class="col-2 btn btn-success">
                        <i class="fa-solid fa-plus"></i> Back
                    </router-link>
                </div>
            </div>
            <hr />
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-5 col-md-6 col-12">
                    <div class="rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="card-body p-md-4 mx-md-4">
                                    <!-- <div v-if="data.error" class="alert alert-danger" role="alert">
                                        {{ data.error }}
                                    </div> -->

                                    {{ resort }}

                                    <form @submit.prevent="createResort">
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" v-model="resort.name" id="name" class="form-control"
                                                   :class="errorHandler('name') ? 'is-invalid' : '' "
                                                   placeholder="Example"/>
                                            <p v-if="errorHandler('name')" class="text-danger">
                                                {{ validation_error.name[0] }}
                                            </p>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea v-model="resort.description" id="description" class="form-control"
                                                   :class="errorHandler('description') ? 'is-invalid' : ''"
                                            ></textarea>
                                            <p v-if="errorHandler('description')" class="text-danger">
                                                {{ validation_error.description[0] }}
                                            </p>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea v-model="resort.address" id="address" class="form-control"
                                                   :class="errorHandler('address') ? 'is-invalid' : ''"
                                            ></textarea>
                                            <p v-if="errorHandler('address')" class="text-danger">
                                                {{ validation_error.address[0] }}
                                            </p>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="loaction">Loaction (Google Map Sharable Link)</label>
                                            <textarea v-model="resort.loaction" id="loaction" class="form-control"
                                                   :class="errorHandler('loaction') ? 'is-invalid' : ''"
                                            ></textarea>
                                            <p v-if="errorHandler('loaction')" class="text-danger">
                                                {{ validation_error.loaction[0] }}
                                            </p>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="price_per_night">Price Per Night (.tk)</label>
                                            <input type="number" v-model="resort.price_per_night" id="price_per_night" class="form-control"
                                                   :class="errorHandler('price_per_night') ? 'is-invalid' : '' "
                                                   placeholder="Example" min="0" />
                                            <p v-if="errorHandler('price_per_night')" class="text-danger">
                                                {{ validation_error.price_per_night[0] }}
                                            </p>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label for="formBookImage" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                                            <input type="file" multiple @change="onFileChange" />

                                        
                                            <div class="jumbotron">
                                                <div class="row">
                                                    <div v-for="(image, key) in resort.images">
                                                        <div class="col-md-4" :id="key">
                                                            <button type="button" @click="removeImage(key)">
                                                                &times;
                                                            </button>
                                                            <img class="preview img-thumbnail" v-bind:ref="'image' +parseInt( key )" /> 
                                                            {{ image.name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                     
                                        
                                        <div class="text-start mb-4">
                                            <button v-if="settingData.buttonDisabled"
                                                    class="btn btn-primary btn-block fa-lg gradient-custom-2"
                                                    type="submit">
                                                Submit
                                            </button>
                                            <div v-if="settingData.isLoading" class="spinner-border text-info" role="status">
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

<script>
    import Nav from '../components/Nav.vue'
    import axiosClient from '../axios';
    import {useRouter} from 'vue-router'
    import { useStore } from 'vuex'
    import { ref, reactive } from 'vue';
    import Sidebar from '../components/Sidebar.vue';
    import DashboardHeader from '../components/DashboardHeader.vue';
    import { Dropzone } from 'dropzone';
  

export default {
    name:'CreateResort',
    components:{ Nav,Dropzone },

    data:function (){
        return {
            images : [],
            resort : {
                name: '',
                description: '',
                address: '',
                loaction: '',
                price_per_night:'',
                images: []
            },
            settingData : {
                isLoading: false,
                buttonDisabled: true,
                error : null
            },
            validation_error:{},
            router : useRouter(),
            store : useStore(),
        }
    },
    methods: {

     

        onFileChange(e) {
            var selectedFiles = e.target.files;
            for (let i=0; i < selectedFiles.length; i++)
            {
                this.resort.images.push(selectedFiles[i]);
            }
            console.log(this.resort.images);
            for (let i=0; i<this.resort.images.length; i++)
            {
                let reader = new FileReader();
                reader.addEventListener('load', function(){
                    this.$refs['image' + parseInt( i )][0].src = reader.result;
                }.bind(this), false); 

                reader.readAsDataURL(this.resort.images[i]);
            }
            this.resort.images.push(images);
            // console.log(this.resort);
        },

        removeImage (i) {
            // alert(i);
            var arrayImages = this.resort.images;
            var index = arrayImages.indexOf(arrayImages[i]);
            arrayImages.splice(index, i);
        
        },

        createResort: async function() {

            const router = useRouter();
            const store = useStore();
            
            console.log('store:'+this.store)


            this.settingData.isLoading = true;
            this.settingData.buttonDisabled = false;

            await axiosClient.post('/api/resort/create',this.resort,{headers: {'Authorization': 'Bearer '+this.store.state.token, 'Content-Type':'multipart/form-data'}})
            .then(res => {
                if (res.data.success) {
                    this.settingData.isLoading = false;
                    this.settingData.buttonDisabled = true;
                }
            })
            .catch(e => {
                this.settingData.isLoading = false;
                this.settingData.buttonDisabled = true;
                console.log(e)
                // if (e.response.status === 422) {
                //     this.validation_error = e.response.data.errors
                // }else {
                //    this.settingData.error = e.message
                // }
            })
        },

        errorHandler: function(value){
            return this.validation_error.hasOwnProperty(value)
        }

       


    }
   
}
</script>

<style scoped>
 .preview{
		  display: flex;
		  justify-content: center;
		  align-items: center;
		  height: 100px;
		  width: 100px;
		}

</style>