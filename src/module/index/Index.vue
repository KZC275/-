<template>
    <div class="app_main">
      <div class="headerTop">
          <global-header leftName="myNote" rightName="addNote" v-model="jjkjjk">
            <span slot="left">my note</span>
            <span>index</span>
            <span slot="right">add</span>
          </global-header>
      </div>
      
      <div class="message">
          <h3>Today is nice</h3>
          <h3>vuex test {{my_Note}}</h3>
          <p>当前状态：{{weather}}</p>
      </div>
      <div class="bottom">
          <router-link to="/experience">组件</router-link>
          <router-link to="/analysis">统计</router-link>
          <router-link to="/diary">上拉下拉</router-link>
          <router-link to="/friend">留言板</router-link>
          <router-link to="/info">注册登录</router-link>
      </div>
      <div>
          <router-view></router-view>
      </div>
    </div>
</template>
<script>
import Pheader from "../../components/Pheader";
export default {
  name: "index",
  data() {
    return {
      my_Note: "",
      weather: "",
      jjkjjk: "sjsjjsjssjj"
    };
  },
  created() {
    // app
    //   .post({
    //     url: "/php/sent_mail.php",
    //     data:{email:'1142308041@qq.com'}
    //   })
    //   .then(data => {
    //     console.log( JSON.parse(data));
    //   })
    //   .catch(error => {
    //     app.toast("请求失败");
    //   });

    //        console.log(this.$store.state)
    this.weather = this.$store.state.isLogin
      ? this.$store.state.username
      : "游客";
    this.my_Note = this.$store.state.count;
  },
  components: {
    "global-header": Pheader
  }
};
</script>

<style lang='scss'>
@import "./index.scss";
</style>
