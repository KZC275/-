<template>
  <div id="app">
    <transition :name="transition" >
        <keep-alive include="addNote">  <!-- addNote组件会被缓存 -->
            <router-view></router-view>
        </keep-alive>
    </transition>
  </div>
</template>
<script>
import { mapGetters,mapMutations } from 'vuex'
export default {
  name: 'app',
  data(){
    return {
      transition:'right-to-left'
    }
  },
  computed: mapGetters([
    // 'isBack'
  ]),
  created(){

  },
  methods:{
      ...mapMutations([
          'transitionChange',
          'isBack'
    
      ]),
  },
  watch: {
  '$route' (to, from) {
    if(this.$store.state.isBack){
      this.transition='left-to-right';
      this.$store.state.isBack=false;

    }else{
        this.transition='right-to-left';
    }
    // console.log(to, from)
    
  },
}
  
}
</script>

<style lang='scss'>
/* 过渡阶段 */
.right-to-left-enter-active,.right-to-left-leave-active{
  transition: all 0.5s ease-out;
}
/* 页面进入时的位置 */
.right-to-left-enter{
  transform: translateX(100%);
  
}
/* 页面离开需要进入的终点 */
.right-to-left-leave-active{
  transform: translateX(-100%);
  
}

/* 过渡阶段 */
.left-to-right-enter-active,.left-to-right-leave-active{
  transition: all 0.5s ease-out;
}
/* 页面进入时的位置 */
.left-to-right-enter{
  transform: translateX(-100%);
  
}
/* 页面离开需要进入的终点 */
.left-to-right-leave-active{
  transform: translateX(100%);
  
}
body {
  margin: 0;
  padding: 0;
  width:100%;
  height:100%;  
  text-align: center;
  height: 100%;
  -moz-user-select: none;   /*长按无法选择文字*/
	-webkit-user-select: none;
	-ms-user-select: none;
	-khtml-user-select: none;
	user-select: none;
   font-size:0.15rem;
}

html {

  height: 100%;
}
#app{
  height: 100%;
}
#app>div{
  position:absolute;
  top:0px;
  width:100%;
}
ul,li,p,h1,h2,h3,h4{
  padding: 0;
  margin:0;
}
ul,a{
  list-style: none;
}
</style>
