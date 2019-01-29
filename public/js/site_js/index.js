jQuery(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = jQuery(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion(jQuery('#accordion'), false);
	var accordion = new Accordion(jQuery('#accordion1'), false);
    
    jQuery(document.body).on('click', function(event){
        var css = jQuery('.lkx_productInfo_huifu').css('display');       
        if(css=='block')
        {
            if( !jQuery(event.target).is('.sxbox,.filer,button,a,.link,.fa-chevron-down') ) {
                jQuery('.sxqd').click();
            }
        }      	
	});
    jQuery('.swiper-wrapper').attr('style','transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);');       
});