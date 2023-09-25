<template>

</template>

<script>


export default {
  name: 'Layout',
  data() {
    return {
        subRoute:null,
    }
  },
  created() {
    this.subRoute = this.$route.params && this.$route.params.subRoute;
    console.log("subroute = " + this.subRoute);
  },  
  methods: {

  }
}
</script>
