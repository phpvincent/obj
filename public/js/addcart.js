// JavaScript Document
(function($){
    var LANG_PACKAGE = {
        "addcart_no_x" : "第$X件",

        "addcart_total" : "合計：",
        "addcart_disable_add_spec" : "商品已加購，不可再更改規格",
        "addcart_no_spec_stock" : "此規格已無庫存",
        "addcart_nosel_spec" : "還沒選擇",
        "addcart_total_with" : "共 ",
        "addcart_unit" : " 件",
        "addcart_has_gift" : "含贈 ",
        "addcart_gift_other" : "另贈 " ,
        "addcart_append_other" : "另得 ",
        "addcart_number" : "数量：",
        "addcart_total_number" : "总数量：",
        "addcart_gift" : "贈，",
        "addcart_gift_title" : "贈品",
        "addcart_only" : "，僅剩 ",
        "addcart_has_sel" : "已選",
		"addcart_full_reduce" : "立減",
		"addcart_full_reduce_img" : "https://d1lnephkr7mkjn.cloudfront.net/ueditor/20180308/990c6fb8e2b072307de6458ef36f5169.jpg"
    };

    var Constant = {
        SaleRule: {
            discount: 1,//1	商品打折
            fullAmountReduced: 2,//2	金额满多少减什么价
            fullNumberReduced: 3,//3	商品数满多少减几个
            buyXGetX: 4,//4	买几送几(同一商品
            afterNumberPrice: 5,//5	第几件后什么价
            buyXGetY: 6,//6	买几送几(不同商品)
            fullAmountGetX:7,//	金额满多少送几个产品（同一商品）
            fullAmountGetY:8,//	金额满多少送几个产品（不同商品）
            addAmountGetX:9,//	加多少钱送几个产品（同一个商品）
            addAmountGetY:10,//	加多少钱送几个产品（不同商品）
            bindingX:11,//	捆绑（同一商品）
            bindingY:12,//	捆绑（不同一商品）
        },

        DisCompRule: {
            percent: "percent",
            donate: "donate",
            money: "money"
        },

        ChangePriceSource: {
            specOffset: 1,
            discount: 2
        }
    }

    var productIndex = 0;
    var currency = 'NTD';

    var Map = function(){
        var map = new Array();
        this.map = map;

        this.put = function(k, v){
            for(var o=0; o<map.length;o++){
                if(map[o].key==k){
                    map[o].value = v;
                    return v;
                }
            }
            var obj = {"key": k, "value": v};
            map.push(obj);
        };

        this.get = function(k, defVal){
            for(var o=0; o<map.length;o++){
                if(map[o].key==k){
                    return map[o].value;
                }
            }
            if(defVal) return defVal();
            return null;
        };

        this.exist = function(k){
            for(var o=0; o<map.length;o++){
                if(map[o].key==k){
                    return true;
                }
            }
            return false;
        };

        this.sort = function(){
            return map.sort(function(a, b){
                if(a.value.sort&&b.value.sort){
                    return parseInt(a.value.sort) - parseInt(b.value.sort);
                }else if(a.value.id&&b.value.id){
                    return parseInt(a.value.id) - parseInt(b.value.id);
                }

                return 0;
            });
        }

        this.each = function(callback){
            map = this.sort();
            for(var o=0;o<map.length;o++){
                callback(o, map[o], map[o].key, map[o].value);
            }
        };
    };

    var showMessage = function(msg, delay, callback, isClose){
        var dialog = $("#addcart_message_dialog");
        delay = delay?delay: 3000;
        if(dialog.size()==0){
            dialog = $("<div id='addcart_message_dialog' class='giikin-hide'/>");
            $("body").append(dialog);
        }
        dialog.text(msg);
        dialog.addClass("giikin-on");
        setTimeout(function(){
            dialog.removeClass("giikin-on");
            if(callback) callback();
        }, 3000);
    };

    var _CartSpec = function(_addc, _pinfo, _group, _price, _rule, _number){
        var noOption = !_pinfo.options||_pinfo.options.length==0||(_pinfo.options.length==1&&_pinfo.skus.length<=1);
        var $this = this;

        this.container = $("<div class='addcart-specs'/>");
        this.title = $("<div class='addcart-specs-title'/>");
        this.image = $("<img class='addcart-specs-title-image'/>");
        this.tname = $("<span class='addcart-specs-title-name'/>");
        this.gift = $("<span class='addcart-specs-title-gift'></span>");
        this.number = $("<span class='addcart-specs-title-number'/>");
        this.descript = $("<span class='addcart-specs-descript'/>");
        this.status = $("<span class='addcart-specs-status'/>");
        this.arrow = $("<span class='addcart-specs-arrow'>-</span>");

        this.body = $("<div class='addcart-specs-body'/>");

        _price = parseFloat(_price?_price:"0");
        _number = _number?_number:1;
        var _onChangeItem = _addc.opts.onChangeItem;
        var _optionIndex = productIndex;
        var _ruleId = _rule?_rule.rule:0;
        var _gift = _price>0?0:1;
        var _optionFlag = _pinfo.id + "#" + _gift;

        this.container.attr("data-id", _pinfo.id);
        this.container.attr("data-number", _number);
        this.container.attr("data-price", _price);
        this.container.attr("data-rule", _ruleId);
        this.container.attr("data-gift", _gift);
        this.container.attr("data-option", _optionFlag);

        this.container.data("pinfo", _pinfo);

        this.container.append(this.title);

        this.transName = function(name){
            var p1 = name.indexOf('】');
            if(p1>name.length - 3) p1=-1;
            var p2 = name.indexOf('(');
            if(p1<0) p1 = name.indexOf(']');
            if(p1<0) p1 = name.indexOf(' ');
            p1 = p1<0 ? 0: p1 + 1;

            if(p2<0) p2 = name.indexOf('（', p1);
            if(p2<0) p2 = name.indexOf('[', p1);
            if(p2<0) p2 = name.indexOf('【', p1);
            p2 = p2<0 ? name.length - p1: p2 - p1;
            return name.substr(p1, p2);
        }

        if(noOption){
            var specs = _group.find(".addcart-specs[data-option='" + _optionFlag  +"']");
            if(specs.size()>0){
                specs.attr("data-number", parseInt(specs.attr("data-number")) + _number);
                specs.find(".addcart-specs-title-number").text("×" + specs.attr("data-number"));
                return;
            }else{
                var img = _pinfo.image;
                if(_pinfo.options.length==1&&_pinfo.skus.length==1){
                    img = _pinfo.skus[0].option[0].img||img;
                }

                if(_addc.opts.imagePath) img = _addc.opts.imagePath + img;

                this.image.attr("src", img);
                this.tname.text(this.transName(_pinfo.title||_pinfo.name));
                if(_group.hasClass("after-discount")||(_group.hasClass("appends")&&_pinfo.id==_addc.opts.data.id)){
                    this.tname.text(this.transName(_rule.name));
                }
                this.title.append(this.image);
                this.title.append(this.tname);

                this.number.text("×" + _number);
                this.title.append(this.number);

                if(_gift){
                    this.gift.text(_addc.lang("gift_title"));
                    this.title.append(this.gift);
                }
                this.container.addClass("image-list");
                if(_pinfo.options.length==1&&_pinfo.skus.length==1){
                    var op = _pinfo.options[0];
                    var ov = _pinfo.skus[0].option[0];
                    this.container.data("op", op);
                    this.container.data("ov", ov);
                }

                if(_group.hasClass("binding")&&_pinfo.id==_addc.opts.data.id){
                    this.container.hide();
                }
            }
        }else{
            _group.attr("has-option", true);
            if(_group.css('display')=='none') _group.show();
            this.title.append(this.tname);
            this.title.append(this.arrow);
            this.title.append(this.descript);
            this.title.append(this.status);
            this.container.append(this.body);
        }

        if(_group){
            var _close = _group.find(".addcart-specs-group-close");
            if(_close.size()>0&&_close.css("display")!='none'&&_group.find(".addcart-specs").size()==0){
                this.arrow.addClass("left-offset");
            }
            _group.append(this.container);
            _addc.body.find(".line1px").removeClass("line1px");
            _addc.body.find(".addcart-specs-group").last().addClass("line1px");

            if(_group.data("appendOther")){
                _group.insertBefore($(".addcart-float-buttons-block").first());
            }else{
                _addc.body.append(_group);
            }
        }else{
            _addc.body.append(this.container);
        }

        if(noOption) return;
		
		if(_pinfo.id==_addc.opts.data.id||_price>0) productIndex++;

        if(_group.hasClass("first")&&_optionIndex==0&&_price>0){
            this.tname.text(_addc.lang("no_x").replace("$X", 1));
            if(_addc.opts.skip==1) this.container.hide();
        }else{
            if(_pinfo.id!=_addc.opts.data.id&&_price==0){
                this.tname.text(_addc.lang("gift_title"));
            }else{
                var ord = _optionIndex + 1;
                this.tname.text(_addc.lang("no_x").replace("$X", ord));
            }
        }
		
        this.title.click(function(){
            if($(this).hasClass("unfold")){
                $(this).removeClass("unfold");
                $this.body.slideDown(200);
            }else{
                $(this).addClass("unfold");
                $this.body.slideUp(200);
            }
        });

        this.specItems = [];
        this.AddCart = _addc;

        this.container.attr("product-index",  _optionIndex);

        if(_ruleId>10&&_rule.nosuit=='1') this.container.hide();

        var ops = sort(_pinfo.options);
        var skus = _pinfo.skus;

        var selVal = "";
        var noDef = false;
        for(var s=0; s<ops.length; s++){//循环规格组
            var po = ops[s];
			if(po.stock==''||po.stock==0){
				continue;
			}
            var content = $("<dl class='addcart-specs-content'/>");
            var dt = $("<dt/>");
            dt.text(po.name);
            dt.attr("data-id", po.id);
            dt.attr("data-sort", po.sort);
            content.data("data-po", po);
            content.append(dt);
            var dd = $("<dd/>");

            content.append(dd);
            this.body.append(content);

            var oval = new Map();

            if(skus){
                for(var sk=0; sk<skus.length;sk++){ /**循环产品SKU列表，找出本组规格的所有规格值和其组合的其它规格值*/
                var sku = skus[sk];
                    var obj = {}; //规格值对象
                    var sortOption = sort(sku.option);
                    var ids = [];
                    for(var so=0; so<sortOption.length;so++){
                        var sop = sortOption[so];
                        if(sop.pid==po.id){
                            if(oval.exist(sop.name)){
                                obj = oval.get(sop.name);
                            }else{
                                obj.sku = sku;
                                obj = $.extend(obj, sop);
                                obj.other = [];
                                oval.put(sop.name, obj);
                            }
                            for(var p=0; p<sortOption.length;p++){
                                var pp = sortOption[p];
                                if(pp.pid!=po.id){
                                    obj.other.push(pp.name);
                                }
                            }
                        }
                        ids.push(sop.id);
                    }

                    sku.ids = ids;
                }
            }else{
                for(var i=0; i<po.values.length;i++){
                    var pov = po.values[i];
                    oval.put(pov.name, pov);
                }
            }

            this.specItems.push(oval);

            oval.each(function(index, obj, key, val){
                var span = $("<span/>");
                span.attr("data-id", val.id);

                if(val.img&&(_ruleId<=10||(_ruleId>10&&_group.find(".addcart-specs").size()==1)||_pinfo.id!=_addc.opts.data.id)){
                    var img = val.img;
                    if(_addc.opts.imagePath) img = _addc.opts.imagePath + img;
                    span.append("<img src='" + img + "'/>");
                    span.append("<font>" + val.name + "</font>");
                    span.addClass("addcart-spec-img");
                }else{
                    span.text(val.name);
                };

                dd.append(span);

                span.data("option", JSON.stringify(val));

                span.click(function(e) {
                    if($this.container.hasClass("status-added")){
                        showMessage(_addc.lang("disable_add_spec"));
                        return;
                    }

                    if($(this).hasClass("unava")){
                        showMessage(_addc.lang("no_spec_stock"));
                        return;
                    }

                    if($(this).hasClass("active")){
                        return;
                    }else{
                        $(this).addClass("active").siblings("span").removeClass("active");

                        var option = {};
                        if($(this).data("option")) option = JSON.parse($(this).data("option"));

                        var others = option.other;
                        var $span = $(this);
                        if(others){
                            $(this).parents("dl.addcart-specs-content").nextAll("dl").each(function(index, element) {
                                var isSelected = false;
                                $(this).find("span").each(function(index, element) {
                                    $(this).addClass("unava");

                                    var able = false;
                                    var spec = $(this).text();

                                    for(var o = 0; o<others.length;o++){
                                        if(spec==others[o]){
                                            able = true;
                                            break;
                                        }
                                    }

                                    if(able){
                                        $span.parents("dl.addcart-specs-content").prevAll("dl").each(function(index, element) {
                                            var option = {"other":[]};
                                            if($(this).find(".active").data("option")) option = JSON.parse($(this).find(".active").data("option"));
                                            var a2 = false;

                                            if(option.other){
                                                for(var o = 0; o<option.other.length;o++){
                                                    if(spec==option.other[o]){
                                                        a2 = true;
                                                        break;
                                                    }
                                                }
                                                able = able && a2;
                                            }

                                        });

                                        if(able) $(this).removeClass("unava");
                                    }
                                });
                                if($(this).find(".active").hasClass("unava")){
                                    $(this).find(".active").removeClass("active");
                                    $(this).find("span:not(.unava)").first().addClass("active");
                                };
                            });
                        }

                        changeDescript(_price);

                        if(_onChangeItem){
                            _onChangeItem(po, index, obj, key, val);
                        }
                    }
                });

                if(_ruleId>10&&_rule.nosuit=='1'){
                    if(index==(_group.find('.addcart-specs').size()-1)%oval.map.length){ 
                        span.click();
                    }
                }else{
                    if(val.defualt=="1"){
                        isDef = true;
                        if(!noDef) selVal += val.name + " ";
                        //span.click();
                        span.attr("data-def", true);
                    }
                }
            });
        }

        if(_ruleId<=10||_rule.nosuit!='1') {
            $this.container.find("dl.addcart-specs-content").each(function (item, index) {
                if ($(this).find("span[data-def='true']:not(.unava)").size() > 0) {
                    $(this).find("span[data-def='true']:not(.unava)").click();
                } else {
                    $(this).find("span:not(.unava)").first().click();
                }
            });
        }

        if(_rule&&(_rule.rule==Constant.SaleRule.addAmountGetX||_rule.rule==Constant.SaleRule.addAmountGetY)){
            var __body = $this.AddCart.body;
            __body.animate({
                //scrollTop: __body.scrollTop() + $this.container.offset().top
            });
        }

        function changeDescript(price){
            var ids = [];
            var nosel = "";
            var hasNosel = false;
            $this.container.find("dl.addcart-specs-content").each(function(){
                var span = $(this).find("span.active");
                if(span.size()==0){
                    nosel = _addc.lang("nosel_spec") + $(this).find("dt").text();
                    hasNosel = true;
                }else{
                    ids.push(span.attr("data-id"));
                    if(!hasNosel) nosel += span.text() + " ";
                }
            });

            if(!hasNosel){
                nosel = _addc.lang("has_sel") + nosel.trim();
                if(skus){
                    nosel += _addc.lang("only");

                    for(var sk=0; sk<skus.length;sk++){
                        var sortOption = sort(skus[sk].option);
                        var oids = [];
                        for(var so=0;so<sortOption.length;so++){
                            oids.push(sortOption[so].id);
                        }
                        if(ids.sort().toString()==oids.sort().toString()){
                            nosel += skus[sk].stock;
                            $this.container.attr("data-poid", skus[sk].poid);

                            if(price>0&&(_ruleId<9||_ruleId==5)){
                                var offset = skus[sk].price?parseInt(skus[sk].price):0;
                                if(Math.abs(offset)>0&&_rule&&_ruleId==5&&_price<_addc.opts.data.finalPrice){
                                    if(_rule.distype==Constant.DisCompRule.percent){
                                        offset = parseInt(offset*_rule.value/100);
                                    }else{
                                        offset = 0;
                                    }
                                }
                                $this.container.attr("data-offset", offset);
                                if(Math.abs(offset)>0){
                                    price = parseFloat(price) + offset;
                                }
                            }

                            break;
                        }
                    }
                    nosel += _addc.lang("unit");
                }
            }

            $this.container.attr("hasNosel", hasNosel);
            if($this.AddCart.opts.symbolBefore){
                nosel = $this.AddCart.opts.symbol + $.formatCurrency(parseFloat(price)) + "，" + nosel;
            }else{
                nosel = $.formatCurrency(parseFloat(price)) + $this.AddCart.opts.symbol + "，" + nosel;
            }

            if(parseInt(price)==0){
                nosel = _addc.lang("gift") + nosel;
            }else{
                $this.AddCart.header.changePrice();
            }
            $this.descript.text("（" + nosel + "）");
        }
    };

    var _AddCart = function(options, e){
        var $this = this;
        var defualts ={
            currency: "NTD",
            symbol: "NT$",
            symbolBefore: true,
            onlyAddcart: false,
            onlyBuynow: false,
            displayDialog: true,
            saleTip: true,
            cartCount: 0,
            skip:0,
            logiFee: 0,
            lang: LANG_PACKAGE,
            onChangeQuantity: function(o, n){
                //alert(o + '=>' + n);
            },
            onChangeItem: function(po, index, obj, key, val){
                //alert(key + '=>' + val);
            },
            onGiftChangeItem: function(po, index, obj, key, val){
                //alert(key + '=>' + val);
            },
            onAddCart: function(){
                //alert('加入购物车');

            },
            onBuynow: function(){

            },
            onClose: function(){
                //alert('已关闭');
            }
        };
        if(!e){
            e = $("<div id='_addcart'/>");
            $("body").append(e);
        }
        e.addClass("gk-addcart");
        this.container = e;
        this.opts = $.extend({}, defualts, options);
        if(options.data&&options.data.currency){
            currency = options.data.currency;
        }
        this.opts.data.finalPrice = parseFloat(this.opts.data.finalPrice);
        if(this.opts.data.skip) this.opts.skip = this.opts.data.skip;

        if(!this.opts.mask){
            this.opts.mask = $("<div class='addcart-mask giikin-hide'/>");
            $("body").append(this.opts.mask);
        }

        productIndex = 0;

        this.opts.lang = $.extend({}, LANG_PACKAGE, options.lang);

        this.lang = function(key){
            return this.opts.lang["addcart_" + key];
        }

        this.opts.hasOption = !(!options.data.options||options.data.options.length==0||(options.data.options.length==1&&options.data.skus.length<=1));
        this.init();

        $.loadStorage(this.opts.form);
    };

    _AddCart.prototype = {
        init: function(){
            var $this = this;
            var $events = [];//数量改变事件队列
            this.amount = parseFloat(this.opts.data.finalPrice);
            this.number = parseInt(this.opts.data.qty)||1;

            productIndex = this.number - 1;
            this.body = $("<div class='addcart-body'/>");

            this.header = {
                container: this.opts.header,
                price: $("<div class='addcart-header-price'/>"),
                ptotal: $("<span class='addcart-header-price-total'/>"),
                ntotal: $("<span class='addcart-header-number-total'/>"),

                init: function(){
                    this.container.addClass("addcart-header");

                    this.container.append(this.price);
                    this.price.append(this.ptotal);
                    this.price.append(this.ntotal);
                },
                changePrice: function(){
                    var money = 0;
                    var number = 0;
                    $(".addcart-specs").each(function(index, element) {
                        var price = $(this).attr("data-price")?parseFloat($(this).attr("data-price")):0;
                        var offset = $(this).attr("data-offset")?parseFloat($(this).attr("data-offset")):0;
                        var n =  $(this).attr("data-number")?parseInt($(this).attr("data-number")):1;
                        if(price==0) offset = 0;
                        money += n * (price + offset);
                        number += n;
                    });

                    $this.amount = money;

                    $this.footer.changeTotal(number, money);
                }
            }

            this.footer = {
                container: $("<div class='addcart-footer'/>"),
                price: $("<div class='addcart-footer-price'/>"),
                ptotal: $("<span class='addcart-footer-price-total'/>"),
                ntotal: $("<span class='addcart-footer-number-total'/>"),

                init: function(){
                    this.container.append(this.price);
                    this.price.append(this.ntotal);
                    this.price.append(this.ptotal);
                    $this.container.append(this.container);
                },
                changeTotal: function(number, amount, fullReduce){
                    amount += parseFloat($this.opts.logiFee);
                    if($this.opts.symbolBefore){
                        this.ptotal.html($this.lang("total") + "<font>" + $this.opts.symbol + $.formatCurrency(amount) + "</font>");
                    }else{
                        this.ptotal.html($this.lang("total") + "<font>" + $.formatCurrency(amount) + $this.opts.symbol + "</font>");
                    }
                    $("input[name='amount']").val(amount);
					
					if(!fullReduce&&$this.promotion.rules){
						for(var i=0;i<$this.promotion.rules.length;i++){
							var rule = $this.promotion.rules[i].config.rule;
							if(rule==Constant.SaleRule.fullAmountReduced){
								var reduce = $this.promotion.rules[i].change();
								if(reduce>0){
									this.changeTotal(number, amount - reduce, reduce);
								}
								return;
							}
						}
					}else if(fullReduce){
						this.ptotal.html($this.lang("full_reduce") + ":<font>-" + $this.opts.symbol
						                 + $.formatCurrency(fullReduce) + "</font><br/>" + this.ptotal.html());
					}
                }
            }

            this.quantity = {
                container: $('<div class="addcart-quantity"/>'),
                content: $('<div class="addcart-quantity-content"/>'),
                label:$('<label class="addcart-quantity-title">' + $this.lang("number") + '</label>'),
                increase: $('<span id="addcart-quantity-inc"> + </span>'),
                decrease: $('<span id="addcart-quantity-dec"> - </span>'),
                number: $('<input type="text" name="specNumber" id="addcart-quantity-val" value="'
                    + $this.number + '" readonly/>'),

                PrimaryNumber: 1,
                GiftNumber: 0,
                AppendNumber: 0,
                GiftOtherNumber: 0,
                AppendOtherNumber: 0,

                init: function(){
                    this.content.append(this.label);
                    this.content.append(this.decrease);
                    this.content.append(this.number);
                    this.content.append(this.increase);
                    this.content.append(this.total);
                    this.container.append(this.content);

                    $this.container.append(this.container);

                    this.increase.click(function(e){
                        var n = parseInt($this.quantity.number.val());
                        if($this.opts.limit&&$this.opts.limit>=n) return;

                        for(var i=0;i<$this.promotion.rules.length;i++){
                            var rule = $this.promotion.rules[i].config.rule;
                            if(rule==Constant.SaleRule.addAmountGetX||rule==Constant.SaleRule.afterNumberPrice){
                                $this.promotion.rules[i].increase();
                                return;
                            }

                            if(rule==Constant.SaleRule.addAmountGetY&&$this.promotion.rules[i].productNumber>0){
                                $this.promotion.rules[i].increase();
                                return;
                            }
                        }

                        var incp = false;
                        for(var i=0;i<$this.promotion.rules.length;i++){
                            var rule = $this.promotion.rules[i].config.rule;
                            if(rule==Constant.SaleRule.addAmountGetX) continue;
                            if(rule==Constant.SaleRule.addAmountGetY) continue;
							if(rule==Constant.SaleRule.fullAmountReduced) continue;
							
                            $this.promotion.rules[i].increase();
                            incp = true;
                        }

                        if($this.promotion.rules.length==0||!incp){
                            if(this.PrimaryNumber==0) this.PrimaryNumber = 1;
                            var group = $(".addcart-specs-group.primary");
                            $this.addSpecs($this.opts.data, group, $this.opts.data.finalPrice);
                            $this.quantity.changeNumber(1);
                        }
                    });

                    this.decrease.click(function(e){
                        var n = parseInt($this.quantity.number.val());
                        if(n<=1) return;

                        for(var i=0;i<$this.promotion.rules.length;i++){
                            var rule = $this.promotion.rules[i].config.rule;

                            if(rule==Constant.SaleRule.addAmountGetX||rule==Constant.SaleRule.afterNumberPrice){
                                $this.promotion.rules[i].decrease();
                                return;
                            }

                            if(rule==Constant.SaleRule.addAmountGetY&&$this.promotion.rules[i].productNumber>0){
                                $this.promotion.rules[i].decrease();
                                return;
                            }
                        }

                        var decp = false;
                        for(var i=0;i<$this.promotion.rules.length;i++){
                            var rule = $this.promotion.rules[i].config.rule;
                            if(rule==Constant.SaleRule.addAmountGetY&&$this.promotion.rules[i].productNumber==0) continue;
							if(rule==Constant.SaleRule.fullAmountReduced) continue;

                            $this.promotion.rules[i].decrease();
                            decp = true;
                        }

                        if($this.promotion.rules.length==0||!decp){
                            if($this.opts.hasOption){
                                $(".addcart-specs-group.primary").find(".addcart-specs").last().remove();
                            }else{
                                var group = $(".addcart-specs-group.primary");
                                var specs = group.find(".addcart-specs[data-option='" + $this.opts.data.id + "#0']");
                                var number = parseInt(specs.attr("data-number")) - 1;
                                specs.attr("data-number", number);
                                specs.find(".addcart-specs-title-number").text("×" + number);
                            }
                            $this.quantity.changeNumber(-1);
                            productIndex--;
                        }
                    });
                },
                changeNumber: function(changeNumber){
                    if(this.PrimaryNumber>0){
                        var n = parseInt(this.number.val());
                        this.number.val(n + changeNumber);
                    }
                    this.PrimaryNumber += changeNumber;
                    this.changeTotal();
                    return this.PrimaryNumber;
                },

                changeGiftNumber: function(changeNumber){
                    this.GiftNumber += changeNumber;
                    this.changeTotal();
                    return this.GiftNumber;
                },

                changeGiftOtherNumber: function(changeNumber){
                    this.GiftOtherNumber += changeNumber;
                    this.changeTotal();
                    return this.GiftOtherNumber;
                },

                changeAppendNumber: function(changeNumber){
                    this.AppendNumber += changeNumber;
                    var n = parseInt(this.number.val());
                    this.number.val(n + changeNumber);
                    this.changeTotal();
                    return this.AppendNumber;
                },

                changeAppendOtherNumber: function(changeNumber){
                    this.AppendOtherNumber += changeNumber;
                    this.changeTotal();
                    return this.AppendOtherNumber;
                },

                changeTotal: function(){
                    var str = "";

                    var gifts = this.GiftNumber + this.GiftOtherNumber + this.AppendOtherNumber;
                    if(gifts > 0){
                        str = "，" + $this.lang("has_gift") + "<font>" + gifts + "</font>";
                    }

                    /*if(this.GiftOtherNumber>0){
                        str += "，" + $this.lang("gift_other") + this.GiftOtherNumber;
                    }

                    if(this.AppendOtherNumber>0){
                        str += "，" + $this.lang("append_other") + this.AppendOtherNumber;
                    }*/

                    var n = this.PrimaryNumber + this.AppendNumber + this.GiftNumber
                        + this.GiftOtherNumber + this.AppendOtherNumber;
                    if(n==0) n = 1;

                    $this.footer.ntotal.html($this.lang("total_number") + "<font>" + n + "</font>" + str + $this.lang("unit"));
                    $this.header.changePrice();
                }
            }

            this.buttons = {
                container: $('<div class="addcart-group-buttons"/>'),
                position: 1,//1
                init: function(){
                    if(this.position==1){
                        this.container.insertBefore($this.body);
                    }else if(this.position==2){
                        this.container.insertBefore($this.quantity.container);
                    }else if(this.position==3){
                        this.container.insertAfter($this.quantity.container);
                        $this.quantity.container.addClass("splitter");
                        $this.body.find(".addcart-specs-group").last().addClass("line1px");
                    }
                }
            }

            this.addSpecs = function(pinfo, group, price, rule, number){
                var cs = new _CartSpec(this, pinfo, group, price, rule, number);
                return cs;
            }

            this.changeGroupName = function(){
                $(".addcart-specs-title-name").each(function(index, item){
                    $this.body.find(".addcart-specs-group.line1px").removeClass("line1px");
                    $this.body.find(".addcart-specs-group").last().addClass("line1px");
                    if($(this).parents(".addcart-specs-group").data("appendOther")) return;
                    if($(this).siblings(".addcart-specs-title-number").size()>0) return;
                    var n = index + 1;
                    $(this).text($this.lang("no_x").replace("$X", n));
                });
            }

            this.showTip = function(msg, callback){
                var tip = $("#saleTip");
                if(tip.size()==0){
                    tip = $("<div id='saleTip' class='giikin-hide'/>");
                    var content = $("<div class='tip-content'>" + msg + "</div>");
                    var cb = $("<span>×</span>");
                    content.append(cb);
                    tip.append(content);
                    $('body').append(tip);
                    cb.click(function(){
                        tip.removeClass("giikin-on");
                        return false;
                    });
                }
                tip.addClass("giikin-on");
                tip.unbind();
                tip.click(function(){
                    if(callback) callback();
                });
            }

            /*
                discount: 1,//1	商品打折
                fullAmountReduced: 2,//2	金额满多少减什么价
                fullNumberReduced: 3,//3	商品数满多少减几个
                buyXGetX: 4,//4	买几送几(同一商品
                afterNumberPrice: 5,//5	第几件后什么价
                buyXGetY: 6,//6	买几送几(不同商品)
                fullAmountGetX:7,//	金额满多少送几个产品（同一商品）
                fullAmountGetY:8,//	金额满多少送几个产品（不同商品）
                addAmountGetX:9,//	加多少钱送几个产品（同一个商品）
                addAmountGetY:10//	加多少钱送几个产品（不同商品）
            */
            this.promotion = function(){
                var index = 0;

                function getDiscount(rule, price, total){
                    switch(rule.distype){
                        case Constant.DisCompRule.percent: return compDiscount1();break;//比例折扣
                        case Constant.DisCompRule.donate: return compDiscount2();break;//单件固定价格
                        case Constant.DisCompRule.money: return compDiscount3();break;//单件固定价格
                    }

                    function compDiscount1(){
                        return parseInt(price*rule.value/100);
                    }

                    function compDiscount2(){
                        return rule.value;
                    }

                    function compDiscount3(){
                        return rule.value;
                    }
                }

                function createGroup(ruleObject, price, onClose){
                    var group = $("<div class='addcart-specs-group'/>");
                    var closeGroup = $("<span class='addcart-specs-group-close'>×</span>");
                    group.attr("rule", ruleObject.config.rule);
                    group.append(closeGroup);
                    closeGroup.click(function(){
                        if(!group.data("appendOther")){
                            productIndex -= group.find(".addcart-specs:not(.image-list)").size();
                        }

                        if($this.opts.onCloseGroup) $this.opts.onCloseGroup($(this), group);
                        --index;

                        if(onClose) onClose();

                        group.remove();
                        $this.header.changePrice();
                        $this.changeGroupName();
                    });

                    return group;
                }

                function changeNoopNumber(rule, group, f){
                    for(var i=0;i<rule.items.length;i++){
                        var r = rule.items[i];
                        var specs = group.find(".addcart-specs[data-='" + r.id + "#" + r.rule + "']");
                        var number = parseInt(specs.attr("data-number"));
                        number = number - rule.value;

                        if(number==0){
                            specs.remove();
                        }else{
                            specs.attr("data-number", number);
                            specs.find(".addcart-specs-title-number").text("×" + number);
                        }
                    }

                    var specs = group.find(".addcart-specs[data-option='" + $this.opts.data.id + "#0']");
                    var number = parseInt(specs.attr("data-number"));
                    specs.attr("data-number", number);
                    specs.find(".addcart-specs-title-number").text("×" + number);
                }

                //1 商品打折
                var DiscountRule = function(rule){
					var $self = this;
                    this.config = rule;
					
					this.decrease = function(){
						
					}
					
					this.increase = function(){
						
					}
                }

                //2	金额满多少减什么价 //3	商品数满多少减几个
                var FullReducedRule = function(rule){
					var $self = this;
                    this.config = rule;
					
					this.change = function(){
						var offset = $this.amount - rule.reach;
						if(!this.desc){
							this.desc = $("<div class='addcart-full-reduce'/>");
							this.desc.append($("<span class='yhq'><img src='" + $this.lang("full_reduce_img") + " ' style='width:60px'><span>再買"+Math.abs(offset)+"可立减<span class='red'>"+this.config.value+"</span></span>"));
							this.reduce = $("<span class='reduce-amount'/>");
							this.desc.append(this.reduce);
							// this.desc.insertBefore($this.footer.container);
                            this.desc.insertBefore($this.quantity.container);
						}
						if(offset>0){
							//隱藏
							this.desc.hide();
							offset = rule.value;
						}else{
							this.desc.show();
							this.reduce.html(rule.name.replace('$offset', Math.abs(offset)));
							offset = 0;
						}
						return offset;
					}
					
					this.decrease = function(){
						
					}
					
					this.increase = function(){
						
					}
                }

                //5	第几件后什么价
                var AfterDiscountRule = function(rule){
                    var $self = this;
                    this.config = rule;

                    var block = $("<div class='addcart-float-buttons-block'/>");
                    var add = $("<button type='button' class='addcart-float-buttons-block-button'/>");

                    block.append(add);
                    add.text(rule.name);
                    block.attr("data-id", rule.id);
                    $this.buttons.container.append(block);
                    $this.buttons.position = 2;
                    $this.buttons.container.show();
                    block.click(function(e){
                        $self.increase();
                    });

                    this.group = $(".addcart-specs-group.after-discount");

                    if(this.group.size()==0){
                        this.group = $("<div class='addcart-specs-group after-discount' />");
                    } 

                    this.increase = function(){
                        var price = $this.opts.data.finalPrice;
                        var n = $this.quantity.PrimaryNumber + 1;
                        if(n >= rule.reach&&n<=rule.max) price = getDiscount(rule, price, 0);
						
						var hasBuyGet = false;
						for(var i=0;i<$this.promotion.rules.length;i++){
							var r0 = $this.promotion.rules[i].config;
							if(r0.rule==Constant.SaleRule.buyXGetX||r0.rule==Constant.SaleRule.buyXGetY){
								hasBuyGet = true;
								$this.addSpecs($this.opts.data, this.group, price, rule, 1);
								$this.quantity.changeNumber(1);
							
								for(var i=0;i<r0.items.length;i++){
									var r = r0.items[i];
									if(r.id==$this.opts.data.id){
										for(var j=0;j<r0.value;j++){
											$this.addSpecs($this.opts.data, this.group, price, rule);
										}
										$this.quantity.changeNumber(r0.value);
									}else{
										for(var j=0;j<r0.value;j++){
											$this.addSpecs(r, this.group, 0, rule);
										}
										$this.quantity.changeGiftOtherNumber(r0.value);
									}
								}
							}
						}
						
						if(!hasBuyGet){
							if(n>rule.max){
								var group = $(".addcart-specs-group.primary.first");
            					$this.addSpecs($this.opts.data, group, price);
							}else{
								$this.addSpecs($this.opts.data, this.group, price, rule, 1);
							}
							$this.quantity.changeNumber(1);
						}
                    }

                    this.decrease = function(){
						var hasBuyGet = false;
						
						function decNum(g, id, gift){
							if($this.opts.hasOption){
								if(id==$this.opts.data.id) productIndex--;
								g.find(".addcart-specs").last().remove();
							}else{
								var specs = g.find(".addcart-specs[data-option='" + id + "#" + gift + "']");
								var number = parseInt(specs.attr("data-number")) - 1;
								if(number==0){
									specs.remove();
								}else{
									specs.attr("data-number", number);
									specs.find(".addcart-specs-title-number").text("×" + number);
								}
							}
						}
						
						for(var i=0;i<$this.promotion.rules.length;i++){
							var r0 = $this.promotion.rules[i].config;
							if(r0.rule==Constant.SaleRule.buyXGetX||r0.rule==Constant.SaleRule.buyXGetY){
								hasBuyGet = true;
								$this.quantity.changeNumber(-1);
								decNum(this.group, $this.opts.data.id, 0);
								for(var i=0;i<r0.items.length;i++){
									var r = r0.items[i];
									if(r.id==$this.opts.data.id){
										decNum(this.group, $this.opts.data.id, 0);
										$this.quantity.changeNumber(-1*r0.value);
									}else{
										for(var j=0;j<r0.value;j++){
											decNum(this.group, r.id, 1);
										}
										$this.quantity.changeGiftOtherNumber(-1*r0.value);
									}
								}
							}
						}
						
						if(!hasBuyGet){
							var n = $this.quantity.PrimaryNumber;
							if(n>rule.max){
								var group = $(".addcart-specs-group.primary.first");
								decNum(group, $this.opts.data.id, 0);
							}else{
								decNum(this.group, $this.opts.data.id, 0);
							}
	
							$this.quantity.changeNumber(-1);
						}
                    }
                }

                //7	金额满多少送几个产品（同一商品） 8	金额满多少送几个产品（不同商品）
                var FullGetRule  = function(rule){
					var $self = this;
                    this.config = rule;
					
					this.decrease = function(){
						
					}
					
					this.increase = function(){
						
					}
                }

                //4	买几送几(同一商品 6买几送几(不同商品)
                var BuyGetRule = function(rule){
                    var $self = this;
                    this.config = rule;
                    this.group = $(".addcart-specs-group.primary");
                    this.endFlag = false;
                    this.giftNumber = 0;
                    this.giftOtherNumber = 0;

                    this.increase = function(isInit){
						if($this.quantity.PrimaryNumber>=rule.max){
							return;	
						}
						
                        var group = this.group;

                        var n = $this.quantity.PrimaryNumber + 1;
                        if((n%rule.reach==0)){//是否加赠品
                            if(!isInit){
                                if(rule.reach==1&&$this.opts.hasOption){
                                    this.group = createGroup(this, $this.opts.data.finalPrice, function(){
                                        $this.quantity.changeNumber(-1);
                                        if($self.giftNumber>0) $this.quantity.changeGiftNumber(-1*$self.giftNumber);
                                        if($self.giftOtherNumber>0) $this.quantity.changeGiftOtherNumber(-1*$self.giftOtherNumber);
                                    });
                                    group = this.group;
                                }
                                $this.addSpecs($this.opts.data, group, $this.opts.data.finalPrice, rule);
                            }

                            var giftNumber = 0;
                            var giftOtherNumber = 0;

                            for(var i=0;i<rule.items.length;i++){
                                var r = rule.items[i];
                                if(r.id==$this.opts.data.id){
                                    for(var j=0;j<rule.value;j++){
                                        $this.addSpecs($this.opts.data, group, 0, rule);
                                    }
                                    giftNumber += rule.value;
                                    $this.quantity.changeGiftNumber(rule.value);
                                }else{
                                    for(var j=0;j<rule.value;j++){
                                        $this.addSpecs(r, group, 0, rule);
                                    }
                                    giftOtherNumber += rule.value;
                                    $this.quantity.changeGiftOtherNumber(rule.value);
                                }
                            }

                            this.giftNumber = giftNumber;
                            this.giftOtherNumber = giftOtherNumber;

                            this.endFlag = true;
                        }else if(!isInit){
                            if(this.endFlag&&$this.opts.hasOption){
                                this.group = createGroup(this, $this.opts.data.finalPrice, function(){
                                    $this.quantity.changeNumber(-1*parseInt(rule.reach));
                                    if($self.giftNumber>0) $this.quantity.changeGiftNumber(-1*$self.giftNumber);
                                    if($self.giftOtherNumber>0) $this.quantity.changeGiftOtherNumber(-1*$self.giftOtherNumber);
                                });
                            }
                            $this.addSpecs($this.opts.data, this.group, $this.opts.data.finalPrice, rule);
                        }

                        $this.quantity.changeNumber(1);

                        return 1;
                    }

                    this.decrease = function(){
                        var n = $this.quantity.PrimaryNumber - 1;
                        if(n%rule.reach==0){//是否减赠品
                            if($this.opts.hasOption){
                                var group = this.group.prev();
                                if(rule.reach==1){
                                    this.group.find(".addcart-specs-group-close").click();
                                }else{
                                    $this.quantity.changeNumber(-1);
                                    productIndex--;
                                    this.group.remove();
                                }
                                this.group = group;
                            }else{
                                if(rule.reach==1){
                                    for(var i=0;i<rule.items.length;i++){
                                        var r = rule.items[i];
                                        var specs = this.group.find(".addcart-specs[data-option='" + r.id + "#1']");
                                        if(specs.find(".addcart-specs-title-number").size()==0){
                                            specs.last().remove();
                                        }else{
                                            var number = parseInt(specs.attr("data-number"));
                                            number = number - rule.value;
                                            if(number==0){
                                                specs.remove();
                                            }else{
                                                specs.attr("data-number", number);
                                                specs.find(".addcart-specs-title-number").text("×" + number);
                                            }
                                        }

                                        if(r.id==$this.opts.data.id){
                                            $this.quantity.changeGiftNumber(-1*rule.value);
                                        }else{
                                            $this.quantity.changeGiftOtherNumber(-1*rule.value);
                                        }
                                    }
                                }

                                var specs = this.group.find(".addcart-specs[data-option='" + $this.opts.data.id + "#0']");
                                var number = parseInt(specs.attr("data-number"));
                                number = number - rule.reach;
                                specs.attr("data-number", number);
                                specs.find(".addcart-specs-title-number").text("×" + number);

                                $this.quantity.changeNumber(-1);
                            }
                        }else{
                            $this.quantity.changeGiftNumber(-1*this.giftNumber);
                            $this.quantity.changeGiftOtherNumber(-1*this.giftOtherNumber);

                            if($this.opts.hasOption){
								 productIndex = productIndex - this.giftNumber;
                                for(var i = 0;i <= this.giftNumber + this.giftOtherNumber; i++){
                                    this.group.find(".addcart-specs").last().remove();
                                    if(this.group.find(".addcart-specs").size()==0){
                                        var group = this.group.prev();
                                        this.group.remove();
                                        this.group = group;
                                        this.endFlag = false;
                                    }
                                }
                            }else{
                                for(var i=0;i<rule.items.length;i++){
                                    var r = rule.items[i];
                                    var specs = this.group.find(".addcart-specs[data-option='" + r.id + "#1']");
                                    if(specs.find(".addcart-specs-title-number").size()==0){
                                        specs.last().remove();
                                    }else{
                                        var number = parseInt(specs.attr("data-number"));
                                        number = number - rule.value;
                                        if(number==0){
                                            specs.remove();
                                        }else{
                                            specs.attr("data-number", number);
                                            specs.find(".addcart-specs-title-number").text("×" + number);
                                        }
                                    }
                                }

                                var specs = this.group.find(".addcart-specs[data-option='" + $this.opts.data.id + "#0']");
                                var number = parseInt(specs.attr("data-number"));
                                number = number - rule.value;
                                specs.attr("data-number", number);
                                specs.find(".addcart-specs-title-number").text("×" + number);
                            }
                            $this.quantity.changeNumber(-1);
                        }
                        return 1;
                    }

                    this.increase(true);
                }

                //9 加多少钱送几个产品（同一个商品） 10 加多少钱送几个产品（不同商品）
                var AddGetRule = function(rule){
                    var $self = this;

                    var block = $("<div class='addcart-float-buttons-block'/>");
                    var add = $("<button type='button' class='addcart-float-buttons-block-button'/>");
                    var text = $("<div class='addcart-float-buttons-block-text'/>");
                    var tag = $("<div class='addcart-float-buttons-block-count'/>");

                    block.append(add);
                    add.text(rule.name);
                    block.attr("data-id", rule.id);
                    $this.buttons.container.append(block);
                    $this.buttons.container.show();

                    this.config = rule;

                    /*if($this.quantity.PrimaryNumber==0){
                        $this.quantity.changeNumber(1);
                    }*/

                    tag.text(index);
                    block.click(function(e){
                        var _price = rule.reach;
                        var appendNumber =0, appendOtherNumber = 0;

                        tag.text(++index);

                        var group = $(".addcart-specs-group.appends");
                        if($this.opts.hasOption||group.size()==0||rule.rule==Constant.SaleRule.addAmountGetY){
                            group = createGroup($self, _price, function(){
                                tag.text(index);
                                if(appendNumber>0) $this.quantity.changeAppendNumber((-1)*rule.value);
                                if(appendOtherNumber>0) $this.quantity.changeAppendOtherNumber((-1)*rule.value);
                            });
                            if(!$this.opts.hasOption&&rule.rule==Constant.SaleRule.addAmountGetX) group.find(".addcart-specs-group-close").hide();
                            group.addClass("appends");
                        }else{
                            group.find(".addcart-specs-group-close").hide();
                        }

                        if($self.productNumber==0) group.data("appendOther", true);

                        var groupGiftCount = 0;
                        var mainGiftCount = 0;

                        var _cnt = 0, _giftCnt = 0;
                        for(var i=0; i<rule.items.length;i++){
                            if(rule.items[i].price&&parseInt(rule.items[i].price)==0) continue;
                            if(rule.items[i].id==$this.opts.data.id) _cnt += rule.value;
							if(rule.items[i].id!=$this.opts.data.id) _giftCnt += rule.value;
                        }
						
						if(_cnt>0){
                        	_price = _price/_cnt;
						}else{
							_price = _price/_giftCnt;
						}

                        for(var i=0; i<rule.items.length;i++){
                            if(rule.items[i].id==$this.opts.data.id){
                                for(var j=0;j<rule.value;j++){
                                    $this.addSpecs($this.opts.data, group, _price, rule);
                                }
                                $this.quantity.changeAppendNumber(rule.value);
                                appendNumber += rule.value;
                            }else{
                                if(rule.items[i].price&&parseInt(rule.items[i].price)==0) _price = 0;
                                for(var j=0;j<rule.value;j++){
                                    $this.addSpecs(rule.items[i], group, _cnt>0?0:_price, rule);
                                }
                                $this.quantity.changeAppendOtherNumber(rule.value);
                                appendOtherNumber += rule.value;
                            }
                        }
                    });

                    this.productNumber = 0;
                    for(var i=0; i<rule.items.length;i++){
                        if(rule.items[i].id==$this.opts.data.id){
                            this.productNumber = rule.value;
                        }
                    }

                    if(this.productNumber==0){
                        $this.buttons.position = 3;
                    }else{
                        $this.buttons.position = 2;
                    }

                    this.rule = rule;

                    this.increase = function(){
						if($this.quantity.PrimaryNumber>=rule.max){
							return;	
						}
                        block.click();
                        return this.productNumber;
                    }

                    this.decrease = function(){
                        if($this.opts.hasOption||rule.rule==Constant.SaleRule.addAmountGetY){
                            var cls = ".addcart-specs-group[rule='" + rule.rule + "']";
                            $(cls).last().find(".addcart-specs-group-close").click();
                        }else{
                            var group = $(".addcart-specs-group.appends");
                            var specs = group.find(".addcart-specs");//[data-option='" + $this.opts.data.id + "#" + rule.rule + "']");
                            var number = parseInt(specs.attr("data-number"));
                            number = number - rule.value;
                            if(number==0){
                                group.find(".addcart-specs-group-close").click();
                                return;
                            }
                            specs.attr("data-number", number);
                            specs.find(".addcart-specs-title-number").text("×" + number);
                            $this.quantity.changeAppendNumber((-1)*rule.value);
                        }

                        return this.productNumber;
                    }
                }

                //11 12 捆绑促销
                var Binding = function(rule){
                    var $self = this;
                    this.config = rule;
                    this.group = $(".addcart-specs-group.binding");
                    if(this.group.size()==0){
                        productIndex -= $(".addcart-specs-group.primary").find(".addcart-specs:not(.image-list)").size();
						if(productIndex<0) productIndex = 0;
                        --index;
                        $this.quantity.changeNumber(-1);
                        $(".addcart-specs-group.primary").remove();
                        this.group = $('<div class="addcart-specs-group binding"/>');
                        $this.body.append(this.group);
                    }
                    this.button = $('<button class="btn-binding" type="button"/>');
                    this.button.html(rule.name);
                    $this.buttons.container.append(this.button);
                    if(rule.nosuit=='') rule.nosuit = '0';

                    this.button.click(function(){
                        if($(this).hasClass("active")) return;
                        $(".btn-binding.active").removeClass("active");
                        $(this).addClass("active");
                        productIndex = 0;//$self.group.find(".addcart-specs").size();

                        $this.quantity.changeNumber(-1*$this.quantity.PrimaryNumber);
                        $this.quantity.changeGiftOtherNumber(-1*$this.quantity.GiftOtherNumber);
                        $self.group.empty();
                        var _price = rule.reach/parseInt(rule.value);
						
						for(var j=0;j<rule.value;j++){
							$this.addSpecs($this.opts.data, $self.group, _price, rule);
						}
						$this.quantity.changeNumber(parseInt(rule.value));

                        for(var i=0; i<rule.items.length;i++){
                            if(rule.items[i].id!=$this.opts.data.id){
                                var giftNum = rule.items[i].giftNum ? rule.items[i].giftNum : 1;
                                for(var j=0;j<giftNum;j++) {
                                    $this.quantity.changeGiftOtherNumber(1);
                                    $this.addSpecs(rule.items[i], $self.group, 0, rule);
                                }
                            }
                        }

                        if(rule.nosuit=='1'){
                            $self.group.append($("<span class='suit-desc'>" + rule.desc + "</span>"));
                        }
                    });

                    $this.quantity.container.hide();//隐藏数量控制按钮

                    if(productIndex==0){
                        $this.buttons.container.insertBefore($this.body);
                        this.button.click();
                    }

                    this.increase = function(){

                    }

                    this.decrease = function(){

                    }
                }

                var po = this.opts.data;
                if(!po.promotion) return;
                var prom = sort(po.promotion);
                if(prom.length>0) $this.quantity.PrimaryNumber = 0;
                this.promotion.rules = new Array();
                for(var r=0; r<prom.length;r++){
                    prom[r].value = parseInt(prom[r].value);
                    prom[r].rule = parseInt(prom[r].rule);
                    prom[r].reach = parseFloat(prom[r].reach);

                    switch(prom[r].rule){
                        case Constant.SaleRule.discount: //1	商品打折
                            this.promotion.discount = new DiscountRule(prom[r]);
                            this.promotion.rules.push(this.promotion.discount);
                            break;
                        case Constant.SaleRule.fullAmountReduced: //2	金额满多少减什么价
                            this.promotion.fullAmountReduced = new FullReducedRule(prom[r]);
                            this.promotion.rules.push(this.promotion.fullAmountReduced);
                            break;
                        case Constant.SaleRule.fullNumberReduced: //3	商品数满多少减几个
                            this.promotion.fullNumberReduced = new FullReducedRule(prom[r]);
                            this.promotion.rules.push(this.promotion.fullNumberReduced);
                            break;
                        case Constant.SaleRule.buyXGetX: //4	买几送几(同一商品
                            this.promotion.buyXGetX = new BuyGetRule(prom[r]);
                            this.promotion.rules.push(this.promotion.buyXGetX);
                            break;
                        case Constant.SaleRule.afterNumberPrice: //5	第几件后什么价
                            this.promotion.afterNumberPrice = new AfterDiscountRule(prom[r]);
                            this.promotion.rules.push(this.promotion.afterNumberPrice);
                            break;
                        case Constant.SaleRule.buyXGetY: //6	买几送几(不同商品)
                            this.promotion.buyXGetY = new BuyGetRule(prom[r]);
                            this.promotion.rules.push(this.promotion.buyXGetY);
                            break;
                        case Constant.SaleRule.fullAmountGetX: //7	金额满多少送几个产品（同一商品）
                            this.promotion.fullAmountGetX = new FullGetRule(prom[r]);
                            this.promotion.rules.push(this.promotion.fullAmountGetX);
                            break;
                        case Constant.SaleRule.fullAmountGetY: //8	金额满多少送几个产品（不同商品）
                            this.promotion.fullAmountGetY = new FullGetRule(prom[r]);
                            this.promotion.rules.push(this.promotion.fullAmountGetY);
                            break;
                        case Constant.SaleRule.addAmountGetX: //9 加多少钱送几个产品（同一个商品）
                            this.promotion.addAmountGetX = new AddGetRule(prom[r]);
                            this.promotion.rules.push(this.promotion.addAmountGetX);
                            break;
                        case Constant.SaleRule.addAmountGetY: //10 加多少钱送几个产品（不同商品）
                            this.promotion.addAmountGetY = new AddGetRule(prom[r]);
                            this.promotion.rules.push(this.promotion.addAmountGetY);
                            break;
                        case Constant.SaleRule.bindingX: //11 同产品捆绑

                            this.promotion.bindingX = new Binding(prom[r]);
                            this.promotion.rules.push(this.promotion.bindingX);
                            break;
                        case Constant.SaleRule.bindingY: //12 捆绑（不同商品）
                            this.promotion.bindingY = new Binding(prom[r]);
                            this.promotion.rules.push(this.promotion.bindingY);
                            break;
                    }
                }
            }

            this.show = function(isBuynow){
                if(this.opts.skip==1){
                    this.promotion.addGetRule();
                }

                if(this.opts.displayDialog){
                    this.opts.mask.addClass("giikin-on");
                }else{
                    if(isBuynow){
                        this.buynow();
                    }else{
                        this.addcart();
                    }
                    return;
                }

                if($this.opts.onShow){
                    if($this.opts.onShow(this.container)){
                        return;
                    }
                }
                this.container.show(500);
            }

            this.hide = function(){
                this.opts.mask.removeClass("giikin-on");
                if($this.opts.onHide){
                    if($this.opts.onHide(this.container)){
                        return;
                    }
                }
                this.container.hide(500);
            }

            this.destory = function(){
                $this.container.remove();
                $this.opts.mask.remove();
                $this.opts.mask = null;
            }

            /**
             var product = {pid:1,skip:1, amount:100, number:5,"rules":[1,2], items:[{
								"id": 1011,
								"price": 1200.00,
								"gift": 0,
								"number": 1,
								"append": 1,
								"poid": 1,
								"options":[{"id":1, "name":"颜色", "vid": 11, "vname":"黑色", "sort": 1},{"id":2, "name":"尺码", "vid":"12","vname":"42","sort":2}]
								}]};
             */
            this.guid = function() {
                function S4() {
                    return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
                }
                var ms = (new Date()).getTime();
                return (ms + S4() + S4() + S4());
            }

            this.getData = function(){
                var nosel = false;
                $(".addcart-specs-content dd").each(function(index, element) {
                    if($(this).find("span").size()>0&&$(this).find("span.active").size()==0){
                        showMessage($this.lang("nosel_spec") + $(this).prev("dt").text());
                        nosel = true;
                        return;
                    }
                });

                if(nosel) return false;

                $.storage($this.opts.form);

                var product = this.opts.data;
                var guid = this.opts.guid||this.guid();
                this.opts.guid = guid;

                var data = {"pid": product.id, "amount": this.amount, "guid": guid, "poid":0, "rules":[], "items":[]};
                data.number = this.quantity.PrimaryNumber + this.quantity.AppendNumber + this.quantity.GiftNumber;
                if(this.opts.skip==1){
                    data.skip = 1;//跳过主产品，只加购赠品
                }else{
                    this.opts.cartCount += parseInt(this.quantity.number.val());
                }

                if(this.opts.data.promotion){
                    var prom = sort(this.opts.data.promotion);
                    for(var r=0; r<prom.length;r++){
                        data.rules.push(prom[r].id);
                    }
                }
                this.container.find(".addcart-specs").each(function(index, item){
                    var p = {};
                    p.id = $(this).attr("data-id");
                    p.gift = 1;
                    if($(this).hasClass("status-added")){
                        return;
                    }
                    p.price = parseFloat($(this).attr("data-price"));
                    p.number =  parseInt($(this).attr("data-number")?$(this).attr("data-number"):"1");
                    p.rule =  $(this).attr("data-rule")?$(this).attr("data-rule"):"0";
                    if(p.price>0) p.gift = 0;

                    $this.opts.cartCount += p.number;

                    if($(this).parent(".addcart-specs-group").attr("appends")){
                        p.append = 1;
                    }

                    p.options = [];
                    var s = "";
                    if($(this).hasClass("image-list")){
                        var opt = {};

                        var op = $(this).data("op");
                        var ov = $(this).data("ov");
                        if(op){
                            opt.id = op.id;
                            opt.name = op.name;
                            opt.vid = ov.id;
                            opt.vname = ov.name;
                            opt.sort = 0;
                            s += opt.vid + "#";
                            p.options.push(opt);
                        }
                    }else{
                        $(this).find(".active").each(function(index, item){
                            var opt = {};
                            var dt = $(this).parent().prev("dt");
                            opt.id = dt.attr("data-id");
                            opt.name = dt.text();
                            opt.vid = $(this).attr("data-id");
                            opt.vname = $(this).text();
                            opt.sort = dt.attr("data-sort");

                            s += opt.vid + "#";
                            p.options.push(opt);
                        });
                    }


                    var pinfo = $(this).data("pinfo");
                    for(var j=0; j<pinfo.skus.length;j++){
                        var sku = pinfo.skus[j];
                        var flag = false;
                        for(var k=0; k<sku.option.length;k++){
                            var f2 = false;
                            var skuop = sku.option[k];
                            for(var i=0; i<p.options.length;i++){
                                if(skuop.id==p.options[i].vid){
                                    f2 = true;
                                    break;
                                }
                            }
                            if(!f2){
                                flag = false;
                                break;
                            }else{
                                flag = true;
                            }
                        }
                        if(flag){
                            p.poid = sku.poid;
                            break;
                        }
                    }

                    p.optvs = s;
                    data.items.push(p);
                });

                var items = [];
                for(var i=0;i<data.items.length;i++){
                    var isAdd = true;
                    for(var j=0;j<items.length;j++){
                        if(data.items[i].id==items[j].id&&data.items[i].optvs==items[j].optvs&&data.items[i].rule==items[j].rule){
                            items[j].number += data.items[i].number;
                            isAdd = false;
                        }
                    }
                    if(isAdd) items.push(data.items[i]);
                }

                data.items = items;

                var obj = $this.opts.form.find("input[name='data']");
                if(obj.size()==0){
                    obj = $("<input type='hidden' name='data'>")
                    $this.opts.form.append(obj);
                }
                obj.val(JSON.stringify(data));
                return JSON.stringify(data);
            }

            this.processData = function(){
                $(".addcart-specs[product-index='0']").find(".active").each(function(index, item){
                    var dt = $(this).parent().prev("dt");
                    var s = "options[" + dt.attr("data-id") + "]";
                    var opt = $this.opts.form.find("input[name='" + s + "']");
                    if(opt.size()==0){
                        opt = $("<input type='hidden' name='" + s + "'>");
                        $this.opts.form.append(opt);
                    }
                    opt.val($(this).attr("data-id"));
                    var qty = $this.quantity.number.val();
                    $this.opts.form.find("input[name='qty']").val(qty);
                });
                this.getData();
            }

            this.header.init();
            this.container.append(this.body);
            var group = $("<div class='addcart-specs-group primary first'/>");
            this.addSpecs(this.opts.data, group, this.opts.data.finalPrice);
            this.promotion();
            this.quantity.init();
            this.buttons.init();
            this.footer.init();
            if($this.quantity.PrimaryNumber==0) $this.quantity.PrimaryNumber = 1;
            this.quantity.changeTotal();
        }
    }

    function sort(arrayData){
        if(!arrayData) return [];
        return arrayData.sort(function(a, b){
            if(a.sort&&b.sort){
                return parseInt(a.sort) - parseInt(b.sort);
            }else if(a.id&&b.id){
                return parseInt(a.id) - parseInt(b.id);
            }
            return 0;
        });
    }

    $.fn.addcart = function(options){
        this.addc = new _AddCart(options, $(this));

        return this.each(function(){

        });
    };

    $.formatCurrency = function(money) {
        money = money.toString().replace(/\$|\,/g,'');
        if(isNaN(money)) money = "0";
        var sign = (money == (money = Math.abs(money)));
        money = Math.floor(money*10 + 0.50000000001);
        money = Math.floor(money / 10).toString();
        for (var i = 0; i < Math.floor((money.length-(1+i))/3); i++)
            money = money.substring(0,money.length - (4 * i + 3)) + ',' + money.substring(money.length-( 4 * i + 3));
        return (((sign)?'':'-') + money);
    };

    $.showLoading = function(hasShowMask){
        var loading = $("#loading");
        if(loading.size()==0){
            loading = $("<div id='loading'/>");
            loading.html('<img src="/skin/frontend/yisainuo/wap/img/loading.gif"><p>loading</p>');
            $('body').append(loading);
        }
        loading.show();
        if(hasShowMask){
            $(".addcart-mask").removeClass("giikin-on");
        }
    }

    $.closeLoading = function(hasShowMask){
        $("#loading").hide();
    }

    $.storage = function(form){
        var data = {};

        form.find("input").each(function(){
            if($(this).attr("type")!="hidden"&&$(this).val()){
                data[$(this).attr("name")] = $(this).val();
            }
        });

        form.find("select").each(function(){
            if($(this).val()){
                data[$(this).attr("name")] = $(this).val();
                data[$(this).attr("name") + "_text"] = $(this).find("option:selected").text();
            }
        });

        form.find("textarea").each(function(){
            if($(this).val()){
                data[$(this).attr("name")] = $(this).val();
            }
        });
        if(false&&document.getElementById("storage")){
            try{
                document.getElementById("storage").contentWindow.postMessage(JSON.stringify(data), 'http://feilm.top');
            }catch(e){
                Console(e);
            }
        }
    }

    $.loadStorage = function(form) {
        window.addEventListener("message", function (e) {
            if(true) return;
            var data = e.data.replace(";expires=0", "");
            data = JSON.parse(e.data);
            form.find("input").each(function () {
                if($(this).attr("name")!="firstname"){
                    if($(this).attr("type")!="hidden"&&data[$(this).attr("name")]){
                        $(this).val(data[$(this).attr("name")]);
                    }
                }
            });

            /*form.find("select").each(function () {
                var name = $(this).attr("name");
                if(!data[$(this).attr("name")]) return;
                var option = $(this).find("option:contains('" + data[name] + "')");
                if(option.size()==0){
                    $(this).append($("<option value='" + data[$(this).attr("name")] + "' selected>" + data[$(this).attr("name") + "_text"]) + "</option>");
                }else{
                    $(this).find("option:contains('" + data[name] + "')").prop("selected", true);
                }
            });*/

            form.find("textarea").each(function () {
                if(!data[$(this).attr("name")]) return;
                $(this).val(data[$(this).attr("name")]);
            });
        }, false);
    }

    window.Map = Map;
    window.AddCart = _AddCart;
    window.showMessage = showMessage;
})(window.jQuery||{})