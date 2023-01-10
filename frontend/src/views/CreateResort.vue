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
                    <router-link to="/resorts" class="col-2 btn btn-success">
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
                                    <!-- Start: Error message alert-->
                                    <div v-if="settingData.error" class="alert alert-danger" role="alert">
                                        {{ settingData.error }}
                                    </div>
                                    <!-- End: Error message alert-->

                                    <!-- Start: form -->
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
                                            <label class="form-label" for="location">Location (Google Map Sharable Link)</label>
                                            <textarea v-model="resort.location" id="location" class="form-control"
                                                   :class="errorHandler('location') ? 'is-invalid' : ''"
                                            ></textarea>
                                            <p v-if="errorHandler('location')" class="text-danger">
                                                {{ validation_error.location[0] }}
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
                                            <label for="images" class="form-label">Image:</label>
                                            <input class="form-control mb-3" multiple type="file" :class="errorHandler('images') ? 'is-invalid' : '' "  @change="onFileChange">
                                            <p v-if="errorHandler('images')" class="text-danger mb-3">
                                                {{ validation_error.price_per_night[0] }}
                                            </p>
                                            <div v-if="images">
                                                <div class="image_privew"  v-for="image in images" :key="image">
                                                    <img class="w-100" :src="image" />
                                                    <button class="btn btn-danger text-wite img_remove" @click="removeImage(index)">X</button>
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
                                    <!-- End: form -->
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


  

export default {
    name:'CreateResort',
    components:{ Nav },

    data:function (){
        return {
            images : [],
            resort : {
                name: '',
                description: '',
                address: '',
                location: '',
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
        }
    },
    methods: {

        /**
         * Image input file handle
         *
         * @param e
         */
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createImage(files);
        },
        createImage(files) {
            var vm = this;
            for (var index = 0; index < files.length; index++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                const imageUrl = event.target.result;
                vm.images.push(imageUrl);
            };
            reader.readAsDataURL(files[index]);
            }
        },
        /**
         * Remove image form input
         *
         * @param index
         */
        removeImage(index) {
            this.images.splice(index, 1)
        },

        /**
         * Create new resort in database
         *
         * @returns {Promise<void>}
         */
        createResort: async function() {
            // image array data insert into resort object
            this.resort.images = this.images

            // update settingData object data
            this.settingData.isLoading = true;
            this.settingData.buttonDisabled = false;
            await axiosClient.post('/api/resort/create',this.resort,{headers: {'Authorization': 'Bearer '+this.$store.state.token,'Content-Type':'multipart/form-data'}})
            .then(res => {
                if (res.data.success) {
                    this.settingData.isLoading = false;
                    this.settingData.buttonDisabled = true;
                }
                // return to main page
                this.$router.push({path:'/resorts'})
            })
            .catch(e => {
                this.settingData.isLoading = false;
                this.settingData.buttonDisabled = true;
                // check error type
                if (e.response.status === 422) {
                    this.validation_error = e.response.data.errors
                }else {
                   this.settingData.error = e.message
                }
            })
        },

        /**
         * Server return validation show in input field
         *
         * @param value
         * @returns {boolean}
         */
        errorHandler: function(value){
            return this.validation_error.hasOwnProperty(value)
        }
    }
   
}
</script>

<style scoped>
 .image_privew{
    position: relative;
    margin-bottom: 4px;
    
 }
 .image_privew .img_remove{
    position: absolute;
    top: 2px;
    right: 2px;
 }

</style>