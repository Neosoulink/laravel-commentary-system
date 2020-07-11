<template>
  <b>
    <button class="btn btn-primary btn-sm" v-text="status" @click="sayhello"></button>
  </b>
</template>

<script>
  export default {

    data: () => {
        return {
            status : 'Hello World ds'
        }
    },
    mounted() {
        console.log('hello i\'m your component');
    },
    methods: {
        sayhello : (stat = status) => {
            console.log('hello i\'m your component' + stat)
        }
    },
  }
</script>
