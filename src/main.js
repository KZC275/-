// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import Vuex from 'vuex'
import App from './App'
import router from './router'
import store from './store'
import init from './utils/init.js'
import app from './utils/common.js'
(function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    window.videojs=videojs
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth>=640){
                        docEl.style.fontSize = '100px';
                    }else{
                        docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                    }
                };

            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);

Vue.config.productionTip = false
/* eslint-disable no-new */
// console.log(store)
// 映射__store,router为全局对象
window.__store = store
window.__router = router
window.app = app
window.vm_bank = new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: { App }
})
