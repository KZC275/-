<template>
  <div class="detail">
    <global-header>
      <!-- <span slot='left'>back</span> -->
      <span>detail</span>
      <span class='del'
            @touchstart="del()"
            slot='right'>删除</span>

    </global-header>
    <div class="msg">
      <div>
        <span>when：</span>
        <span @click='increment'>{{msg.when}}</span>
      </div>
      <div>
        <span>where：</span>
        <span @click='increment'>{{msg.where}}</span>
      </div>
      <div>
        <span>who：</span>
        <span @click='increment'>{{msg.who}}</span>
      </div>
      <div>
        <span>what：</span>
        <span @click='increment'>{{msg.what}}</span>
      </div>
      <!-- <div><span>id：</span><span @click='increment'>{{msg.id}}</span></div> -->
      <!-- <h2 @touchstart='add'>addadd</h2>
			<h1>{{$store.state.count}}</h1>
			<h1>{{evenOrOdd}}</h1> -->
    </div>

  </div>
</template>

<script>
import Pheader from "../../components/Pheader";
import { mapGetters, mapActions, mapMutations } from "vuex";
export default {
  name: "detail",
  data() {
    return {
      status: "",
      msg: null,
      id: ''
    };
  },
  computed: mapGetters(["evenOrOdd"]),
  methods: {
    ...mapActions(["increment_add", "decrement_add"]),
    ...mapMutations(["increment", "decrement"]),
    add() {
      //  	console.log(this.$store.dispatch({type:'incrementIfOdd'}))
      this.increment_add();
    },
    del() {
      console.log(23122);
      const _this = this;
      this.$vux.confirm.show({
        title: '提示',
        content: '你要删除这条记录吗',
        // 组件除show外的属性
        onCancel() {
          console.log(this); // 非当前 vm
          console.log(_this); // 当前 vm
        },
        onConfirm() {
          _this.remoteinfo();
        }
      });
    },
    remoteinfo() {
      app
        .post({
          url: "/php/reg.php",
          data: { type: 'delNote', id: this.id }
        })
        .then(data => {
          console.log(data);
          if (data) {
            app.toast('删除成功');
            this.$store.state.backfromdetail = true;
            this.$router.go(-1);
          } else {
            app.toast('删除失败');
          }
        })
        .catch(error => {
          app.toast("请求失败");
        });
    }
  },
  created() {
    this.id = this.$route.params.id;
    this.msg = this.$route.params;
    console.log(this.$route.params);
  },
  components: {
    "global-header": Pheader
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
@import './detail.scss';
</style>