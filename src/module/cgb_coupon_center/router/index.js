import APP_ from '../APP'
import Center from '../pages/couponCenter.vue'

export default [{
  path: '/collectCoupon',
  name: 'cdbank_coupon_center',
  redirect: {
    name: 'cgb_coupon_center'
  },
  component: APP_,
  children: [{
    path: 'couponCenter',
    name: 'cgb_coupon_center',
    component: Center
  }]
}]
