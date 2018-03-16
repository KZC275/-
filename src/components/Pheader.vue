<template>
      <div class="header">
          <div class="left" @click='back(leftName)'>
              <slot name='left'><span class="icon"><img src="../assets/img/back.png" alt=""></span></slot>
          </div>
          <div class="middle">
              <slot>{{name}}</slot>
          </div>
          <div class="right" @touchend="home(rightName)">
              <slot name='right'></slot>
          </div>
      </div>
</template>
<script>
import { mapMutations } from 'vuex'
export default {
  name:'Pheader',
  data(){
    return {
      
    }
  },
  props:{
    'leftName':String,
    'name':String,
    'title':String,
    'rightName':String
  },
  created(){
        // console.log(this.name)
  },
  mounted(){
  },
  methods:{
      ...mapMutations([
    'transitionChange',
    
      ]),
      back(name){
        if(name){
          this.$router.push({name:name,params:'home'})
          return;

        }
        this.$store.state.isBack=true
        this.$router.back()
      },
      home(type){
        event.cancelBubble=true;
        event.stopPropagation();
        console.log('Pheader.scss')
            if(type){
            	console.log(type)
            	this.$router.push({name:type,params:type});
            	return;

            }
      }

  }
}
</script>

<style lang='scss' scoped>
    @import './Pheader.scss'
</style>
