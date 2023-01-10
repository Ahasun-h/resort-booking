<template>
  <div class="sidebar_menu">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                <span class="fs-4">Sidebar</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <router-link :to="{ name : 'User' }" class="nav-link text-white" aria-current="page">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                        User
                    </router-link>
                    
                  

                </li>
                
                <li>
                    <router-link :to="{ name : 'CreateResort' }" href="#" class="nav-link text-white">
                        <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                        Resort
                    </router-link>
                </li>
               
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
               
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name:'Sidebar',
    }
</script>

<style scoped>
    .sidebar_menu{
        width: 25%;
        height: 100vh;

    }

    .sidebar_menu .flex-column{
        width: 100%;
        height: 100%;
    }
</style>