/**
 * Minified by jsDelivr using Terser v3.14.1.
 * Original file: /npm/js-cookie@2.2.0/src/js.cookie.js
 * 
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
!function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}return function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{c=JSON.stringify(r),/^[\{\[]/.test(c)&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}(function(){})});
//# sourceMappingURL=/sm/203d9606ffea7a776ef56994ac4d4a1ab0a18611bf5f22fd2f82e9b682eea54f.map

// var appVersion = window.navigator.appVersion
var browser={
    versions:function(){
     var u = navigator.userAgent,
      app = navigator.appVersion;
     var obj = {
   
      trident: u.indexOf('Trident') > -1, //IE内核
   
      presto: u.indexOf('Presto') > -1, //opera内核
   
      webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
   
      gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
   
      ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
   
      android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android终端
   
      isWin: (navigator.platform == "Win32") || (navigator.platform == "Windows"),
      isMac: (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel"),
     };
    return {
        core: function(){
            if(obj.trident){
                return 'trident'
            }else if(obj.presto){
                return 'presto'
            }else if(obj.webKit){
                return 'webKit'
            }else if(obj.gecko){
                return 'gecko'
            }else{
                return '其他'
            }
        }(),
        iosOrAndroid:  function(){
            if(obj.ios){
                return 'ios'
            }else if(obj.android){
                return 'android'
            }else{
                return '其他'
            }
        }(),
        system:function(){
            if(obj.isWin){
                return 'Win'
            }else if(obj.isMac){
                return 'Mac'
            }else{
                return '其他'
            }
        }(),
           mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
           iPhone: u.indexOf('iPhone') > -1 , //是否为iPhone或者QQHD浏览器
           iPad: u.indexOf('iPad') > -1, //是否iPad
           webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
           language:(navigator.browserLanguage || navigator.language).toLowerCase()
    }
    }(),
   }



 var ip_msg = (function(){ return Cookies.get('ip_msg')? JSON.parse(Cookies.get('ip_msg')) : new Object })()
 var locHref = (function( href ){
        var hrefarr= href.split('?')
        if(hrefarr[1]){
            var str = ''
             hrefarr[1].split('&').forEach(function(val, i){
                if( val.indexOf('goods_id')===0 || val.indexOf('order_id')===0 || val.indexOf('type')===0 || val.indexOf('q')===0 ) {
                 str += val + '&'
                }
             })
            str = str.replace(/&$/gi, '')
            if(str===''){
                return hrefarr[0]
            }else{
                return hrefarr[0] + '?' + str
            }
       }else {
            return hrefarr[0]
        }
    
    
    })(location.href)
var wsArr = (function(){ 
    var data = Cookies.get('wsdata') ? JSON.parse(Cookies.get('wsdata')) : new Array 
    console.log('befor',data)

    var flag = false
    $.each(data, function(index, el ){
        if (el.route === locHref){
           flag = true
        }
    })
    if (!flag){
        data.push({ route: locHref, start_date: new Date().toLocaleString() })
       Cookies.set('wsdata', data,  { expires: 1, path: '/' })
    }
   
   console.log('after', JSON.parse(Cookies.get('wsdata')))
   return JSON.parse(Cookies.get('wsdata'))
})()


//var wsUri ="ws://192.168.10.166:2349/";
var wsUri ="ws://13.229.73.221:2349/";
 // var wsUri ="ws://192.168.10.10:2349/";
var  heartbeat=null;
    function testWebSocket() { 
        websocket = new WebSocket(wsUri); 
        websocket.onopen = function(evt) { 
            onOpen(evt) 
        }; 
        websocket.onclose = function(evt) { 
            onClose(evt) 
        }; 
        websocket.onmessage = function(evt) { 
            onMessage(evt) 
        }; 
        websocket.onerror = function(evt) { 
            onError(evt) 
        }; 

// ws心跳
clearInterval(heartbeat)
    heartbeat = setInterval(function(){
    doSend({heartbeat: 0})
  },60000)

    } 

    function onOpen(evt) { 
      var data = {route: locHref, ip_info:{ip_msg:ip_msg, deviceData: browser.versions, routes: wsArr }}
      doSend(data)
      console.log("第一次打开"); 
  }  

  function onClose(evt) { 
      console.log("关闭ws"); 
      clearInterval(heartbeat)
      //断线重连
      testWebSocket()
  }  

  function onMessage(evt) { 
      console.log('返回数据: '+ evt.data);
      var datas = JSON.parse(evt.data)
      if(datas.data.type==='1'){
          var data=[]
          data.push(datas.data.msg)
          $('#coupondiv').remove()
          $('#couponcontent .closeBtn').off()
          $('#contentop .alo').off()
          addSubt({data:data})
      }else if(datas.data.type==='0'){
        addwsMsg(datas.data.msg)
      }
      // websocket.close(); 
  }  

  function onError(evt) { 
      console.log('ERROR:'+ evt.data); 
  }  

  function doSend(message) { 
      console.log("send: " + JSON.stringify(message));  
      websocket.send(JSON.stringify(message)); 
  } 
  window.addEventListener("load", testWebSocket, false);


  //监听下单页面电话号码填写和邮箱填写
$(function(){
    // 捕捉下单页面用户填写电话或者email
    $('input[name="telephone"]').blur(function(){ send('telephone') })
    $('input[name="email"]').blur(function(){ send('email') })
    function send(type){
        var ipmsg = {}
        ipmsg.telephone =  ($('input[name="telephone"]').val() === '') ? (ip_msg.telephone?ip_msg.telephone:'') : $('input[name="telephone"]').val()
        ipmsg.email =  ($('input[name="email"]').val() === '') ? (ip_msg.email?ip_msg.email:'') : $('input[name="email"]').val()
        if(ipmsg.telephone || ipmsg.email) {
            doSend({ip_msg:ipmsg})
            Cookies.set('ip_msg', ipmsg,  { expires: 1, path: '/' })
        }
    }
    // 捕捉home页用户须知是否在视口停留
    if($('#detial-table').length>=1){
        var windowH = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight // 浏览器高度兼容写法
        function GetRect (element) {
            var rect = element.getBoundingClientRect() // 距离视窗的距离
            var top = document.documentElement.clientTop ? document.documentElement.clientTop : 0 // html元素对象的上边框的宽度
            return {
              top: rect.top - top,
              bottom: rect.bottom - top
            }
          }
          var scrollNum = 0
          var jiNum = 0
          var counJiNum = 0
          var scrollinterval=null
          function scrollFun () {
            var obj = GetRect(document.getElementById('detial-table'))
            console.log('obj',obj,'winh',windowH)
            if (obj.top < windowH-50 && obj.bottom > 50) { // 在视口
                scrollNum++
                if(scrollNum === 1){
                //   console.log('detial-table正在视口中')
                  scrollinterval = setInterval(function(){
                    jiNum++
                    if(jiNum >= 11){
                      console.log('在视口11秒了')
                      counJiNum +=jiNum 
                      clearInterval(scrollinterval)
                      var senddatas = {}
                      senddatas.tpye = 'detial'
                      senddatas.countTime = counJiNum
                      doSend({ip_event: senddatas})
                    }
                    // console.log('jiNum',jiNum)
                  },1000)
                }
                // console.log('scrollNum',scrollNum)
            }else{
                clearInterval(scrollinterval)
                scrollNum = 0
                jiNum = 0
            }

          }
          $(document).scroll(scrollFun)
        // document.addEventListener('touchmove',scrollFun)
        //   window.onscroll = function() {
        //     scrollFun()
        //   }
    }

})