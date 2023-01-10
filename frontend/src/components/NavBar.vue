<template>
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <!-- Container wrapper -->
      <div class="container">
         <router-link class="navbar-brand" :to="{ name: 'Home' }">
            <img src="../assets/logo.png" alt="logo" />
         </router-link>
         <!-- Toggle button -->
         <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarRightAlignExample"
            aria-controls="navbarRightAlignExample"
            aria-expanded="false"
            aria-label="Toggle navigation"
         >
            <i class="fas fa-bars"></i>
         </button>

         <!-- Collapsible wrapper -->
         <div class="collapse navbar-collapse" id="navbarRightAlignExample">
            <!-- Left links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <router-link :to="{ name : 'Home' }" class="nav-link" aria-current="page">
                     <strong>
                        Home
                     </strong>
                  </router-link>
               </li>
               <li class="nav-item">
                  <router-link :to="{ name : 'Login' }" v-if="$store.state.token === null && localStorage.getItem('token')" class="nav-link" aria-current="page">
                     <strong>
                        Login
                     </strong>
                  </router-link>
               </li>

               <li class="nav-item" >
                  <router-link :to="{ name : 'User' }" v-if="$store.state.token !== null" class="nav-link" aria-current="page">
                     <strong>
                        Admin
                     </strong>
                  </router-link>
               </li>
               
            </ul>
            <!-- Left links -->
         </div>
         <!-- Collapsible wrapper -->
      </div>
      <!-- Container wrapper -->
   </nav>
</template>

<script>
 export default {
      name : "NavBar",
 }
</script>

<style scoped>
   .navbar-brand img{
      width: 80px;
   }
</style>