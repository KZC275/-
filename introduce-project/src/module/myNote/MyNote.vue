<template>
	<div class="myNote">
		<global-header>
			<span slot="left">back</span>
			<span>myNote</span>
			<span slot="right">home</span>
		</global-header>

		<list :data='dataList'>
			<ul>
				<li v-for="item in dataList" @click='goTo(item)' >{{item.id}}</li>
			</ul>
		</list>
	</div>
</template>
<script>
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import Pheader from '../../components/Pheader'
	import List from './list'
	import BScroll from 'better-scroll'

	export default {
		name: 'myNote',
		data() {
			return {
				arr: [1, 2]
			}
		},
		computed:mapGetters({
			'dataList':'myNote/dataList'
		}),
		beforeRouteUpdate() {
			// console.log('beforeRouteEnter')
		},
		components: {
			'global-header': Pheader,
			'list': List
		},
		created() {
			this.noteList()
			console.log(this.$store)
			
		},
		methods: {
			...mapActions({
				'noteList':'myNote/noteList'
			}),
			goTo(item) {
				console.log(this.$router)
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

		
			

		}
	}
</script>

<style lang='scss'>
	@import './myNote.scss'
</style>