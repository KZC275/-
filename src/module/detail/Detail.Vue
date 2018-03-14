<template>
	<div class="detail">
		<global-header>
			<!-- <span slot='left'>back</span> -->
			<span>detail</span>
		</global-header>
		<div class="msg">
			<div><span>when：</span><span @click='increment'>{{msg.when}}</span></div>
			<div><span>where：</span><span @click='increment'>{{msg.where}}</span></div>
			<div><span>who：</span><span @click='increment'>{{msg.who}}</span></div>
			<div><span>what：</span><span @click='increment'>{{msg.what}}</span></div>
			<div><span>id：</span><span @click='increment'>{{msg.id}}</span></div>
			<!-- <h2 @touchstart='add'>addadd</h2>
			<h1>{{$store.state.count}}</h1>
			<h1>{{evenOrOdd}}</h1> -->
		</div>
		
	</div>
</template>

<script>
	import Pheader from '../../components/Pheader'
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	export default {
		name: 'detail',
		data() {
			return {
				status: '',
				msg:null

			}
		},
		computed: mapGetters([
			'evenOrOdd'
		]),
		methods: {
			...mapActions([
				'increment_add',
				'decrement_add',

			]),
			...mapMutations([
				'increment',
				'decrement',

			]),
			'add' () {
				//  	console.log(this.$store.dispatch({type:'incrementIfOdd'}))
				this.increment_add();
			}
		},
		created() {
			this.msg=this.$route.params;
			console.log(this.$route.params)
		},
		components: {
			'global-header': Pheader
		},
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
	@import './detail.scss';
</style>