/*
网站统计代码
*/
(function(){
    var url = location.href;
    if(url.indexOf('.html') != '-1')
    {
        require(['jquery','persist','lodash'],function($,Persist,_){
            var pid = $('input[name=product]').val() || 0;
            if(pid)
            {                
                store = new Persist.Store('productView');
                var ids = store.get('product_id') || pid;                            
                ids += ','+pid;    
                var arr = _.uniq(ids.split(',')); 
                var str_id = arr.join(',');                                      
                store.set('product_id', str_id);
                store.save();
                $.post('/static/product/list',{history_id:str_id,current_id:pid},function(html){
                   console.log(html); 
                });
            }                    
        });        
    }
})();
(function(){
    var url = location.href;
    if(url.indexOf('.html') != '-1')
    {
        require(['jquery'],function($){
            var pid = $('input[name=product]').val() || 0;           
            if(pid)
            {     
                $.get('/static/js/tagview?id='+pid,function(html){
                    $('body').before(html);                    
                });
            } 
            else
            {
                _ids = [];
                setTimeout(function(){
                    var $span = $('span.price');
                    $.each($span,function(){
                        var id = $(this).attr('id') || '';
                        if(id !== '' && id.indexOf('product-price-') != '-1')
                        {
                            _ids.push(id.replace('product-price-',''));
                        }
                    });    
                    var str_id = _ids.join(',');
                    $.get('/static/js/taglist?id='+str_id,function(html){
                        $('body').before(html);                    
                    });
                },500);                
            }                   
        });        
    }
})();
