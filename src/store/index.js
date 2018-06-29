import Vue from 'vue'
import Vuex from 'vuex'

import couponCenter from '../module/cgb_coupon_center/store'
import myNote from '../module/myNote/store'

Vue.use(Vuex)

const state = {
  isLogin: false,
  username: '',
  showMask: false, // 遮罩
  isShutDown: null, // 点击遮罩回调函数
  count: 18,
  isBack: false,
  transition: 'right-to-left',
  backfromdetail: false // 从记事详情页返回列表页

}
// 改变状态的事件
const mutations = {
  isBack () {
    state.isBack = false
  },
  increment (state) {
    console.log(this)
  	state.count++
  },
  decrement (state) {
    state.count--
  },
  transitionChange (state, load) {
  	if (state.isBack) {
  		state.transition = 'left-to-right'
  	} else {
  		state.transition = 'right-to-left'
  	}
  }
}
// commit mutation
const actions = {
  changeisBack: ({commit}) => {
  	commit('isBack')
  },
  increment_add: ({ commit }) => {
  	commit('increment')
  	console.log(arguments)
  },
  decrement_add: ({ commit }) => commit('decrement'),
  incrementIfOdd ({ commit, state }) {
    if ((state.count + 1) % 2 === 0) {
      commit('increment')
    }
  },
  incrementAsync ({ commit }) {
    return new Promise((resolve, reject) => {
      setTimeout(() => {
        commit('increment')
        resolve()
      }, 1000)
    })
  }
}

// getters are functions
const getters = {
  evenOrOdd: state => state.count % 2 === 0 ? 'even' : 'odd',
  transition: state => state.transition,
  isBack: state => state.isBack,
  getSrc: state => state.src,
  getPath: state => state.path,
  getlocationStr: state => state.locationStr
}

const modules = {
  couponCenter,
  myNote
}

// A Vuex instance is created by combining the state, mutations, actions,
// and getters.
export default new Vuex.Store({
  state,
  getters,
  actions,
  mutations,
  modules
})
