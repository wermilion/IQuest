<template>
    <router-view/>
</template>

<script>
  import axios from '@/utils/axios';

  export default {
    name: 'App',
    beforeRouteEnter(to, from, next) {
      console.log('sdfsdf')
      axios.get('csrf-cookie').then(response => {
        console.log(response)
        next()
      });
    }
  }
</script>