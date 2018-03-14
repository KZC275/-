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
 import Pheader from '../../components/Pheader'
 import { mapGetters, mapActions, mapMutations } from 'vuex'
 import List from './list'
export default {
  name: 'Diary',
  data () {
    return {
      msg: 'Welcome2',
      dataList:[
        // {src:'123456'}
      ],
      from:0,
      to:10,
      finishUp:false,
      finishDown:false,
      baseUrl:''

    }
    
  },
   components:{
      'global-header':Pheader,
      'list': List
  },
  computed: mapGetters([
    'evenOrOdd'
  ]),
  created(){
      this.baseUrl=app.baseUrl+'/';
     

    },
    mounted(){
      setTimeout(()=>{
          this.pulldown()

      },1000)

    },
    methods:{
      ...mapActions([
        'increment_add',
        'decrement_add',

      ]),
      ...mapMutations([
        'increment',
        'decrement',

      ]),
      'add' () {
        //    console.log(this.$store.dispatch({type:'incrementIfOdd'}))
        this.increment_add();
      },
      pulldown(){
        
        this.from=0;
          var self=this;
          $.post(app.baseUrl+'/php/reg.php', {
              type: 'checkImg',
              from:self.from,
              to:self.to
            }, function(d) {
              console.log(d)
                self.dataList=d;
                // self.finishDown=true;
            })
      },
      pullup(){
        console.log('upupupupup')
        this.from+=5;
        var self=this;
        $.post(app.baseUrl+'/php/reg.php', {
            type: 'checkImg',
            from:self.from,
            to:self.to
          }, function(d) {
              self.dataList=self.dataList.concat(d);
              // self.finishUp=true;
          })
      }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang='scss' scoped>
    @import './diary.scss';
</style>
