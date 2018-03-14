export default {
  namespaced: true,
  state: {
    test: 'mynote',
    list: [],
    nomore: false,
    from: 0,
    to: 15,
  },
  mutations: {
    changeList(state, params) {
      state.list = params;
      // state.list.push(params)
    },
    pullup(state, params) {
      let temp = state.list.concat(params)
      state.list = temp;
    }
  },
  actions: {
    // 请求列表页数据
    pulldown({
      commit,
      state
    }, params) {

      state.from = 0;
      app
        .post({
          url: "/php/reg.php",
          data: {
            type: 'checkNote',
            from: state.from,
            to: state.to,
          }
        })
        .then(data => {
          console.log(data);
          if (data.returnCode == '000000') {
            state.nomore = false;
			commit('changeList', data.data);
			//console.log(www)//错误会被catch 捕获，程序继续向下执行

          } else {
            app.toast("失败");
          }
        })
        .catch(error => {
          app.toast("请求失败");
        });


     

    },
    // 上拉加载
    pullup({
      commit,
      state
    }, params) {
      state.from += state.to;
	  app
        .post({
          url: "/php/reg.php",
          data: {
            type: 'checkNote',
            from: state.from,
            to: state.to,
          }
        })
        .then(data => {
          console.log(data);
          if (data.returnCode == '000000') {
            if (data.length == 0) {
				state.nomore = true;
			  }
			  commit('pullup', data.data);

          } else {
            app.toast("失败");
          }
        })
        .catch(error => {
          app.toast("请求失败");
        });
	  


    }
  },
  getters: {
    dataList: state => state.list
  }

}
