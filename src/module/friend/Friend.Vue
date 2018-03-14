<!--     天气网（www.tianqi.com ）天气插件接口      服务地址：http://i.tianqi.com/index.php      
 参数名   类型 是否必须  默认值  描述  备注
 c   string 是 无 获取方式，设置为"code"，表示获取代码。   
 id  dword  是 无 模板样式，建议设置为19   
 icon  dword  否 1 图标样式，范围1-5   
 py  string 否 客户  地方名全拼，默认为客户地方。   
 num   dword  否 5  预报天数 -->

<template>
  <div class="friend">
    <div>
        <global-header name='sayings' >
            <!-- <span slot="left">back</span> -->
            <span slot="right" @touchend.stop="something">留言</span>
        </global-header>
    </div>
    
    <div class="friendList">
        <slider 
        ref=scroll
        :pullDown="false"
        :pullUp="false"
        :data="list"
        >
            <div>
                <div class="listNum" v-for="(item,index) in list">
                <strong>{{item.nickName}} 说：</strong>
                <p>{{item.content}} </p>
                <span>{{item.time}}</span>
                </div>
            </div>
        </slider>

        <div class="btn" @touchend='gotobtm'>到底部</div>
        

    </div>
    <div class="content" v-if="showt">
        <textarea v-model="msg" placeholder="你想说什么？"></textarea>
        <input v-model="name" type="text" placeholder="你的昵称？">
        <span @touchend="send(msg,name)">发送</span>
    </div>
    

    
    
  </div>
</template>

<script>
import Pheader from "../../components/Pheader";
import slider from "../diary/list.vue";
export default {
  name: "Friend",
  data() {
    return {
      msg: "Welcome",
      str: "",
      list: [],
      showt: false,
      msg: "",
      name: "",
      i: ""
    };
  },
  components: {
    "global-header": Pheader,
    slider
  },
  created() {
    // this.location()
    this.askList();
    // this.$vux.alert.show({
    //   title: "Vux is Cool",
    //   content: "Do you agree?",
    //   onShow() {
    //     console.log("Plugin: I'm showing");
    //   },
    //   onHide() {
    //     console.log("Plugin: I'm hiding");
    //   }
    // });

    // window.open('http://www.baidu.com')
  },
  mounted() {},
  methods: {
    something() {
      this.showt = true;
      this.$store.state.showMask = true;
      this.$store.state.isShutDown = () => {
        this.showt = false;
        this.$store.state.showMask = false;
      };
      // console.log(this.$refs.scroll.scroll.scrollTo(0,-3000))
      // console.log(this.$refs.scroll.scroll.maxScrollY)
      // console.log(this.$refs.scroll.scroll.y)
    },
    gotobtm() {
      this.move();
    },
    send(msg, name) {
      //获取better-scroll实例

      var self = this;
      if (msg) {
        name = name.trim() ? name.trim() : "匿名者";
        //如果已经登录，取用户名
        if (self.$store.state.username && name == "匿名者") {
          name = self.$store.state.username;
        }
        name = "(" + ++self.i + " floor " + ")" + name;
        //获取时间
        var date = new Date();
        // console.log(date);s
        var year = date.getFullYear();
        var month = date.getMonth();
        var day = date.getDate();
        var h = date.getHours();
        var m = date.getMinutes();
        var s = date.getSeconds();
        var TimeStr =
          year +
          "年" +
          (month + 1) +
          "月" +
          day +
          "日" +
          h +
          "时" +
          m +
          "分" +
          s +
          "秒";
        app
          .post({
            url: "/php/reg.php",
            data: {
              type: "add",
              number: self.i,
              nickName: name,
              content: msg,
              time: TimeStr
            }
          })
          .then(data => {
            app.maskCallBack(self.$store.state.isShutDown);

            self.showt = false;
            self.list.push({
              time: TimeStr,
              content: msg,
              nickName: name,
              number: self.i
            });
            app.toast("发送成功");
            this.move();
          })
          .catch(error => {
            app.maskCallBack(self.$store.state.isShutDown);
            self.showt = false;
          });
      } else {
        app.toast("信息不能为空噢");
      }
    },
    move() {
      var _scroll = this.$refs.scroll.scroll;
      var temp = _scroll.y;
      var timer = setInterval(function() {
        if (temp <= _scroll.maxScrollY) {
          clearInterval(timer);
          console.log(222);
        } else {
          temp -= 30;
          _scroll.scrollTo(0, temp);
        }
      }, 1);
    },
    askList() {
      app
        .post({
          url: "/php/reg.php",
          data: {
            type: "check"
          }
        })
        .then(data => {
          // console.log(data)
          if (data.length > 0) {
            this.list = data;
            this.i = data.length;
          }
        });
    },
    weather() {
      if (app.isBrowser) return false;
      //http://www.sojson.com/open/api/weather/json.shtml?city=%E9%A1%BA%E5%BE%B7
      //http://api.map.baidu.com/telematics/v3/weather?location=广州&output=JSON&ak=uBuiwKr0QniXXXBw64r7pcghklP1ErLk
    },
    location() {
      if (app.isBrowser) return false;
      var self = this;
      plus.geolocation.getCurrentPosition(
        geoInf,
        function(e) {
          app.toast("获取定位位置信息失败：" + e.message);
        },
        { geocode: true }
      );

      function geoInf(position) {
        var str = "";
        str += "地址：" + position.addresses + "\n"; //获取地址信息
        str += "坐标类型：" + position.coordsType + "\n";
        var timeflag = position.timestamp; //获取到地理位置信息的时间戳；一个毫秒数；
        str += "时间戳：" + timeflag + "\n";
        var codns = position.coords; //获取地理坐标信息；
        var lat = codns.latitude; //获取到当前位置的纬度；
        str += "纬度：" + lat + "\n";
        var longt = codns.longitude; //获取到当前位置的经度
        str += "经度：" + longt + "\n";
        var alt = codns.altitude; //获取到当前位置的海拔信息；
        str += "海拔：" + alt + "\n";
        var accu = codns.accuracy; //地理坐标信息精确度信息；
        str += "精确度：" + accu + "\n";
        var altAcc = codns.altitudeAccuracy; //获取海拔信息的精确度；
        str += "海拔精确度：" + altAcc + "\n";
        var head = codns.heading; //获取设备的移动方向；
        str += "移动方向：" + head + "\n";
        var sped = codns.speed; //获取设备的移动速度；
        str += "移动速度：" + sped;
        console.log(str);
        self.str = str;
        // console.log(JSON.stringify(position));
        // outLine( str );
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
@import "./friend.scss";
</style>
