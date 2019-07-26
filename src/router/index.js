import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/module/index/Index'
import Experience from '@/module/experience/Experience'
import Friend from '@/module/friend/Friend'
import Diary from '@/module/diary/Diary'
import MyNote from '@/module/myNote/MyNote'
import Detail from '@/module/detail/Detail'
import World from '@/module/world/World'
import AddNote from '@/module/addNote/AddNote'
import Analysis from '@/module/analysis/Analysis'
import Game from '@/module/game/Game'
import Rank from '@/module/game/rank'
import info from '@/module/info/info'  // 组件小写也可以
import register from '@/module/register/reg'  // 组件小写也可以

import CouponCenter from '../module/cgb_coupon_center/router'

import store from '../store'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/index',
      name: 'index',
      component: Index
    },
    {
      path: '/experience',
      name: 'Experience',
      component: Experience

    },
    {
      path: '/game',
      name: 'game',
      component: Game

    },
    {
      path: '/rank',
      name: 'rank',
      component: Rank

    },
    {
      path: '/analysis',
      name: 'Analysis',
      component: Analysis

    },
    {
      path: '/friend',
      name: 'Friend',
      component: Friend
    },
    {
      path: '/info',
      name: 'info',
      component: info
    },
    {
      path: '/diary',
      name: 'Diary',
      component: Diary
    },
    {
      path: 'detail',
      name: 'detail',
      component: Detail
    },
    {
      path: '/myNote',
      name: 'myNote',
      component: MyNote
    },
    {
      path: '/addNote',
      name: 'addNote',
      component: AddNote
    },
    {
      path: '/world',
      name: 'appCouponCenter',
      component: World
    },
    {
      path: '/register',
      name: 'register',
      component: register
    },
    ...CouponCenter,
    {
    	path: '*',
    	redirect: Index
    }
  ]
})
// 全局路由守卫
router.beforeEach((to, from, next) => {
  // console.log('navigation-guards');
  // to: Route: 即将要进入的目标 路由对象
  // from: Route: 当前导航正要离开的路由
  // next: Function: 一定要调用该方法来 resolve 这个钩子。执行效果依赖 next 方法的调用参数。

  const nextRoute = ['addNote', 'myNote']
  let isLogin = store.state.isLogin  // 是否登录
  // 未登录状态；当路由到nextRoute指定页时，跳转至login
  if (nextRoute.indexOf(to.name) >= 0) {
    if (!isLogin) {
      router.push({ name: 'info' })
    }
  }

  next()
})
export default router
