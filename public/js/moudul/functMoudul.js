function addAttribu(cuxiao_num,a) {


    // var issubmit=true;
    // var formnum=1; //商品属性组数计数；
    // var cuxiao_num={!!$cuxiao_num!!};  //如果有默认数量；
 
   
    if( cuxiao_num !=null && typeof(cuxiao_num) !='undefinde' && cuxiao_num !=''){
        formnum=Number(cuxiao_num);  //如果有默认数量；
    }
        // var a={!!$goods_config_arr!!}
        console.log(a);
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
                    colorBut= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" checked="checked"><label class="ischeck" style="margin-bottom: 2px;width: '+imgWidth+';text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }else{
                    colorBut+= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label class="uncheck" style="margin-bottom: 2px;width: '+imgWidth+';text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }        
              }else{
                if(j===0){
                    colorBut= '<label style="display:inline-block;margin-bottom: 2px"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" checked="checked"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="ischeck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }else{
                    colorBut+= '<label style="display:inline-block;margin-bottom: 2px"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="uncheck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }
              }
               
            })
            color25+='<div calss="radiobox"> <dl class="addcart-specs-content"><dt>'+val[0].goods_config_msg+'</dt><dd>'+colorBut+'</dl></div>';
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

function countDiff (a,basePrice,moneycoin){
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
    $('.addcart-footer-price-total').children('font:first').html(moneycoin+ returnFloat(basePrice+countDiffPrice));
    $('#realprice').html( returnFloat(basePrice+countDiffPrice) );
    //如果是印尼模板；不要小数点；三位一个逗号；
    try {
        $('.addcart-footer-price-total').children('font:first').html(moneycoin+ toThousands(basePrice+countDiffPrice));
        $('#realprice').html( toThousands(basePrice+countDiffPrice));
    } catch (error) {
        
    }
}
//仿淘宝属性选择和订单模块
var isTaoForm=false;
function mouduleTaoBao (){
    $("#closeBtn").show(); //右上X号按钮显示；
    $("#btnPay").parent().show(); //购买按钮显示；
    $("header").hide();
    $(".pro_info").css({"position":"fixed","top":"0","z-index":"9"});
    $(".newfooter").css({"margin-bottom":"60px"});

    $("#save").hide();
    $(".paymentbox").hide();
    $(".btndiv").hide();
}
function closeBtnWatch(){
    $("#closeBtn").on("click",function(){
        if(!isTaoForm){
            $("#iframePay",parent.document).animate({height:""});
            $("#taorbg",parent.document).css('display','none');  //弹框遮罩关闭
            console.log(isTaoForm)
            // $("#iframePayDiv",parent.document).css('display','none');
        }else{
            $("#iframePay",parent.document).css({'height': $(window).height()*8/10});
            $("#goods_config_div").show();
            $("#save").hide();
            $(".paymentbox").hide();
            $("#addcart .addcart-group-buttons").show();
            $("#addcart .addcart-quantity").show();
            $("#addcart").css("margin-top","5px");
            console.log(isTaoForm)
            isTaoForm=false;
            $("#btnPay").parent().show();  //订单按钮隐藏；换成购买按钮；
            $(".btndiv").hide();
        }

    })
    //选择属性菜单的购买按钮的监听；
    $("#btnPay").on("click",function(){
        
        var winHieht= $(window).height()*10/8; //父页面iframe =视口高度；
        console.log("便全屏",winHieht)
        $("#iframePay",parent.document).css({'height':winHieht});
        $("#goods_config_div").hide();
        $("#addcart .addcart-group-buttons").hide();
        $("#addcart .addcart-quantity").hide();
        $("#addcart").css("margin-top","40px");
        $("#save").show()
        $(".paymentbox").show();
        isTaoForm=true;
        $("#btnPay").parent().hide();  //购买按钮隐藏；换成订单按钮；
        $(".btndiv").show();
        $(".btndiv").addClass("mui-bar");
        $("#pay").css({"width":"100%","margin":"0","height":"100%"});
    })
}