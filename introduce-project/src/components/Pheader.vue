<template>
      <div class="header">
          <div class="left" @click='back(leftName)'>
              <slot name='left'><span>back</span></slot>
          </div>
          <slot>{{name}}</slot>
          <div class="right" @click="home(rightName)">
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
            if(type){
            	console.log(type)
            	this.$router.push({name:type,params:'home'})
            	return;

            }
            this.$router.push({name:'index',params:'home'})
      }

  }
}
</script>

<style lang='scss' scoped>
    @import './Pheader.scss'
</style>
