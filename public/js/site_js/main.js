jQuery(document).ready(function(){
	var lateral_menu_trigger = jQuery('#cd-menu-trigger'),
		content_wrapper = jQuery('.gw-container'),
		navigation = jQuery('header');

	//open-close lateral menu clicking on the menu icon
	lateral_menu_trigger.on('click', function(event){

		//修正导航点击偶尔不触发
        event.stopPropagation();
        
		jQuery(this).toggleClass('is-clicked');
		
		navigation.toggleClass('lateral-menu-is-open');
		content_wrapper.toggleClass('lateral-menu-is-open');
		jQuery('#cd-lateral-nav').toggleClass('lateral-menu-is-open');
		
		//check if transitions are not supported - i.e. in IE9
		//if($('html').hasClass('no-csstransitions')) {
			if(jQuery(this).hasClass('is-clicked')){
				jQuery('html').addClass('overflow-hidden');
			}else{
				jQuery('html').removeClass('overflow-hidden');
			}
			 //jQuery('html').toggleClass('overflow-hidden');
			 
			if(jQuery('html').hasClass('overflow-hidden')){
				
				jQuery('.footmenu').hide();
			}else{
				jQuery('.footmenu').show();
				
			}
		//}
	});

	//close lateral menu clicking outside the menu itself
	jQuery(document.body).on('click', function(event){
	    if(jQuery('#cd-lateral-nav').hasClass('lateral-menu-is-open'))
        {            
            if( !jQuery(event.target).is('.gw-i,.rightico,#cd-lateral-nav,#cd-menu-trigger,.cd-navigation,a') ) {
                jQuery('.cd-menu-icon').click();
            }
        }		
	});
	//open (or close) submenu items in the lateral menu. Close all the other open submenu items.
	
	jQuery('.item-has-children').children('.rightico').on('click', function(event){
		
            jQuery(this).toggleClass('submenu-open').next('.sub-menu').slideToggle(200).end().parent('.item-has-children').siblings('.item-has-children').children('a').removeClass('submenu-open').next('.sub-menu').slideUp(200);
       	
	});
	
});