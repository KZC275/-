<!-- 使用方法 -->
<!--
/*
1.是否开启上拉加载 pullUp=true,开启，false关闭 默认false
2.是否开启下拉刷新 pullDown=true,开启，false关闭 默认false
3.上拉加载触发的方法 
4.下拉刷新触发的方法 
5.循环的数据
@example
:pullDown="true" 
:pullUp="true"
v-on:pullup="pullup"
v-on:pulldown="pulldown"
:data='dataList' 
*/
-->
<template>
	<div ref="wrapper" class="root">
		
		<div ref="content" >
			<div v-if="pullDown" class="pulldownTip" >{{pulldownTip.text}}</div>
			<div class="list">
				<slot ></slot>
			</div>
			<div v-if="pullUp"  class="pullupTip">{{pullupTip.text}}</div>
		</div>
	</div>
</template>
<script>
	import BScroll from 'better-scroll'

	export default {
		name:'pullUpAndDown',
		props: {
			/**
			 * 1 滚动的时候会派发scroll事件，会截流。
			 * 2 滚动的时候实时派发scroll事件，不会截流。
			 * 3 除了实时派发scroll事件，在swipe的情况下仍然能实时派发scroll事件
			 */
			probeType: {
				type: Number,
				default: 1
			},
			/**
			 * 点击列表是否派发click事件
			 */
			click: {
				type: Boolean,
				default: true
			},
			/**
			 * 是否开启横向滚动
			 */
			scrollX: {
				type: Boolean,
				default: false
			},
			/**
			 * 是否派发滚动事件
			 */
			listenScroll: {
				type: Boolean,
				default: true
			},
			/**
			 * 列表的数据
			 */
			data: {
				type: Array,
				default: null
			},
			/**
			 * 是否派发滚动到底部的事件，用于上拉加载
			 */
			pullUp: {
				type: Boolean,
				default: false
				
			},
			/**
			 * 是否派发顶部下拉的事件，用于下拉刷新
			 */
			pullDown: {
				type: Boolean,
				default: false
				
			},
			/**
			 * 是否派发列表滚动开始的事件
			 */
			beforeScroll: {
				type: Boolean,
				default: false
			},
			/**
			 * 当数据更新后，刷新scroll的延时。
			 */
			refreshDelay: {
				type: Number,
				default: 100
			},
			finishDown:Boolean
			
		
		},
		data() {
			return {
				pullingDown:false, //下拉事件被触发
				pullingUp:false,
				pulldownTip: {
					text: '下拉刷新', // 松开立即刷新
				},
				nomore:false, //底部显示没有更多
				pullupTip:{
					nomore:false,//没有更多
					text:'上拉加载更多',

				},
				isFirst:true,//是否首次加载
				

			};
		},
		mounted() {
			// 保证在DOM渲染完毕后初始化better-scroll
			setTimeout(() => {
				// console.log(this.$refs.wrapper.parentNode.clientHeight)

				this._initScroll()
			}, 1000)
		},
		methods: {
			_initScroll() {
				if(!this.$refs.wrapper) {
					return;
				}

				// better-scroll的初始化参数
				let params={
						probeType: this.probeType,
						click: this.click,
						scrollX: this.scrollX,
						scrollY: true,
						pullDownRefresh: this.pullDown?{
							threshold: 50,
							 stop: 60
						}:false,
						pullUpLoad:this.pullUp?{
							threshold: -40 // 在上拉到超过底部 40px 时，触发 pullingUp 事件
						}:false
				}
				this.scroll = new BScroll(this.$refs.wrapper,params );

				//监听下拉刷新事件
				this.scroll.on('pullingDown', () => {
					this.pullingDown=true;
					console.log(this.pullingDown)
					setTimeout(()=>{
						this.$emit('pulldown')
					},100)
					
					this.pulldownTip = {
					text: '刷新中...', // 松开立即刷新
					rotate: '' // icon-rotate
					}
					this.nomore=false; //释放上拉加载
					this.pullupTip.text='上拉加载更多';
					
			

				})
				//上拉加载无需放开手指即可加载
				this.scroll.on('pullingUp', () => {
					console.log('pullingUp')
					if(this.nomore){
						this.scroll.finishPullUp();
						return false; //没有更多时锁定上拉加载
					}
					this.pullingUp=true;
					// this.pullingDown=false;
					setTimeout(()=>{
						this.$emit('pullup');
						this.pullupTip.text='加载中...';
					},100)
					

				})

				//下拉刷新回位时，也会触发滚动事件。因此需要开关flag控制
				let flag=true;
				this.scroll.on('scroll', (pos) => {
					if(pos.y>0&&pos.y<50){
						flag=true;
					}
					if(pos.y>=50&&flag){
						flag=false;
						this.pulldownTip = {
							text: '松开刷新...', // 松开立即刷新
							rotate: '' // icon-rotate
						}
					}
				})
				this.scroll.on('touchEnd', (pos) => {
					// 下拉动作
					if(pos.y > 50) {
						// console.log('touchEnd')
					}
				});


			},
			refresh() {
				// 代理better-scroll的refresh方法
				this.scroll && this.scroll.refresh();
			}
			
		},
		watch: {
			// 监听数据的变化，延时refreshDelay时间后调用refresh方法重新计算，保证滚动效果正常
			data(newVal,oldVal) {
				setTimeout(() => {
					console.log(newVal,oldVal);
					if(this.$refs.content.clientHeight<this.$refs.wrapper.parentNode.clientHeight){
						this.isFirst=false;
						//第一页数据高度不足
						this.pullupTip.text='没有更多了';
					}
					//设置盒子高度
					this.$refs.wrapper.style.height =this.$refs.wrapper.parentNode.clientHeight + 'px';
					// console.log(this.$refs.wrapper.parentNode.clientHeight)
					// console.log(this.$refs.content.clientHeight)
					
					
					if(this.pullingDown){
						
						this.pullingDown=false;
						this.scroll.finishPullDown();
						this.pulldownTip.text='下拉刷新';
						console.log('33333333')
					}
					
					if(this.pullingUp&&oldVal.length==newVal.length){
						this.nomore=true;
						this.scroll.finishPullUp();
						this.pullupTip.text='没有更多了';
						return false;
					}
					if(this.pullingUp){
						this.pullingUp=false;
						this.scroll.finishPullUp();
					}
					setTimeout(()=>{
						this.refresh(); //刷新dom
					},200)
					
				}, this.refreshDelay);
			}
		}
	}
</script>
<style lang="scss" rel="stylesheet/scss">
	@import './list.scss'
</style>