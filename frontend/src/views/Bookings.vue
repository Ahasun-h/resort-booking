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
                                                 All Bookings
                                             </strong>
                                         </h4>
                                     </div>
                                     
                                 </div>
                             </div>
                             <div class="col-12">
                                 <!-- Start: Resort Table -->
                                 <table class="table">
                                     <thead>
                                         <tr>
                                             <th scope="col">#</th>
                                             <th scope="col">Email</th>
                                             <th scope="col">Number</th>
                                             <th scope="col">Booking Date</th>
                                             <th scope="col">Bill</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr v-for="booking in bookings" :key="booking.id">
                                             <th scope="row">{{ booking.id }}</th>
                                             <td>{{ booking.email }}</td>
                                             <td>{{ booking.contact_number }}</td>
                                             <td>{{ booking.booking_date }}</td>
                                             <td>{{ booking.bill }}</td>
                                         </tr>          
                                     </tbody>
                                 </table>
                                 <!-- End: Resort Table -->
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
         name: "Bookings",  
         components: { Sidebar, DashboardHeader },
         setup() {
             const store = useStore();
 
             let data = ref({
                 isLoading: false,
                 error : null,
                 success_message : null
             });
 
             const bookings = ref([])
 
             // Load getResorts function onMounted
             onMounted(() => {
                 getBookings()
             });
 
             /**
              * Get all resorts form database
              *
              * @returns {Promise<void>}
              */
             const getBookings = async() => {
                 await axiosClient.get('/api/bookings',{ headers: {'Authorization': 'Bearer '+store.state.token }})
                 .then(res => {
                     if (res.data.success) {
                        bookings.value = res.data.data;
                     }
                 })
                 .catch(e => {
                     data.value.error = e.message
                 })
             };
 
             return{bookings,data,getBookings}
 
         },
     
 }
 </script>
 
 <style>
 
 </style>