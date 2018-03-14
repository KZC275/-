<template>
    <div class="app_main">
      <div class="headerTop">
          <global-header leftName="myNote" rightName="addNote">
            <span slot="left">my note</span>
            <span>index</span>
            <span slot="right">add note</span>
          </global-header>
      </div>
      
      <div class="message">
          <h3>Today is nice</h3>
          <h3>vuex test {{my_Note}}</h3>
          <p>当前状态：{{weather}}</p>
      </div>
      <div class="bottom">
          <router-link to="/experience">组件</router-link>
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
  data(){
    return {
      my_Note:'',
      weather:''
      
    }
  },
  created(){
	// $.post('http://www.kzc275.top/php/reg.php',{type:'check'},function(d){
	// 	console.log(d)
	// })
    
//        console.log(this.$store.state)
    this.weather=this.$store.state.isLogin?this.$store.state.username:'游客'
    this.my_Note=this.$store.state.count
  },
  components:{
      'global-header':Pheader
  }
}
</script>

<style lang='scss'>
    @import './index.scss'
</style>
