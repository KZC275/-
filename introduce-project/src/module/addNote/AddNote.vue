<template>
<keep-alive>
	<div class="addNote">
		<global-header>
			<span slot="left">back</span>
			<span>添加</span>
			<span slot="right">home</span>
		</global-header>
		<div>
			<input v-model="when" type="text" placeholder="when" />
			<input v-model="where" type="text" placeholder="where" />
			<input v-model="who" type="text" placeholder="who" />
			<textarea v-model="what" name="" rows="" cols="" placeholder="what happen"></textarea>
			<span class="save" @click="save()">save</span>
		</div>
	</div>
</keep-alive>
</template>
<script>
	import Pheader from '../../components/Pheader'

	export default {
		name: 'addNote',
		data() {
			return {
				when:'when',
				where:'where',
				who:'who',
				what:'what happen',

			}
		},
		beforeRouteUpdate() {
			// console.log('beforeRouteEnter')
		},
		components: {
			'global-header': Pheader,

		},
		created() {

		},
		methods: {
			goTo() {
				console.log(this.$router)

			},
			save() {
				let self=this;
					$.post(app.baseUrl+'/php/reg.php', {
						type: 'addNote',
						when:self.when,
						where:self.where,
						who:self.who,
						what:self.what
					}, function(d) {
						console.log(d)
					})
				
				
			}
		},
		watch: {

		},
		mounted() {

		}
	}
</script>

<style lang='scss'>
	@import './addNote.scss'
</style>