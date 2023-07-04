<template>
  <form>
    <div>
      <label>Email:</label>
      <input v-model="email" type="mail"/>
    </div>
    <div>
      <label>Password:</label>
      <input v-model="password" type="password"/>
    </div>
    <button @click="sendForm">Send</button>
  </form>
</template>

<script>
export default {
  name: 'HelloWorld',
  props: {
    msg: String
  },
  data: () => {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    sendForm() {
      console.log('send Form!')
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
