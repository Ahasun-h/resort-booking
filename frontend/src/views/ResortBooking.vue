<template>
  <NavBar />
  <div class="container p-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col">
                                    <h4 class="text-start">
                                        <strong>
                                            Booking
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
                                                <form @submit.prevent="handleBooking">
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="email">Email</label>
                                                        <input type="text" v-model="bookingInfo.email" id="email" class="form-control"
                                                            :class="errorHandler('email') ? 'is-invalid' : '' "
                                                            placeholder="Example@email.com"/>
                                                        <p v-if="errorHandler('email')" class="text-danger">
                                                            {{ validation_error.email[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="contact_number">Contact Number</label>
                                                        <input type="text" v-model="bookingInfo.contact_number" id="contact_number" class="form-control"
                                                            :class="errorHandler('email') ? 'is-invalid' : ''"
                                                            placeholder="+880"/>
                                                        <p v-if="errorHandler('contact_number')" class="text-danger">
                                                            {{ validation_error.contact_number[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="booking_date">Booking Date</label>
                                                        <input type="date" v-model="bookingInfo.booking_date" id="booking_date" class="form-control"
                                                            :class="errorHandler('booking_date') ? 'is-invalid' : ''"
                                                            />
                                                        <p v-if="errorHandler('booking_date')" class="text-danger">
                                                            {{ validation_error.booking_date[0] }}
                                                        </p>
                                                    </div>
                                                    <div class="form-outline mb-4">
                                                        <label class="form-label" for="number_days">Stay Days</label>
                                                        <input type="number" v-model="bookingInfo.number_days" id="number_days" class="form-control"
                                                            :class="errorHandler('number_days') ? 'is-invalid' : ''"
                                                            />
                                                        <p v-if="errorHandler('number_days')" class="text-danger">
                                                            {{ validation_error.number_days[0] }}
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
</template>
<script>

    import NavBar from '../components/NavBar.vue'
    import {useRouter} from 'vue-router'
    import { useStore } from 'vuex'
    import axiosClient from '../axios';
    import { ref, onMounted } from 'vue';

    export default {
        name:'ResortBooking',
        components: { NavBar },
        setup() {
            const router = useRouter();
            const store = useStore();
            let data = ref({
                isLoading: false,
                buttonDisabled: true,
                error : null
            });
            let bookingInfo = ref({
                email: '',
                contact_number: '',
                booking_date: '',
                number_days: ''
            });
            let validation_error = ref({});

             // Route params
             const id = ref(useRouter().currentRoute.value.params);

             /**
             * Create new user in database
             *
             * @returns {Promise<void>}
             */
             const handleBooking = async () => {
                data.value.isLoading = true;
                data.value.buttonDisabled = false;
                await axiosClient.post('/api/resort-booking/'+id.value.id,bookingInfo.value)
                    .then(res => {
                        console.log(res)
                        if (res.data.success == true) {
                            router.push({name: 'Home'});
                        }else{
                             data.value.error = res.data.message
                        }
                        data.value.isLoading = false;
                        data.value.buttonDisabled = true;
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

            return { data, bookingInfo, validation_error, handleBooking, errorHandler }
        }
    }
</script>

<style>

</style>