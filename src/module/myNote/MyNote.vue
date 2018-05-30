<template>
	<div class="myNote">
		<global-header rightName='index'>
			<!-- <span slot="left"></span> -->
			<span>myNote</span>
			<span slot="right">home</span>
		</global-header>
		<div class="noteList">
			<list 
			:data='dataList'
			:pullDown="true"
			:pullUp="true"
			v-on:pullup="pullup"
			v-on:pulldown="pulldown"
			>
				<ul>
					<li v-for="item in dataList" @click='goTo(item)' >{{item.what}}</li>
				</ul>
				<div v-if="nodata">没有数据</div>
			</list>
		</div>
	</div>
</template>
<script>
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import Pheader from '../../components/Pheader'
	import List from '../diary/list.vue'
	import BScroll from 'better-scroll'

	export default {
		name: 'myNote',
		data() {
			return {
			}
		},
		computed:mapGetters({
			'dataList':'myNote/dataList',
			'nodata':'myNote/nodata',
		}),
		beforeRouteUpdate() {
			// console.log('beforeRouteEnter')
		},
		components: {
			'global-header': Pheader,
			'list': List
		},
		created() {
			this.pulldown()
			
		},
		methods: {
			...mapActions({
				'pulldown':'myNote/pulldown',
				'pullup':'myNote/pullup'
			}),
			goTo(item) {
				console.log(this.$router);
				this.$router.push({
					name: 'detail',
					params: item
				})
			}
		},
		watch: {

		},
		mounted() {
			console.log()

		
			

		},
		activated(){
			// console.log(this.$route.params.isBack)
			// if(this.$store.state.backfromdetail){
				this.$store.state.backfromdetail=false;
				console.log(33333333)
				this.pulldown()
			// }
		}
	}
</script>

<style lang='scss'>
	@import './myNote.scss'
</style>