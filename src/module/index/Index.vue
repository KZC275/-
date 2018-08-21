<template>
    <div class="app_main">
      <div class="headerTop">
          <global-header ref='gheader' leftName="myNote" rightName="addNote" >
            <span slot="left"></span>
            <span>say something</span>
            <span class="right" slot="right" @click="mask=true">我要说</span>
          </global-header>
      </div>

      <div class="content">
        <ul>
          <li class="item" v-for="item in data">
            <div class="top">
              <p class="name">{{item.nickName}} 说：</p>
              <span class="time">{{item.time}}</span>
            </div>
            <div class="bottom">
                <p>{{item.content}}</p>
            </div>
          </li>
        </ul>
      </div>
      <div class="mask" v-if="mask" @click.stop.prevent="mask=false"></div>

      <div class="dialog" v-if="mask">
        <textarea class="textarea" v-model="result" placeholder="你想说什么"></textarea>
        <input type="text" name="" placeholder="你的昵称" v-model="name">
        <span class="btn" @click="send(result,name)">发送</span>
      </div>

      <div class="button" @click="move">到底部</div>

      <img src="@/assets/img/background.jpg" class="bgpic">
      
    </div>
</template>
<script>
import Pheader from '../../components/Pheader'
export default {
  name: 'index',
  data () {
    return {
     data:[],
     mask: false,
     name: '',
     result: ''
    }
  },
  created () {
    app
      .post({
        url: "/php/reg.php",
        data:{type:'check'}
      })
      .then(data => {
        this.data=data
        console.log( data);
      })

    
  },
  mounted () {
  },
  methods:{
    move (){
      console.log('move')
      let scrollTop= document.documentElement.scrollTop;
      let docHeight= document.documentElement.scrollHeight
      let clientHeight= document.documentElement.clientHeight

      setTimeout(()=>{
        // 缓冲运动
        window.scrollTo(0,scrollTop=scrollTop+((docHeight-clientHeight-scrollTop)/6<1? 1 : (docHeight-clientHeight-scrollTop)/6))
        if(scrollTop<=docHeight-clientHeight-1){
          this.move()
        }
      },16)
    },
    send (msg, name) {
      // 获取better-scroll实例
      if (msg) {
        name = name.trim() ? name.trim() : '匿名者'
        // name = "(" + ++self.i + " floor " + ")" + name;
        // 获取时间
        var date = new Date()
        // console.log(date);s
        var year = date.getFullYear()
        var month = date.getMonth()
        var day = date.getDate()
        var h = date.getHours()
        var m = date.getMinutes()
        var s = date.getSeconds()
        var TimeStr =
          year +
          '年' +
          (month + 1) +
          '月' +
          day +
          '日' +
          h +
          '时' +
          m +
          '分' +
          s +
          '秒'
        app
          .post({
            url: '/php/reg.php',
            data: {
              type: 'add',
              nickName: name,
              content: msg,
              time: TimeStr
            }
          })
          .then(data => {

            this.data.push({
              time: TimeStr,
              content: msg,
              nickName: name
            })
            app.toast('发送成功')
            this.mask = false
            this.move()
          })
          .catch(error => {
            this.mask = false
            app.toast('error')
          })
      } else {
        app.toast('信息不能为空噢')
      }
    },
  }
}
</script>

<style lang='scss' scoped>
@import "./index.scss";
</style>
