import Vue from 'vue'
import Pheader from '@/components/Pheader'
import {AlertPlugin, ToastPlugin, LoadingPlugin, ConfirmPlugin} from 'vux'

Vue.use(AlertPlugin)
Vue.use(ToastPlugin)
Vue.use(LoadingPlugin)
Vue.use(ConfirmPlugin)
window.$vux = Vue.$vux
console.log($vux)

Vue.component('global-header', Pheader)
