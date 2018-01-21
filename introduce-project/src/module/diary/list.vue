<!-- 使用方法 -->
<!--
/*
1.是否需要上拉加载更多
2.上拉加载是否完成
3.是否需要下拉刷新
4.下拉刷新是否完成
5.循环的数据
*/
-->

<template>
	<div ref="wrapper" class="root">
		
		<div>
			<div v-if='pullingDown'>{{pulldownTip.text}}</div>
			<div class="list">
				<slot ></slot>
			</div>
			<div v-if='pullingUp||nomore'>{{pullupTip.text}}</div>
		</div>
	</div>
</template>
<script>
	import BScroll from 'better-scroll'

	export default {
		props: {
			/**
			 * 1 滚动的时候会派发scroll事件，会截流。
			 * 2 滚动的时候实时派发scroll事件，不会截流。
			 * 3 除了实时派发scroll事件，在swipe的情况下仍然能实时派发scroll事件
			 */
			probeType: {
				type: Number,
				default: 3
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
				default: true
				
			},
			/**
			 * 是否派发顶部下拉的事件，用于下拉刷新
			 */
			pullDown: {
				type: Boolean,
				default: true
				
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
				default: 20
			},
			finishDown:Boolean
			
		
		},
		data() {
			return {
				pullingDown:false,
				pullingUp:false,
				pulldownTip: {
					text: '下拉刷新', // 松开立即刷新
				},
				nomore:false, //底部显示没有更多
				pullupTip:{
					nomore:false,//没有更多
					text:'加载中...',

				},
				isFirst:true,//是否首次加载
				

			};
		},
		mounted() {
			// 保证在DOM渲染完毕后初始化better-scroll
			setTimeout(() => {
				console.log('mounted')
				this.$refs.wrapper.style.height = window.screen.height - 50 + 'px';
				this._initScroll()
			}, 20)
		},
		methods: {
			_initScroll() {
				if(!this.$refs.wrapper) {
					return;
				}
				// better-scroll的初始化
				this.scroll = new BScroll(this.$refs.wrapper, {
					probeType: this.probeType,
					click: this.click,
					scrollX: this.scrollX,
					scrollY: true,
					pullDownRefresh: {
						threshold: 50,
						 stop: 60
					},
					pullUpLoad:{
						threshold: -40 // 在上拉到超过底部 20px 时，触发 pullingUp 事件
					}
				});

				this.scroll.on('pullingDown', () => {
					
					console.log('pullissngDown')
					setTimeout(()=>{
						this.$emit('pulldown')
					},100)
					
					this.pulldownTip = {
					text: '刷新中...', // 松开立即刷新
					rotate: '' // icon-rotate
					}
					this.nomore=false; //释放上拉加载
					this.pullupTip.text='刷新中...';
					
			

				})
				//上拉加载无需放开手指即可加载
				this.scroll.on('pullingUp', () => {
					console.log('pullingUp')
					if(this.nomore){
						this.scroll.finishPullUp();
						return false; //没有更多时锁定上拉加载
					}
					this.pullingUp=true;
					this.pullingDown=false;
					setTimeout(()=>{
						this.$emit('pullup')
					},100)
					

				})

				let flag=true;
				this.scroll.on('scroll', (pos) => {
					if(pos.y>0&&pos.y<50){
						this.pullingDown=true;
						this.pullingUp=false;
						this.pulldownTip = {
							text: '', // 松开立即刷新
							rotate: '' // icon-rotate
						}
						flag=true;
					}
					if(pos.y>=50&&flag){
						flag=false;
						console.log(888888888)
						this.pulldownTip = {
							text: '松开刷新...', // 松开立即刷新
							rotate: '' // icon-rotate
						}
					}
				})
				this.scroll.on('touchEnd', (pos) => {
					// 下拉动作
					if(pos.y > 50) {
						console.log('touchEnd')
						
						
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
					if(this.isFirst&&$('.list').height()<window.screen.height){
						this.isFirst=false;
						//防止第一页数据高度不足，无法下拉
						this.$refs.wrapper.style.height=$('.list').height()-10+'px'

					}
					if(this.pullingUp&&oldVal.length==newVal.length){
						this.nomore=true;
						this.scroll.finishPullUp();
						this.pullupTip.text='没有更多了';
						return false;
					}
					
					if(this.pullingDown){
						
						this.pullingDown=false;
						this.scroll.finishPullDown();
					}
					if(this.pullingUp){
						this.pullingUp=false
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
	$cube-size: 10px; // 项目中用了scss，没用的话，替换掉样式中的变量即可
	.root {
		margin-top: 50px;
		.loading-pos,
		.pulldown-tip {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 35px;
			color: black;
			text-align: center;
			z-index: 2000;
		}
		.loading-pos {
			background-color: rgba(7, 17, 27, 0.7);
		}
		.pulldown-tip {
			top: -50px;
			height: 50px;
			line-height: 50px;
			z-index: 1;
		}
		.pull-icon {
			position: absolute;
			top: 0;
			left: 30%;
			color: #a5a1a1;
			font-size: 1.5em;
			transition: all 0.15s ease-in-out;
		}
		.pull-icon.icon-rotate {
			transform: rotate(180deg);
		}
		.loading-container {
			position: absolute;
			height: $cube-size;
			width: $cube-size;
			left: 35%;
			top: 50%;
			transform: translate(-50%, -50%);
			perspective: 40px;
		}
		.loading-connecting {
			line-height: 35px;
		}
		.cube {
			height: $cube-size;
			width: $cube-size;
			transform-origin: 50% 50%;
			transform-style: preserve-3d;
			animation: rotate 3s infinite ease-in-out;
		}
		.side {
			position: absolute;
			height: $cube-size;
			width: $cube-size;
			border-radius: 50%;
		}
		.side1 {
			background: #4bc393;
			transform: translateZ($cube-size);
		}
		.side2 {
			background: #FF884D;
			transform: rotateY(90deg) translateZ($cube-size);
		}
		.side3 {
			background: #32526E;
			transform: rotateY(180deg) translateZ($cube-size);
		}
		.side4 {
			background: #c53fa3;
			transform: rotateY(-90deg) translateZ($cube-size);
		}
		.side5 {
			background: #FFCC5C;
			transform: rotateX(90deg) translateZ($cube-size);
		}
		.side6 {
			background: #FF6B57;
			transform: rotateX(-90deg) translateZ($cube-size);
		}
		@keyframes rotate {
			0% {
				transform: rotateX(0deg) rotateY(0deg);
			}
			50% {
				transform: rotateX(360deg) rotateY(0deg);
			}
			100% {
				transform: rotateX(360deg) rotateY(360deg);
			}
		}
	}
</style>