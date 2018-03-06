// console.log(process.env.NODE_ENV)
import store from '../store'

export default {
	baseUrl:'https://www.kzc275.top',
	isBrowser:process.env.NODE_ENV=='development'?true:false,
    maskCallBack:(fn)=>{
            //点击遮罩回调方法
            if(fn&& typeof fn=='function'){
                fn();
                store.state.isShutDown=null;
            }
    },
    setCookie:(name,value,expires,domain,path)=>{
            var str = "";
            if(name!=undefined &&value!=undefined){
                //str+=name+"="+value;
                str += name+"=" + encodeURIComponent( value );
                    //    document.cookie = str;
                if(expires){
                    //expires  需要保存的时间  7 表示保存7天
                     
                     var d = new Date();
                     d.setDate(d.getDate()+expires)
                    //拼接过期时间
                    str+=";expires=" +d.toGMTString();//一定要用toGMTString(),过期时间才准确
                }
                if(domain){
                    //拼接域名
                    str+=";domain=" +domain
                }
                if(path){

                    //拼接访问路径
                    str+=";path=" +path
                }
                document.cookie = str;
            }else{
                alert('参数有问题')
            }
        },
    getCookie:(name)=>{
        var str = document.cookie;
        var arr = str.split("; ");
        for(var i=0;i<arr.length;i++){
            var newArr = arr[i].split("=");
            if(newArr[0]==name){
                //return  newArr[1]
                
                return decodeURIComponent(newArr[1])
            }
        }
    },
    checkLogin:()=>{
        if(store.state.isLogin){
            return true;
        }else{
            return false;
        }
    },
    toast:(msg)=>{
        $('.ac_toast').text(msg)
        if($('.ac_toast').css('display')=='block')return;
         $('.ac_toast').css({
            display:'block'
        });
        var op=1;
        var timer=setInterval(()=>{
            op=op-0.01;
            $('.ac_toast').css('opacity',op);
            if(op<0.1){
                clearInterval(timer);
                $('.ac_toast').css('display','none');
            }
            
        },20)

    },
    post:(params)=>{
        let param={};
        if(app.isBrowser){
            //跨域请求
            param={
                xhrFields: {
                    withCredentials: true
                },
                crossDomain: true,
                
            }
        }
        param.type='POST';
        param.url=params.url;
        param.data=params.data;
        return new Promise((resolve,reject)=>{
            $.ajax(param)
            .done(function(data) {
              console.log(data)
              resolve(data);
            })
            .fail(function(error) {
              console.log("error");
              reject(error);
            })
            .always(function(complete) {
              console.log(complete);
              console.log("complete");
            });

        })
        
    }
}