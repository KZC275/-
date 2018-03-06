export default {
	namespaced:true,
	state:{
		test:'mynote',
		list:[{what:'dsdf'}],
		nomore:false,
		from:0,
		to:15,
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
		pulldown({commit,state},params){

			state.from=0;
			$.post('/php/reg.php', {
					type: 'checkNote',
					from:state.from,
					to:state.to,
					xhrFields: {
					    withCredentials: true
					},
					crossDomain: true,
				}, function(d) {
					console.log(JSON.stringify(d));
					state.nomore=false;
					//下拉加载复位
					if(params){
						// params.finishPullDown();
					}
					commit('changeList',d.data);
				})

		},
		// 上拉加载
		pullup({commit,state},params){
			state.from+=state.to;
			$.post('/php/reg.php', {
					type: 'checkNote',
					from:state.from,
					to:state.to,
					xhrFields: {
					    withCredentials: true
					},
					crossDomain: true,
				}, function(d) {
					if(d.length==0){
						state.nomore=true;
					}
					console.log(d)
					//复位
					if(params){
						// params.finishPullUp()
					}
					commit('pullup',d.data);
				})
		}
	},
	getters:{
		dataList:state=>state.list
	}
	
}
