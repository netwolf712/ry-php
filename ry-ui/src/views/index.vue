<template>
  <div class="app-container home">
    {{$t("homepage.test")}}
    
  </div>
</template>

<script>

export default {
  name: "Index",
  data() {
    return {

    };
  },
  created() {

  },
  methods: {
  },
};
</script>

<style scoped lang="scss">
.el-row {
    margin-bottom: 20px;
    &:last-child {
      margin-bottom: 0;
    }
}
.el-col {
    border-radius: 4px;
}
.box-card{
  background-color: #1574de;
  color: #fff;
  width: 100%;
  height: 100px;
}
.box-title{
  font-size: 18px;
  text-align: center;
}
.box-number{
  font-size:24px;
  text-align: center;
}
.row-title{
  margin-top: 20px;
  margin-bottom:10px
}


</style>

