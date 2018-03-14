// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Vuex from 'vuex'
import App from './App'
import router from './router'
import store from './store'
import app from './utils/common.js'

import  { AlertPlugin } from 'vux'
Vue.use(AlertPlugin)

Vue.config.productionTip = false

/* eslint-disable no-new */
// console.log(store)
//映射__store,router为全局对象
window.__store=store;
window.__router=router;
window.app=app;
var vm_bank=new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: { App }
})
