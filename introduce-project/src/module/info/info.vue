<template>
  <div class="info">
    <global-header name="用户信息">
        <!-- <span slot='left'>back</span> -->
    </global-header>
    <div class="msg" v-if="this.$store.state.isLogin==false">
        <h3>登录/注册</h3>
        <input v-model="username" type="text" placeholder="username">
        <input v-model="psw" type="password" placeholder="password">
        <div class="button">
          <span @touchend="register(username,psw)">register</span>
          <span @touchend="login(username,psw)">login</span>
        </div>
    </div>

    <div v-else class="user">
       <h2>你已经登录</h2>
       <span @touchend="logout">注销</span>
    </div>

    
  </div>
</template>

<script>
import Pheader from '../../components/Pheader'
export default {
  name: 'info',
  data () {
    return {
      msg: 'info',
      username:'qwqw',
      psw:'123'
    }
    
  },
  components:{
      'global-header':Pheader,
  },
  created(){
      

    },
    methods:{
      login(u,p){
        let self=this;
        app.post({
          url: '/php/login.php',
          data:{username:u,psw:p},
        }).then((data)=>{
          console.log(data);
          if(data.returnCode==true){
              self.$store.state.isLogin=true;
              self.$store.state.username=u;//保存用户名
              self.$router.push({
                name: 'index',
                params: 'from info'
              })
              console.log(data.currentUid);
          }else{
            app.toast('登录失败');
          }
        })
      },
      register(u,p){
        app.post({
          url:'/php/register.php',
          data:{username:u,psw:p},
        }).then((data)=>{
          console.log(data);
            if(data.returnCode==true){
            app.toast('注册成功');
            }
        })

      },
      logout(){
          let self=this;
          app.post({
            url: '/php/loginOut.php',
          }).then((data)=>{
            console.log(data);
              if(data.returnCode==true){
                  self.$store.state.isLogin=false;
              }else{
                app.toast('注销失败')
              }
          })

      }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
        @import './info.scss'
</style>
