<template>
    <div class="app_main">
      
      <global-header leftName="myNote" rightName="addNote">
        <span slot="left">my note</span>
        <span>index</span>
        <span slot="right">add note</span>
      </global-header>
      <div class="message">
          <h3>Today is nice</h3>
          <p>时间</p>
          <p>地点</p>
          <p>当前状态：{{weather}}</p>
      </div>
      <div class="bottom">
          <router-link to="/experience">experience</router-link>
          <router-link to="/diary">picture</router-link>
          <router-link to="/friend">friend</router-link>
          <router-link to="/info">我的</router-link>
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
      my_Note:'my',
      weather:''
      
    }
  },
  created(){
	// $.post('http://www.kzc275.top/php/reg.php',{type:'check'},function(d){
	// 	console.log(d)
	// })
    
//        console.log(this.$store.state)
    this.weather=this.$store.state.count
  },
  components:{
      'global-header':Pheader
  }
}
</script>

<style lang='scss'>
    @import './index.scss'
</style>
