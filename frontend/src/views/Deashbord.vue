<template>
  <div class="container-fluid p-0">
    <div class="d-flex">
        <Sidebar />
        <div class="col">
            <DashboardHeader />
            <main></main>
        </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '../components/Sidebar.vue';
import DashboardHeader from '../components/DashboardHeader.vue';

export default {
    name:'Deashbord',
    components:{ Sidebar, DashboardHeader }
}
</script>

<style>
    
</style>