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
          <!-- 需要test组件提供slot出口 jjkk，kkll才能有用 -->
          <!-- <test>
              <slot name="jjkk"></slot>
              <slot name="kkll"></slot>
          </test> -->
      </div>
</template>
<script>
import { mapMutations } from 'vuex'
// import Test from './test.vue'
export default {
  name: 'Pheader',
  data () {
    return {
    }
  },
  components: {
    // 'test': Test
  },
  props: {
    'leftName': String,
    'name': String,
    'title': String,
    'rightName': String,
    'value': String  // 父组件通过v-model绑定的可以得到

  },
  created () {

  },
  mounted () {
    // console.log(this)
  },
  methods: {
    ...mapMutations([
      'transitionChange'

    ]),
    back (name) {
      if (name) {
        this.$router.push({name: name, params: 'home'})
        return
      }
      this.$store.state.isBack = true
      this.$router.back()
    },
    home (type) {
      event.cancelBubble = true
      event.stopPropagation()
      // console.log('Pheader.scss')
      if (type) {
            	// console.log(type)
            	this.$router.push({name: type, params: type})
      }
    }

  }
}
</script>

<style lang='scss' scoped>
    @import './Pheader.scss'
</style>
