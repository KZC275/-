<template>
  <div class="info">
    <global-header name="用户信息">
        <!-- <span slot='left'>back</span> -->
    </global-header>
    <div class="msg" v-if="this.$store.state.isLogin==false">
        <div class="forget"><span @click="goReg(1)">忘记密码</span></div>
        <h3>登录</h3>
        <input v-model="username" type="text" placeholder="username">
        <input v-model="psw" type="password" placeholder="password">
        <div class="button">
          <span @click="goReg(2)">register</span>
          <span @click="login(username,psw)">login</span>
        </div>
    </div>
    <div v-else class="user">
       <h2>你已经登录</h2>
       <span @click="logout">注销</span>
    </div>
  </div>
</template>

<script>
 
export default {
   name: 'info',
   data () {
     return {
       msg: 'info',
       email: '',
       username: 'qwqw',
       psw: '123',
       show5: false,
       ssww: 'sdsds'
     }
   },
   components: {
 
   },
   created () {

   },
   methods: {
     goReg (type) {
       this.$router.push({name: 'register', params: {type: type}})
     },
     check () {
       console.log(222)
     },
     login (u, p) {
       let self = this
       app
        .post({
          url: '/php/login.php',
          data: { username: u, psw: p }
        })
        .then(data => {
          console.log(data)
          if (data.returnCode == true) {
            self.$store.state.isLogin = true
            self.$store.state.username = u // 保存用户名
            self.$router.push({
              name: 'index',
              params: 'from info'
            })
            console.log(data.currentUid)
          } else {
            app.toast(data.returnCode)
            if (data.returnDes == 'wp') {
              this.email = prompt('输入注册邮箱找回密码')
              this.email && this.findpsw(this.email)
            }
          }
        })
        .catch(error => {
          app.toast('请求失败')
        })
     },
     register (u, p, email) {
       app
        .post({
          url: '/php/register.php',
          data: { username: u, psw: p, email: email}
        })
        .then(data => {
          console.log(data)
          if (data.returnCode == true) {
            app.toast('注册成功')
          } else {
            app.toast(data.returnCode)
          }
        })
     },
     logout () {
       let self = this
       app
        .post({
          url: '/php/loginOut.php'
        })
        .then(data => {
          console.log(data)
          if (data.returnCode == true) {
            self.$store.state.isLogin = false
          } else {
            app.toast('注销失败')
          }
        })
     },
     findpsw (email) {
       console.log('sd')
       app
        .post({
          url: '/php/sent_mail.php',
          data: { email: email }
        })
        .then(data => {
          console.log(data)
        })
        .catch(error => {
          app.toast('请求失败')
        })
     }
   }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
@import "./info.scss";
</style>
