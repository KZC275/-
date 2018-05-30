<template>
  <div class="info">
    <global-header name="用户信息">
        <!-- <span slot='left'>back</span> -->
    </global-header>
    <div class="msg" v-if="this.$route.params.type==2">
        <h3>注册</h3>
        <input  v-model="email" type="text" placeholder="example@163.com">
        <input v-model="username" type="text" placeholder="username">
        <input v-model="psw" type="password" placeholder="password">
        <div class="button">
          <span @click="register(username,psw,email)">register</span>
        </div>
    </div>

    <div v-else class="user">
       <h2>找回密码</h2>
       <div>
         <input v-model="email" type="email" placeholder="请输入注册邮箱">
         <span @click="findpsw(email)">确认</span>
       </div>
    </div>


    
  </div>
</template>

<script>
import Pheader from "../../components/Pheader";
export default {
  name: "info",
  data() {
    return {
      msg: "info",
      email:'',
      username: "",
      psw: "",
    };
  },
  components: {
    "global-header": Pheader,
  },
  created() {
  },
  methods: {
    register(u, p,email) {
      if(!/^\w{2,20}@(163||126||qq||sina).com$/.test(email)){
          app.toast('邮箱格式不正确');
          return ;
      }
      app
        .post({
          url: "/php/register.php",
          data: { username: u, psw: p,email:email}
        })
        .then(data => {
          console.log(data);
          if (data.returnCode == true) {
            app.toast("注册成功");
            this.$router.go(-1);
          }else{
             app.toast(data.returnCode);
          }
        });
    },
    findpsw(email){
      app
        .post({
          url: "/php/sent_mail.php",
          data: { email: email }
        })
        .then(data => {
           data=JSON.parse(data)
           console.log(data)
           if (data.returnCode == true) {
            app.toast("邮件发送成功，请检查邮箱");
            this.$router.go(-1);
          }else{
             app.toast(data.returnDes);
          }
        })
        .catch(error => {
          app.toast("请求失败");
        });
      
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
@import "./reg.scss";
</style>
