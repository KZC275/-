import Vue from 'vue'
import Pheader from '@/components/Pheader'
import Test from '@/components/test'
import 'swiper/swiper-bundle.css'
import Viewer from 'v-viewer'
import 'viewerjs/dist/viewer.css'
import { AlertPlugin, ToastPlugin, LoadingPlugin, ConfirmPlugin } from 'vux'

Vue.use(AlertPlugin)
Vue.use(ToastPlugin)
Vue.use(LoadingPlugin)
Vue.use(ConfirmPlugin)
window.$vux = Vue.$vux
// console.log($vux)

Vue.component('global-header', Pheader)
Vue.component('test', Test)

Vue.use(Viewer, {
  defaultOptions: {
    'navbar': true,
    'toolbar': false,
    'movable': false,
    'title': false,
    'zoomable': true,
    'scalable': true,
    'transition': true,
    url: 'src'
  }
})
