<!--     天气网（www.tianqi.com ）天气插件接口      服务地址：http://i.tianqi.com/index.php      
 参数名   类型 是否必须  默认值  描述  备注
 c   string 是 无 获取方式，设置为"code"，表示获取代码。   
 id  dword  是 无 模板样式，建议设置为19   
 icon  dword  否 1 图标样式，范围1-5   
 py  string 否 客户  地方名全拼，默认为客户地方。   
 num   dword  否 5  预报天数 -->

<template>
  <div class="friend">
    <global-header name='broadcast' type='alert'>
        <span slot="left">back</span>
        <span slot="right">celebrate</span>
    </global-header>
    <h1>{{ msg }}</h1>
    <p>location : {{str}}</p>
    <p>今日天气</p>
    <p>明日天气</p>
    <iframe id="iframe" name="iframe" src="http://i.tianqi.com/index.php?c=code&id=19&icon=1&py=guangzhou&num=5" frameborder="0">抱歉，无法获取天气</iframe>
    
  </div>
</template>

<script>
  import Pheader from '../../components/Pheader'
export default {
  name: 'Friend',
  data () {
    return {
      msg: 'Welcome',
      str:''
    }
    
  },
  components:{
      'global-header':Pheader
  },
  created(){
      // console.log(this)
        this.location()
        this.weather()
       
      

    },
    mounted(){
        
    },
    methods:{

      weather(){
        if(app.isBrowser)return false;
        //http://www.sojson.com/open/api/weather/json.shtml?city=%E9%A1%BA%E5%BE%B7
        //http://api.map.baidu.com/telematics/v3/weather?location=广州&output=JSON&ak=uBuiwKr0QniXXXBw64r7pcghklP1ErLk
        
      },
      location(){
        if(app.isBrowser)return false;
          var self=this;
          plus.geolocation.getCurrentPosition( geoInf, function ( e ) {
              alert( "获取定位位置信息失败："+e.message );
            },{geocode:true});

          function geoInf( position ) {
            var str = "";
            str += "地址："+position.addresses+"\n";//获取地址信息
            str += "坐标类型："+position.coordsType+"\n";
            var timeflag = position.timestamp;//获取到地理位置信息的时间戳；一个毫秒数；
            str += "时间戳："+timeflag+"\n";
            var codns = position.coords;//获取地理坐标信息；
            var lat = codns.latitude;//获取到当前位置的纬度；
            str += "纬度："+lat+"\n";
            var longt = codns.longitude;//获取到当前位置的经度
            str += "经度："+longt+"\n";
            var alt = codns.altitude;//获取到当前位置的海拔信息；
            str += "海拔："+alt+"\n";
            var accu = codns.accuracy;//地理坐标信息精确度信息；
            str += "精确度："+accu+"\n";
            var altAcc = codns.altitudeAccuracy;//获取海拔信息的精确度；
            str += "海拔精确度："+altAcc+"\n";
            var head = codns.heading;//获取设备的移动方向；
            str += "移动方向："+head+"\n";
            var sped = codns.speed;//获取设备的移动速度；
            str += "移动速度："+sped;
            console.log(str)
            self.str=str;
            // console.log(JSON.stringify(position));
            // outLine( str );
          }
      }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
@import './friend.scss';
</style>
