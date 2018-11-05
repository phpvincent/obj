function addAttribu() {


    // var issubmit=true;
    // var formnum=1; //商品属性组数计数；
    // var cuxiao_num={!!$cuxiao_num!!};  //如果有默认数量；
    var  addClickEven= function (){
         $("#goods_config_div").on('click',"input.radio",function(){
            $(this).parent().parent().find('label[for]').attr('class','uncheck') ;
         $(this).next().attr("class",'ischeck');  
          })

           $("#goods_config_div").on('click',"a.mui-navigate-right",function(){
            if($(this).parent().hasClass("mui-active")){
                $(this).parent().removeClass("mui-active")
            }else{
                $(this).parent().addClass("mui-active") 
            }
           })
        }
         addClickEven(); 
   
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
            var colorBut=''
            $.each(val,function(j,item){
             if(item.config_val_img){     //如果是展示图片的话显示这一组HTML；
                if(j===0){
                    colorBut= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" checked="checked"><label class="ischeck" style="width: 30%;text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }else{
                    colorBut+= '<label><input type="radio" style="display: none;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label class="uncheck" style="width: 30%;text-align: center;display:inline-block" for="'+e+item.goods_config_id+item.config_val_id+'"><img src="'+item.config_val_img+'" alt="">'+ item.config_val_msg +'</label>&nbsp;</label>';
                }        
              }else{
                if(j===0){
                    colorBut= '<label style="display:inline-block"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'" checked="checked"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="ischeck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
                }else{
                    colorBut+= '<label style="display:inline-block"><input type="radio" style="visibility: hidden;" class="radio" name="goods'+item.goods_config_id +'" value="'+item.config_val_id+'" id="'+e+item.goods_config_id+item.config_val_id+'"><label for="'+e+item.goods_config_id+item.config_val_id+'" class="uncheck">&nbsp;&nbsp;'+ item.config_val_msg +'&nbsp;&nbsp;</label>&nbsp</label>';
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
            addhtml= '<ul class="mui-table-view"> <li class="mui-table-view-cell mui-collapse mui-active"><a class="mui-navigate-right" href="javascript:void(0)"><strong>第'+eNum+'件</strong></a> <div class="mui-collapse-content" style="color: black;"><form id="'+e+'">'+ color25+'</form></div></li></ul>';
            if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；

            $("#goods_config_div img").css("display","none");    //属性第一组显示图片其他不显示
            $("#goods_config_div img").parent().css({"width":"","margin-left":"25px","padding":"0 6px"});
            $("#goods_config_div ul:first img").css("display","inline-block");
            $("#goods_config_div ul:first img").parent().css({"width":"30%","margin-left":"","padding":""});
            return;
         }else if($("#goods_config_div form").length>4){
            addhtml= '<ul class="mui-table-view"> <li class="mui-table-view-cell mui-collapse mui-active"><a class="mui-navigate-right" href="javascript:void(0)"><strong>第'+eNum+'件</strong></a> <div class="mui-collapse-content" style="color: black;"><form id="'+e+'">'+ color25+'</form></div></li></ul>';
            if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；
            $("#goods_config_div img").css("display","none");    //属性第一组显示图片其他不显示
            $("#goods_config_div img").parent().css({"width":"","margin-left":"25px","padding":"0 6px"});
            $("#goods_config_div ul:first img").css("display","inline-block");
            $("#goods_config_div ul:first img").parent().css({"width":"30%","margin-left":"","padding":""});
            return;
         } else{
            addhtml='<form id="'+e+'"><div><strong>第'+eNum+'件</strong></div'+ color25+'</form>';   //每件商品的所有属性的HTML放入一个form；
         }
         

         if(flag){ $("#goods_config_div").append(addhtml); }            //插入一组商品的所有属性；
         // addClickEven()                                           //每增加一組屬性節點，監聽一次ischeck；
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
                  $(item).find("img").parent().css({"width":"30%","margin-left":"","padding":""});
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
}