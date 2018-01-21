// console.log(process.env.NODE_ENV)
import store from '../store'
  window.getImgUrl=function(url,httpUrl,flag){
 	// alert('url,httpUrl,flag');
 	store.state.src['num'+flag]=httpUrl;//网络路径
 	store.state.path['num'+flag]=url;//本地绝对路径
 }
  window.setLocation=function(location){
 	store.state.locationStr=location; //选择地址
 }
 // setLocation('ffff')
 // getImgUrl('./static/img/3.jpg','http://www.kzc275.top/img/profile.jpg',1)
export default {
	baseUrl:'http://www.kzc275.top',
	isBrowser:process.env.NODE_ENV=='development'?true:false
}