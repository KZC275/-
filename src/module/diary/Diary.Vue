<template>
  <div class="diary">
  <global-header>
       <!-- <span slot='left'>back</span> -->
       <span >test</span>
  </global-header>
    <div class="box">
        
        <list 
              :data='dataList' class="sssddd"
              v-on:pullup="pullup"
              v-on:pulldown="pulldown"
              :pullDown="true"
              :pullUp="true"
              >
            <img v-for="item in dataList" :src="baseUrl+item.src" alt="image">
        </list>
    </div>

   
  </div>
</template>

<script>
import Pheader from "../../components/Pheader";
import { mapGetters, mapActions, mapMutations } from "vuex";
import List from "./list";
export default {
  name: "Diary",
  data() {
    return {
      msg: "Welcome2",
      dataList: [
        // {src:'123456'}
      ],
      from: 0,
      to: 10,
      finishUp: false,
      finishDown: false,
      baseUrl: ""
    };
  },
  components: {
    "global-header": Pheader,
    list: List
  },
  computed: mapGetters(["evenOrOdd"]),
  created() {
    this.baseUrl = app.baseUrl + "/";
  },
  mounted() {
    setTimeout(() => {
      this.pulldown();
    }, 1000);
  },
  methods: {
    ...mapActions(["increment_add", "decrement_add"]),
    ...mapMutations(["increment", "decrement"]),
    add() {
      //    console.log(this.$store.dispatch({type:'incrementIfOdd'}))
      this.increment_add();
    },
    pulldown() {
      this.from = 0;
      app
        .post({
          url: "/php/reg.php",
          data: {
            type: "checkImg",
            from: this.from,
            to: this.to
          }
        })
        .then(data => {
          if (data) {
            this.dataList = data;
          } else {
            app.toast("失败");
          }
        })
        .catch(error => {
          app.toast("请求失败");
        });
    },
    pullup() {
      console.log("upupupupup");
      this.from += 5;
      app
        .post({
          url: "/php/reg.php",
          data: {
            type: "checkImg",
            from: this.from,
            to: this.to
          }
        })
        .then(data => {
          this.dataList = this.dataList.concat(data);
        })
        .catch(error => {
          app.toast("请求失败");
        });
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
@import "./diary.scss";
</style>
