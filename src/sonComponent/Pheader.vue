<template>
      <div class="header">
          <div class="left" @click='back'>
              <slot name='left'></slot>
          </div>
          <slot>{{name}}</slot>
          <div class="right" @click="home(type)">
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
    'name':String,
    'title':String,
    'type':String
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
      back(){
        this.$store.state.isBack=true
        this.$router.back()
      },
      home(type){
            if(type){
            	this.$router.push({name:'cdbank_coupon_center',params:'home'})

            }
            this.$router.push({name:'index',params:'home'})
      }

  }
}
</script>

<style lang='scss' scoped>
    @import './Pheader.scss'
</style>
