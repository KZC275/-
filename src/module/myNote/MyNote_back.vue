<template>
	<div class="myNote">
		<global-header>
			<span slot="left">back</span>
			<span>myNote</span>
			<span slot="right">home</span>
		</global-header>

		<div class="list" ref='wrapper'>

			<ul>
				<li v-for="item in arr" @click='goTo'>{{item}}</li>
			</ul>
		</div>
		<!--<list>
			<ul>
				<li v-for="item in arr" @click='goTo' >{{item}}</li>
			</ul>
		</list>-->
	</div>
</template>
<script>
	import Pheader from '../../components/Pheader'
	import List from './list'
	import BScroll from 'better-scroll'

	export default {
		name: 'myNote',
		data() {
			return {
				arr: [1, 2, 3, 33, 22, 11, 1, 2, 3, 33, 22, 11, 1, 2, 3, 33, 22, 11]
			}
		},
		beforeRouteUpdate() {
			// console.log('beforeRouteEnter')
		},
		components: {
			'global-header': Pheader,
			'list': List
		},
		created() {
			console.log(this)
		},
		methods: {
			goTo() {
				console.log(this.$router)
				this.$router.push({
					name: 'detail',
					params: 'dddddddd'
				})
			}
		},
		watch: {

		},
		mounted() {
			console.log(this.$refs.wrapper.style.height = window.screen.height - 50 + 'px')
			//			this.$refs.wrapper.style.height = 10 + 'px'
			const options = {
				scrollY: true,
				click: true,
				momentum: true,
				probeType: 3,

			};
//			options.pullDownRefresh = { 
//				threshold: 50, // 当下拉到超过顶部 50px 时，触发 pullingDown 事件 
//				 stop: 60 // 刷新数据的过程中，回弹停留在距离顶部还有 20px 的位置 
//			}
			options.pullUpLoad = {
				threshold: -40 // 在上拉到超过底部 20px 时，触发 pullingUp 事件
			}
			setTimeout(() => {
				this.scroll = new BScroll(this.$refs.wrapper, options);
				this.scroll.on('scroll', (pos) => {
					console.log(pos.x + '~' + pos.y)
				})
				this.scroll.on('pullingDown', () => {
					this.arr = [1, 2, 3, 4]
					this.scroll.finishPullDown()
					this.scroll.refresh()
					setTimeout(() => {
						console.log($('.list ul').height())
						this.$refs.wrapper.style.height = $('.list ul').height() - 5 + 'px'
					}, 22)

				})
//
				this.scroll.on('pullingUp', () => {

					console.log('pppppppp')
					this.arr.push('lwlw')
					this.scroll.finishPullUp()
					setTimeout(() => {
						this.scroll.refresh()
					}, 22)

				})

			}, 20)

		}
	}
</script>

<style lang='scss'>
	@import './myNote.scss'
</style>