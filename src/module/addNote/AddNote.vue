<template>
<keep-alive>
	<div class="addNote">
		<global-header>
			<!-- <span slot="left">back</span> -->
			<span>添加</span>
			<!-- <span slot="right">home</span> -->
		</global-header>
		<div class="input">
			<input v-model="when" type="text" placeholder="when" />
			<input v-model="where" type="text" placeholder="where" />
			<input v-model="who" type="text" placeholder="who" />
			<textarea v-model="what" name="" rows="" cols="" placeholder="what happen"></textarea>
			<span class="save" @click="save()">添加</span>
		</div>
	</div>
</keep-alive>
</template>
<script>
	 

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

		},
		created() {

		},
		methods: {
			goTo() {
				console.log(this.$router)

			},
			save() {
					app.post({
						url:'/php/reg.php',
						data:{
							type: 'addNote',
							when:this.when,
							where:this.where,
							who:this.who,
							what:this.what
						}
					}).then((data)=>{
						console.log(data)
						app.toast('添加成功')
						if(data==true){
							this.$router.push({
							  name: 'myNote',
							  params: 'from add'
							})
						}
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