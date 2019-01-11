var attr=null;
function addAttribu(cuxiao_num,a) {


    // var issubmit=true;
    // var formnum=1; //商品属性组数计数；
    // var cuxiao_num={!!$cuxiao_num!!};  //如果有默认数量；
 
   
    if( cuxiao_num !=null && typeof(cuxiao_num) !='undefinde' && cuxiao_num !=''){
        formnum=Number(cuxiao_num);  //如果有默认数量；
    }
        // var a={!!$goods_config_arr!!}
        console.log(a);
        attr=a
        addform=function(e){
            console.log('开始addform')
        var addhtml='';
        var color25="";
        var eNum=$("#goods_config_div form").length+1;
        var flag=false;
        $.each(a,function(i,val){
        // console.log(i,val);
            if(val){flag=true};     
            var colorBut='';
            var imgNum=0;
            var imgWidth='30%';
            $.each(val,function(k,value){
                if(value.config_val_img){
                    imgNum++
                }
            });
            if(imgNum>=10){imgWidth='18%';}  //判断有图片的属性数量超过10张每行img宽度18%，显示5张；
            // console.log("imgwidth",imgNum)
            $.each(val,function(j,item){
             if(item.config_val_img){     //如果是展示图片的话显示这一组HTML；
                if(j===0){
                    colorBut= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" ><label class="uncheck" style="margin-bottom: 4px;width: '+imgWidth+';text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }else{
                    colorBut+= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label class="uncheck" style="margin-bottom: 4px;width: '+imgWidth+';text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }        
              }else{
                if(j===0){
                    colorBut= '<label style="display:inline-block;margin-bottom: 4px"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" ><label for="'+e+item.goods_config_id+item.config_val_id+'" class="uncheck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }else{
                    colorBut+= '<label style="display:inline-block;margin-bottom: 4px"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="uncheck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }
              }
               
            })
            color25+='<div calss="radiobox"> <dl class="addcart-specs-content"><dt><span class="require">*</span>'+val[0].goods_config_msg+'</dt><dd>'+colorBut+'</dl></div>';
         })
         if($("#goods_config_div form").length==4){
           
            // 先把之前的from循环添加到ul可折叠DOM里面，再删除掉；
            $.each($("#goods_config_div form"),function(i,item){
               var itemNum= $(item).children(":first").children(":first").text();
               $(item).children(":first").children(":first").remove();
                addhtml= '<ul class="mui-table-view"> <li class="mui-table-view-cell mui-collapse mui-active"><a class="mui-navigate-right" href="javascript:void(0)"><strong>'+itemNum+'</strong></a> <div class="mui-collapse-content" style="color: black;">'+$(item).prop("outerHTML")+'</div></li></ul>'
                // console.log($(item).prop("outerHTML"))
                if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；
                $(item).remove(); 
            });
            //循环完的dom里 input默认回选中第一个input，所以让有ischeck的input，click一下；
            $("#goods_config_div .ischeck").parent().find("input").click();
            //循环完前四个from；再到第五个；
            addhtml= '<ul class="mui-table-view"> <li class="mui-table-view-cell mui-collapse mui-active"><a class="mui-navigate-right" href="javascript:void(0)"><strong>'+jianshu(eNum)+'</strong></a> <div class="mui-collapse-content" style="color: black;"><form id="'+e+'">'+ color25+'</form></div></li></ul>';
            if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；

            $("#goods_config_div img").css("display","none");    //属性第一组显示图片其他不显示
            // $("#goods_config_div img").parent().css({"width":"","margin-left":"25px","padding":"0 6px"});
            $("#goods_config_div ul:first img").css("display","inline-block");
            // $("#goods_config_div ul:first img").parent().css({"width":"30%","margin-left":"","padding":""});
            return;
         }else if($("#goods_config_div form").length>4){
            addhtml= '<ul class="mui-table-view"> <li class="mui-table-view-cell mui-collapse mui-active"><a class="mui-navigate-right" href="javascript:void(0)"><strong>'+jianshu(eNum)+'</strong></a> <div class="mui-collapse-content" style="color: black;"><form id="'+e+'">'+ color25+'</form></div></li></ul>';
            if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；
            $("#goods_config_div img").css("display","none");    //属性第一组显示图片其他不显示
            // $("#goods_config_div img").parent().css({"width":"","margin-left":"25px","padding":"0 6px"});
            $("#goods_config_div ul:first img").css("display","inline-block");
            // $("#goods_config_div ul:first img").parent().css({"width":"30%","margin-left":"","padding":""});
            return;
         } else{
            addhtml='<form id="'+e+'"><div  class="jianshu"><strong>'+jianshu(eNum)+'</strong></div>'+ color25+'</form>';   //每件商品的所有属性的HTML放入一个form；
         }
         

         if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；
         // addClickEven()    
                                               //每增加一組屬性節點，監聽一次ischeck；
          }
     addform("f1");                                          //默认一组商品的所有属性fromid为f1；
     //删除一组商品属性的form；
      removeform= function(){
         if($("#goods_config_div").children("").length > 1){
             if($("#goods_config_div").children().length == 5){
                // 先把之前的from循环添加到ul可折叠DOM里面，再删除掉；
              $.each($("#goods_config_div form"),function(i,item){
                  //先把第几件获取放进from里；
                  $(item).children(":first").prepend($(item).parent().prev().children())
                  $("#goods_config_div").append( $(item));             //插入一组商品的所有属性；
                  $(item).find("img").css("display","inline-block");    //显示隐藏的img;
                //   $(item).find("img").parent().css({"width":"30%","margin-left":"","padding":""});
               })
               $("#goods_config_div ul").remove();
               $("#goods_config_div").children(":last-child").remove();
               formnum--
             }else{
                $("#goods_config_div").children(":last-child").remove();
                formnum--
             }

         }else {return  }
     }
};

function countDiff (a,basePrice,moneycoin,realPrice){
     function returnFloat(value){
        var value=Math.round(parseFloat(value)*100)/100;
        var xsd=value.toString().split(".");
        if(xsd.length==1){
        value=value.toString()+".00";
        return value;
        }
        if(xsd.length>1){
        if(xsd[1].length<2){
        value=value.toString()+"0";
        }
        return value;
        }
       };
    var goodsConfigArr=[];
    $.each(a,function(i,item){
    $.each(item,function(j,val){
        goodsConfigArr.push(val)
    })
    });
    console.log("goodsConfigArr",goodsConfigArr)

    var fromArr=$("#goods_config_div").find("form").serializeArray();
        $.each(fromArr,function(){
         this.name=this.name.slice(5);
        })
    console.log('fromArr',fromArr)
    var countDiffPrice=0;
    $.each(goodsConfigArr,function(i,val){
        $.each(fromArr,function(j,item){
            if(item.name==val.config_type_id && item.value==val.config_val_id){
                countDiffPrice+=(val.config_diff_price-0)
            }
        })
    });
    console.log(countDiffPrice);
    console.log("baseprice",basePrice)
    console.log("总价",basePrice+countDiffPrice)
    console.log(moneycoin)
    console.log(realPrice)
    $('.addcart-footer-price-total').children('font:first').html(moneycoin+ returnFloat(basePrice+countDiffPrice));
    $('#realprice').html( returnFloat(basePrice+countDiffPrice) );
    var nunnn= $("#addcart-quantity-val").val()-0;
    console.log("realPrice",nunnn*realPrice)
    var realPricecount=nunnn*realPrice-basePrice+countDiffPrice;
    // 显示减免额
    realPricecount > 0? $('.addcart-footer-realPrice-total').children('font:first').html('-'+moneycoin+ returnFloat(realPricecount)) : $('.addcart-footer-realPrice-total').hide();
    //显示总原价
    $('.addcart-footer-realPriceNative-total').children('font:first').html(moneycoin+ returnFloat(nunnn*realPrice));
    //如果是印尼和越南模板；不要小数点；三位一个逗号；
    try {
        $('.addcart-footer-price-total').children('font:first').html(moneycoin+ toThousands(basePrice+countDiffPrice));
        $('#realprice').html( toThousands(basePrice+countDiffPrice));
            // 显示减免额
            realPricecount > 0? $('.addcart-footer-realPrice-total').children('font:first').html('-'+moneycoin+ toThousands(realPricecount)) : $('.addcart-footer-realPrice-total').hide();
            //显示总原价
            $('.addcart-footer-realPriceNative-total').children('font:first').html(moneycoin+ toThousands(nunnn*realPrice));
            
    } catch (error) {
        
    }
}
//仿淘宝属性选择和订单模块
var isTaoForm=false;
function mouduleTaoBao (){
    if(self == top){
        location.href="/"
    }  //如果goods_blade_style ==1那么订单页就必须在iframe中打开；否则跳回主页；主要是为了endSuccess页回退“/pay”；会让页面只显示订单页面；不好；
    $("header").hide();
    $(".pro_info").css({"position":"fixed","top":"0","z-index":"9"});
    $(".newfooter").css({"margin-bottom":"60px"});

    $("#save").hide();
    $(".paymentbox").hide();
    $(".btndiv").hide(); //原来的订单按钮隐藏掉；
     //iframe中boby的padding-top=.pro-info的height；
     $("body").css({"padding-top":$(".pro_info").height()-20});console.log("又计算一次top")
}
function closeBtnWatch(){
    $("#closeBtn",parent.document).on("click",function(){
        if(!isTaoForm){
            $("#ifrPayDiv",parent.document).animate({height:""});
            $("#taorbg",parent.document).css('display','none');  //弹框遮罩关闭
            $("#btnPay2",parent.document).parent().hide();  //弹框外；购买按钮隐藏；；
            $(".mui-content",parent.document).css("-webkit-overflow-scrolling", "auto") //外面mui-content滚动属性换为auto；才能让ios打开弹框不出现消失bug
            console.log(isTaoForm)
           
        }else{
            $("#ifrPayDiv",parent.document).css({'height': "80%"});
            $("#goods_config_div").show();
            $("#save").hide();
            $(".paymentbox").hide();
            $("#addcart .addcart-group-buttons").show();
            $("#addcart .addcart-quantity").show();
            $("#addcart").css("margin-top","5px");
            console.log(isTaoForm)
            isTaoForm=false;
            $("#btnPay2",parent.document).parent().show();  //订单按钮隐藏；换成购买按钮；
            $(".btndiv1",parent.document).hide();
        }

    })
    //选择属性菜单的购买按钮的监听；
    $("#btnPay2",parent.document).on("click",function(){
    //整理表单数据；
         var dataArr=$("form#f1").serializeArray();
         var dataObj={};
    
         var fromArr=$("#goods_config_div").find("form").serializeArray();
    
         $.each(dataArr,function(i,val){
             dataObj[val.name]=[];
         })
         // console.log(dataObj);
         $.each(fromArr,function(j,item){
             $.each(dataObj,function(k,tol){
               if(item.name==k){
                   tol.push(item.value)
               }
             })
        })
             console.log("btnPay2",dataObj,attr)
    //判断用户是否选择了商品属性；
         var aNumer=Object.keys(a).length;
         var cuntNumer=$("#addcart-quantity-val").val()-0;
         var attFlag=true;
         $.each(dataObj,function(i,value){
             if(value.length != cuntNumer){
                 attFlag=false;
             }
         });
         if(aNumer != Object.keys(dataObj).length || !attFlag){
            layerMsg()
             return false;
         };
        
        // var winHieht= $(window).height()*10/8; //父页面iframe =视口高度；
        // console.log("便全屏",winHieht)
        $("#ifrPayDiv",parent.document).css({'height':'100%'})
        $("#goods_config_div").hide();
        $("#addcart .addcart-group-buttons").hide();
        $("#addcart .addcart-quantity").hide();
        $("#addcart").css("margin-top","40px");
        $("#save").show()
        $(".paymentbox").show();
        isTaoForm=true;
        $("#btnPay2",parent.document).parent().hide();  //购买按钮隐藏；换成订单按钮；
        $(".btndiv1",parent.document).show();

    });
    $(".btndiv1",parent.document).on("click",payFun)//订单提交按钮点击；执行表单提交函数；
}

var countdown=59;
var datasObj =null;
function sendMess () {
    console.log('发送一次验证码',datasObj)
    $.ajax({
        type: "POST",    
        url: "/send_message",
        data:datasObj,
        success: function (data) {
            if(data.err == 1){
                layer.msg(messagesucce);
            }else{
                layer.msg(messageerr); //验证码发送失败
                $("#orderlog").hide()
            }
        }, 
        error: function(data) {
            layer.msg(messnetworkerr);
        }
     })
    var obj = $("#messend");
        obj.attr('disabled',true); 
    var set = setInterval(function() { 
        if (countdown == 0) { 
            // obj.attr('disabled',false); 
            obj.removeAttr("disabled");
            $('#messpan').text(""); 
            countdown = 59; 
            clearInterval(set)
            return;
        } else { 
            obj.attr('disabled',true);
            $('#messpan').text("(" + countdown + ")");
            countdown--; 
        }
        },1000)
}
//确认订单弹框收集确认信息
function payFunMessage(datasObj){
     datasObj = datasObj
     if(!$("#messend").attr("disabled") && datasObj){
        sendMess()
     }   // 60秒能发一次短信
    var itemHtml='';
    var itemHtml2='';
    var selectVal = '';
    $("#goods_config_div form").each(function(i,item){
        var itemNum = $('.jianshu strong',this).html()? $('.jianshu strong',this).html():$(this).parent().parent().find(".mui-navigate-right strong").html()
        var divitemHtml='';
        $('div',this).each(function(i,item){
            // console.log($('dt',this).text(),$('.ischeck',this).text());
            if($('dt',this).text()){
                divitemHtml+=$('dt',this).text().substring(1) +":"+$('.ischeck',this).text().trim()+"&nbsp;&nbsp";
            }     
        }) 
        itemHtml += '<p><strong>'+itemNum+'</strong></p>'+divitemHtml;
    })

    $('.mui-input-group div.mui-input-row:visible').each(function(i,item){
        var html1='';
  
        if($(this).children('input').length!==0 && $(this).children('#quhao').length==0){
            if($(this).children('input[name="address1"]').length!==0){
                html1 += '<p><span class="selectAddress1">'+$(this).children('label').text().replace('*','')+'</span>' + $(this).children('input').val()+'</p>';
            }else{
                html1 += '<p><span class="">'+$(this).children('label').text().replace('*','')+'</span>' + $(this).children('input').val()+'</p>';
            }
        } else if($(this).children('#quhao').length!==0){

            html1 += '<p><span class="">'+$(this).children('label').text().replace('*','')+'</span>'+$(this).children('#quhao').text()+'&nbsp;&nbsp' + $(this).children('input').val()+'</p>';
        } else if($(this).children('textarea').length!==0){

            html1 += '<p><span class="">'+$(this).children('label').text().replace('*','')+'</span>' + $(this).children('textarea').val()+'</p>';
        } else if ($(this).children('select').length!==0) {
            
            html1 += '<p><span class="">'+$(this).children('label').text().replace('*','')+'</span>' + $(this).children('select').find('option:selected').text()+'</p>';
        } else if($(this).children('#twzipcode').length!==0){
             
             $(this).find('select').each(function(i,item){
                selectVal+= $(this).find('option:selected').text() +'&nbsp;&nbsp'
             })
        }

        console.log(html1 + selectVal)
        itemHtml2 += html1
    })

    console.log(itemHtml,itemHtml2);
    $("#orderlogConten").html(itemHtml);
    $("#orderlogConten2").html(itemHtml2);
    $("#orderlogConten2 .selectAddress1").after(selectVal);
    
}

//阿拉伯语；向右方式确认订单弹框收集确认信息
function payFunMessageRight(datasObj){
    datasObj = datasObj
    if(!$("#messend").attr("disabled") && datasObj){
       sendMess()
    }   // 60秒能发一次短信
    var itemHtml='';
    var itemHtml2='';
    var selectVal = '';
    $("#goods_config_div form").each(function(i,item){
        var itemNum = $('.jianshu strong',this).html()? $('.jianshu strong',this).html():$(this).parent().parent().find(".mui-navigate-right strong").html()
        var divitemHtml='';
        $('div',this).each(function(i,item){
            // console.log($('dt',this).text(),$('.ischeck',this).text());
            if($('dt',this).text()){
                divitemHtml+="&nbsp;&nbsp"+ $('.ischeck',this).text().trim()+":"+$('dt',this).text().substring(1);
            }     
        }) 
        itemHtml += '<p><strong>'+itemNum+'</strong></p>'+divitemHtml;
    })

    $('.mui-input-group div.mui-input-row:visible').each(function(i,item){
        var html1='';
  
        if($(this).children('input').length!==0 && $(this).children('#quhao').length==0){
            if($(this).children('input[name="address1"]').length!==0){
                html1 += '<p>'+ $(this).children('input').val()+ '<span class="selectAddress1">'+$(this).children('label').text().replace('*','')+'</span></p>';
            }else{
                html1 += '<p>' + $(this).children('input').val()+'<span class="">'+$(this).children('label').text().replace('*','')+'</span></p>';
            }
        } else if($(this).children('#quhao').length!==0){

            html1 += '<p>'+$(this).children('#quhao').text() +'&nbsp;&nbsp'+ $(this).children('input').val()+'<span class="">'+$(this).children('label').text().replace('*','')+'</span>'+'</p>';
        } else if($(this).children('textarea').length!==0){

            html1 += '<p>' + $(this).children('textarea').val()+'<span class="">'+$(this).children('label').text().replace('*','')+'</span></p>';
        } else if ($(this).children('select').length!==0) {
            
            html1 += '<p>'+ $(this).children('select').find('option:selected').text()+'<span class="">'+$(this).children('label').text().replace('*','')+'</span></p>';
        } else if($(this).children('#twzipcode').length!==0){
             
             $(this).find('select').each(function(i,item){
                selectVal+= '&nbsp;&nbsp'+$(this).find('option:selected').text()
             })
             html1 += selectVal+"<br>"
        }

        console.log(html1 + selectVal)
        itemHtml2 += html1
    })

    console.log(itemHtml,itemHtml2);
    $("#orderlogConten").html(itemHtml);
    $("#orderlogConten2").html(itemHtml2);
    // $("#orderlogConten2 .selectAddress1").after(selectVal);
    
}