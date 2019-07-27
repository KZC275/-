<template>
  <div class="app_main">
    <div class="headerTop">
      <global-header ref='gheader'
                     leftName="myNote"
                     rightName="addNote"
                     v-model="jjkjjk">
        <span slot="left">my note</span>
        <span>猕猴桃</span>
        <span slot="right">add</span>
        <!-- <span slot="jjkk">啊啊啊烦</span> -->
        <!-- <span slot="kkll">=-22ndndn</span> -->
      </global-header>
    </div>

    <div class="message">
      <h3>Today is nice</h3>
      <h3>vuex test {{my_Note}}</h3>
      <p>当前状态：{{weather}}</p>
    </div>
    <div class="bottom">
      <router-link to="/world">关于</router-link>
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
import Pheader from '../../components/Pheader'
export default {
  name: 'index',
  data() {
    return {
      my_Note: '',
      weather: '',
      jjkjjk: 'sjsjjsjssjj'
    }
  },
  created() {
    this.weather = this.$store.state.isLogin
      ? this.$store.state.username
      : '游客'
    this.my_Note = this.$store.state.count
  },
  mounted() {
    this.$refs.gheader
  },
  methods: {
    getLocation() {
      var x = {}
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
          x.innerHTML = 'Geolocation is not supported by this browser.';
        }
      }
      function showPosition(position) {
        // x.innerHTML =
        //   'Latitude: ' +
        //   position.coords.latitude +
        //   '<br />Longitude: ' +
        //   position.coords.longitude;
        x.latitude = position.coords.latitude
        x.longitude = position.coords.longitude
      }
      function showError(error) {
        switch (error.code) {
          case error.PERMISSION_DENIED:
            x.innerHTML = 'User denied the request for Geolocation.';
            break;
          case error.POSITION_UNAVAILABLE:
            x.innerHTML = 'Location information is unavailable.';
            break;
          case error.TIMEOUT:
            x.innerHTML = 'The request to get user location timed out.';
            break;
          case error.UNKNOWN_ERROR:
            x.innerHTML = 'An unknown error occurred.';
            break;
          default:
            x.innerHTML = 'unsupposed error';
        }
      }
    },
    postLocation() {
      app.post({
        url: "/php/getLocation.php",
        data: x,
      }).then(data => {
        console.log(data);

      }).catch(error => {
        app.toast("请求失败");
      });
    }
  }
}
</script>

<style lang='scss'>
@import './index.scss';
</style>
