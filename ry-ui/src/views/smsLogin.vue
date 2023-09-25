<template>
  <div class="login">
    <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form">
      <h3 class="title">RY后台管理系统</h3>
      <h4 class="title" >忘记密码</h4>
      <el-form-item prop="mobile">
        <el-input
          v-model="loginForm.mobile"
          type="text"
          auto-complete="off"
          placeholder="手机号码"
        >
          <svg-icon slot="prefix" icon-class="phone" class="el-input__icon input-icon" />
        </el-input>
      </el-form-item>      
      <el-form-item prop="smsCode">
        <el-input
          v-model="loginForm.smsCode"
          type="text"
          auto-complete="off"
          style="width: 50%"
          placeholder="手机验证码"
          @keyup.enter.native="handleLogin"
        >
          <svg-icon slot="prefix" icon-class="validCode" class="el-input__icon input-icon" />
        </el-input>
        <div class="login-code">
          <el-button type="primary" round :disabled="smsTimeCount > 0" @click="getSms">{{smsTimeCount ? smsTimeCount+"秒后重新获取" : "获取短信验证码"}}</el-button>
        </div>
      </el-form-item>      
      <el-form-item prop="code">
        <el-input
          v-model="loginForm.code"
          auto-complete="off"
          placeholder="验证码"
          style="width: 50%"
          @keyup.enter.native="handleLogin"
        >
          <svg-icon slot="prefix" icon-class="validCode" class="el-input__icon input-icon" />
        </el-input>
        <div class="login-code">
          <img :src="codeUrl" @click="getCode" class="login-code-img"/>
        </div>
      </el-form-item>
      <el-form-item style="width:100%;">
        <el-button
          :loading="loading"
          size="medium"
          type="primary"
          style="width:100%;"
          @click.native.prevent="handleLogin"
        >
          <span v-if="!loading">验 证</span>
          <span v-else>验 证 中...</span>
        </el-button>
        <div style="float: right;">
          <router-link class="link-type" :to="'/login'">使用已有账户登录</router-link>
        </div>        
      </el-form-item>
    </el-form>
    <!--  底部  -->
    <div class="el-login-footer">
      <span>Copyright © 2018-2022 ruoyi.vip All Rights Reserved.</span>
    </div>
  </div>
</template>

<script>
import { getSmsCode,smsLogin } from "@/api/login";

export default {
  name: "smsLogin",
  data() {
    return {
      codeUrl: "",
      loginForm: {
        mobile: "",
        smsCode:"",
        code: "",
        uuid: ""
      },
      loginRules: {
        mobile: [
          { required: true, trigger: "blur", message: "请输入您的手机号码" }
        ],
        smsCode: [
          { required: true, trigger: "blur", message: "请输入您的手机验证码" }
        ],
        code: [{ required: true, trigger: "blur", message: "请输入图形验证码" }]
      },
      getSmsRules: {
        mobile: [
          { required: true, trigger: "blur", message: "请输入您的手机号码" }
        ],
        code: [{ required: true, trigger: "blur", message: "请输入图形验证码" }]
      },      
      loading: false,
      captchaCount:0,
      captchaEnabled:true,
      smsTimer:undefined,
      smsTimeInterval:1000,
      smsTimeCount:0,
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        this.redirect = route.query && route.query.redirect;
      },
      immediate: true
    }
  },
  created() {
    this.getCode();
  },
  methods: {
    getSms(){
      if(!this.loginForm.mobile){
        this.$modal.msgError("请先输入手机号码");
        return;
      }
      if(!this.loginForm.code){
        this.$modal.msgError("请先输入图形验证码");
        return;
      }  
      getSmsCode(this.loginForm.mobile,"login",this.loginForm.code).then(res=>{
        if(res.code == 200){
          this.startSmsTimer();
        }else{
          this.$modal.msgError(res.message);
        }
      });
      
    },
    startSmsTimer(){
    
      this.smsTimeCount = 60;
      if(!this.smsTimer){
        this.smsTimer = setInterval(()=>{
          if(this.smsTimeCount > 0){
            this.smsTimeCount--;
            if(this.smsTimeCount <= 0){
              clearInterval(this.smsTimer);
              this.smsTimer = null;
            }
          }
        },this.smsTimeInterval)
      }
    },
    getCode() {
      if(this.captchaEnabled){
        this.codeUrl = process.env.VUE_APP_BASE_API + "/verifycode/index?v=" + this.captchaCount++;
      }
    },
    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true;
    
          this.$store.dispatch("SmsLogin", this.loginForm).then(() => {
            this.$router.push({ path: "/changePassword" }).catch(()=>{});
          }).catch(() => {
            this.loading = false;
            if (this.captchaEnabled) {
              this.getCode();
            }
          });
        }
      });
    },
  }
};
</script>

<style rel="stylesheet/scss" lang="scss">
.login {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  background-image: url("../assets/images/login-background.jpg");
  background-size: cover;
}
.title {
  margin: 0px auto 30px auto;
  text-align: center;
  color: #707070;
}

.login-form {
  border-radius: 6px;
  background: #ffffff;
  width: 400px;
  padding: 25px 25px 5px 25px;
  .el-input {
    height: 38px;
    input {
      height: 38px;
    }
  }
  .input-icon {
    height: 39px;
    width: 14px;
    margin-left: 2px;
  }
}
.login-tip {
  font-size: 13px;
  text-align: center;
  color: #bfbfbf;
}
.login-code {
  width: 40%;
  height: 38px;
  float: right;
  img {
    cursor: pointer;
    vertical-align: middle;
  }
}
.el-login-footer {
  height: 40px;
  line-height: 40px;
  position: fixed;
  bottom: 0;
  width: 100%;
  text-align: center;
  color: #fff;
  font-family: Arial;
  font-size: 12px;
  letter-spacing: 1px;
}
.login-code-img {
  height: 38px;
}
</style>
