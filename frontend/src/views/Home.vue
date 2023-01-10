
<script>
  import Nav from '../components/Nav.vue'
  import {useRouter} from 'vue-router'
  import { useStore } from 'vuex'

  export default {
      name : "Home",
      components : {Nav},

      setup() {

          const router = useRouter();
          const store = useStore();

          const logoutHandle = () => {
              store.dispatch('removeToken');
              store.dispatch('removeUserId');
              router.push({name: 'Login'})
          };

          return {logoutHandle}
      }
  }
</script>

<template>
  <Nav />
  <h1 class="text-center py-4">Home View</h1>
  <p>{{ $store.state.token }} || {{ $store.state.user_id }}  </p>
  <button class="btn btn-outline-danger m-auto text-center" @click="logoutHandle">Logout</button>
</template>



<style scoped>
  
</style>>

