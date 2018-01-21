export default {
	namespaced:true,
	state:{
		test:'mynote',
		list:[3,4,5],
		nomore:false,
		from:0,
		to:15
	},
	mutations:{
		changeList(state,params){
			state.list=params;
			// state.list.push(params)
		},
		pullup(state,params){
			let temp=state.list.concat(params)
			state.list=temp;
		}
	},
	actions:{
		// 请求列表页数据
		noteList({commit,state},params){
			state.from=0;
			state.to=15;
			$.post(app.baseUrl+'/php/reg.php', {
					type: 'checkNote',
					from:state.from,
					to:state.to
				}, function(d) {
					state.nomore=false;
					//下拉加载复位
					if(params){
						params.finishPullDown();
					}
					commit('changeList',d);
				})

		},
		// 上拉加载
		pullup({commit,state},params){
			state.from+=15;
			$.post(app.baseUrl+'/php/reg.php', {
					type: 'checkNote',
					from:state.from,
					to:state.to
				}, function(d) {
					if(d.length==0){
						state.nomore=true;
					}
					console.log(d)
					//复位
					if(params){
						params.finishPullUp()
					}
					commit('pullup',d);
				})
		}
	},
	getters:{
		dataList:state=>state.list
	}
	
}
