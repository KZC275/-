<template>
    <div class="app_main">
      <div class="headerTop">
          <global-header ref='gheader' leftName="myNote" rightName="addNote" >
            <span slot="left"></span>
            <span>say something</span>
            <span slot="right">我要说</span>
            <!-- <span slot="jjkk">啊啊啊烦</span> -->
            <!-- <span slot="kkll">=-22ndndn</span> -->
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

      <div class="button" @click="move">到底部</div>
      
    </div>
</template>
<script>
import Pheader from '../../components/Pheader'
export default {
  name: 'index',
  data () {
    return {
     data:[]
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
    movement(){

    }
  }
}
</script>

<style lang='scss'>
@import "./index.scss";
</style>
