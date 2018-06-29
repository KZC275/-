<template>
  <div id="app">
    <transition :name="transition" >
        <keep-alive include="info,addNote,myNote">  <!-- addNote组件会被缓存,为空的话缓存所有组件 -->
            <router-view></router-view>
        </keep-alive>
    </transition>

    <div class="app_cover" v-if="$store.state.showMask" @touchend="hideMask"></div>
    <span class="ac_toast"></span>
  </div>
</template>
<script>
import { mapGetters, mapMutations } from 'vuex'
export default {
  name: 'app',
  data () {
    return {
      transition: 'right-to-left'
    }
  },
  computed: mapGetters([
    // 'isBack'
  ]),
  created () {
    console.log(location.href = location.href)
    // this.$router.push({name: 'index'})
  },
  methods: {
    hideMask () {
      window.app.maskCallBack(this.$store.state.isShutDown)
    },
    ...mapMutations([
      'transitionChange',
      'isBack'

    ])
  },
  watch: {
    '$route' (to, from) {
      if (this.$store.state.isBack) {
        this.transition = 'left-to-right'
        this.$store.state.isBack = false
      } else {
        this.transition = 'right-to-left'
      }
    // console.log(to, from)
    }
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
  -moz-user-select: none;   /*长按无法选择文字*/
	-webkit-user-select: none;
	-ms-user-select: none;
	-khtml-user-select: none;
	user-select: none;
   font-size:0.3rem;
   color:black;
   overflow-x: hidden;
}

html {

  height: 100%;
}
.app_cover{
  background:#ccc;
  opacity:0.2;
  z-index: 99;
}
#app{
  height: 100%;
}
#app>div{
  position:absolute;
  top:0px;
  width:100%;
  height: 100%;
  display: flex;
  flex-direction:column;
}
ul,li,p,h1,h2,h3,h4{
  padding: 0;
  margin:0;
}
ul,a{
  list-style: none;
}
#app .ac_toast{
  /*height: 1rem;*/
  /*line-height: 1rem;*/
  padding: 0.3rem 1rem;
  /*width: 30%;*/
  border-radius: 0.1rem;
  text-align: center;
  background:black;
  display:none;
  color:white;
  position:absolute;
  left:50%;
  top:30%;
  transform:translateX(-50%);
}

</style>
