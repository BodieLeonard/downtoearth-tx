jQuery(document).ready(function($){ 

	$('body').removeClass('no_js').addClass('yes_js');
    
    if ( $('#testimonial-slider ul li').length > 0 )    
        $('#testimonial-slider ul').cycle({
            fx: "scrollHorz",
            easing: "easeOutCubic",
            speed: 600,
            timeout: 5000,
            prev: '.arrow-left',
            next: '.arrow-right'
        });        
    
//     removeFilter = function (el) {
//     	if (!$.support.opacity && el.style.filter) {
//     		try { el.style.removeAttribute('filter'); }
//     		catch(smother) {} // handle old opera versions
//     	}
//     };            
    
    $('#nav li > ul.sub-menu li').each(function(){
        n = $('ul.sub-menu', this).length;
        
        if(n) $(this).addClass('sub');
    });
    
    $('#nav ul > li').hover(
        function()
        {
            $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu)', this).fadeIn(300);    
        },
    
        function()
        {
            $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu)', this).hide();    
        }
    );               
    
    $('#nav ul.sub-menu li').hover(
        function()
        {
            var options;
            
            winWidth = $(document).width();
            
            subMenuWidth = $(this).parent().outerWidth();
            space = $(this).offset().left + subMenuWidth * 2;
            
            if(space < winWidth) options = {left:subMenuWidth-12};
            else options = {left:subMenuWidth*-1};
            
            $('ul.sub-menu', this).hide().css(options).fadeIn(300);
        },
    
        function()
        {
            $('ul.sub-menu', this).hide();
        }
    ); 

	function yiw_lightbox()
	{   
	    $('a.thumb').hover(
	                            
	        function()
	        {
	            $('<a class="zoom">zoom</a>').appendTo(this).css({
					dispay:'block', 
					opacity:0, 
					height:$(this).children('img').height(), 
					width:$(this).children('img').width(),
					'top':$(this).css('padding-top'),
					'left':$(this).css('padding-left'),
					padding:0}).animate({opacity:0.4}, 500);
	        },
	        
	        function()
	        {           
	            $('.zoom').fadeOut(500, function(){$(this).remove()});
	        }
	    );
	    
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({
	        slideshow:5000, 
	        autoplay_slideshow:false,
	        show_title:false,
            deeplinking: false
	    });
	}
	
	yiw_lightbox();

    $('a.socials, a.socials-small').tipsy({fade:true, gravity:'s'});
    
    $('.toggle-content:not(.opened), .content-tab:not(.opened)').hide();
    $('.tab-index a').click(function(){           
        $(this).parent().next().slideToggle(300, 'easeOutExpo');
        $(this).toggleClass('opened');
        $(this).attr('title', ($(this).attr('title') == 'Close') ? 'Open' : 'Close');
        return false;
    });     
    
    function cufon_tabs() {
        if (typeof Cufon != "undefined") 
		  Cufon.replace( '#content ul.tabs h4', { hover:true } );
	}
    
    $('.tabs-container').tabs({
		create: function(event, ui) { cufon_tabs() },
		show:   function(event, ui) { cufon_tabs() }
	});                                       
    $('.tabs-container').tabs( "option", "fx", { opacity: 'toggle' } );
    
    // quick-contact     
    var height_nav = $('.quick-contact-box .nav-box').height() - $('.quick-contact-box .box-info').innerHeight() + $('.quick-contact-box .box-info').height();
    $('.quick-contact-box .box-info').css('min-height', height_nav );      
	
	$('.quick-contact-box .box-info div.panel').hide();
	$('.quick-contact-box .box-info div.panel:eq(0)').show();
		
	if( $('.quick-contact-box .active').length == 0 )
		$('.quick-contact-box .nav-box li:first-child').addClass('active');	
		
    $('.quick-contact-box .nav-box a').click(function(){
		var hash = $(this).attr('href').split("#");
        hash = '#' + hash[1];   
    	$('.quick-contact-box .active').removeClass('active');
		
		$('.quick-contact-box .box-info div.panel').hide();
		$(hash).fadeIn('slow');
		$(this).parent().addClass('active');	
		//alert(hash);
		
		return false;
	});
    
    // jquery effect items footer                     
    $('#footer ul.menu li:not(.no-jquery-effect li), .wpsc_categories li, .sidebar li:not(#quick-contact li, .sidebar .recent-posts li)').hover(
		function()
		{                                               
			$(this).children('a').animate({marginLeft: 5}, 300);
		},
		function()
		{
			$(this).children('a').animate({marginLeft: 0}, 300);
		}
	);
    
    // jquery effect items footer                     
    $('.widget_price_range a').hover(
		function()
		{                                               
			$(this).animate({marginLeft: 5}, 300);
		},
		function()
		{
			$(this).animate({marginLeft: 0}, 300);
		}
	);
	
	// cart
	$('#topbar li.fast-info').hover(
		function()
		{
			$(this).find('.access-info-box').slideDown(300);
		},
		
		function()
		{
			$(this).find('.access-info-box').hide();
		}
	);
	$('#topbar li.fast-info > a').click( function(){ return false; } );
	
	// checkout
	if( window.location.hash == '' )
		hash = '#order-step';
	else
		hash = window.location.hash;
		
	$('#shipping_cart .step:not('+hash+')').css({'position':'absolute', left:0, top:0}).css({'display':'none', opacity:0});
	$('#shipping_cart').css('height', $('#shipping_cart '+hash).height());
	
	$('#checkout-next-step').click(function(){
		var this_panel = $(this).parents('.step');
		var next_panel = $(this).parents('.step').next();
		
		this_panel.animate({opacity:0}, 300, function(){ $(this).hide() });
		next_panel.show().animate({opacity:1}, 300, function(){
			$('#shipping_cart').css('height', next_panel.height());
		});
		return false;	
	});
	
	$('#checkout-back-step').click(function(){
		var this_panel = $(this).parents('.step');
		var prev_panel = $(this).parents('.step').prev();
		
		this_panel.animate({opacity:0}, 300, function(){ $(this).hide() });
		prev_panel.show().animate({opacity:1}, 300, function(){
			$('#shipping_cart').css('height', prev_panel.height());
		});
		return false;	
	});                
	              
	// accordion slider
// 	$('ul.accordion-slider').hrzAccordion({
// 		//openOnLoad : 2,
// 		handlePosition : "left"
// 	});                       
    
    
	// contact                           
    var error = true;      
    
    function addLoading( e )
    {
		$(e).val( '{wait}'.replace('{wait}', objectL10n.wait) ).attr('disabled', true);
	}    
    
    function removeLoading( e )
    {
		$(e).val(value_submit).attr('disabled', false);
	}
	
	function addError(msg, e, effect)
	{
		error = true;           
		$(e).removeClass('icon success');
		$(e).addClass('icon error');
		$(e).parents('li').find('.msg-error').text(msg);	
		if( effect !== undefined && effect == true )
		{
			$(e).css({position:'relative'}).animate({left:-10}, 100).animate({left:10}, 100).animate({left:-5}, 100).animate({left:5}, 100).animate({left:0}, 100);
		}
	}                 
	
	function addSuccess(e)
	{                                     
		$(e).addClass('icon success');	
	}
	
	function removeError(e)
	{
		error = false;
		$(e).parents('li').find('.msg-error').text('');     
		$(e).removeClass('icon error');
		addSuccess(e);
	}           
    	
	$('.contact-form .required').blur(function(){             
		var name = $(this).attr('name').match( /(.*)\[(.*)\]/ );
		var id_form = $(this).parents('.contact-form').find('input[name="id_form"]').val(); 
		
		jQuery.globalEval( 'var msg = messages_form_'+id_form+'.'+name[2] );  
		
		if( $(this).val() == '' )
			addError( msg, this );       
		else               
			removeError(this);
	});                
	
	$('.contact-form .email-validate').blur(function(){             
		var expr = /^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$/;
		var name = $(this).attr('name').match( /(.*)\[(.*)\]/ );       
		var id_form = $(this).parents('.contact-form').find('input[name="id_form"]').val();
		
		jQuery.globalEval( 'var msg = messages_form_'+id_form+'.'+name[2] );
		
		if( ( $(this).val() != '' && !expr.test( $(this).val() ) ) || ( $(this).is('.required') && $(this).val() == '' ) )  
			addError( msg, this );            
		else 
			removeError(this);
	});    
    
	$('.contact-form').submit(function(){
		addLoading( '.contact-form input:submit' );  
	});            
	
	// autoclean labels
	$elements = $('#footer .quick-contact-widget input[type="text"], #footer .quick-contact-widget textarea, input.email-newsletter');
    
	$elements.each(function(){
        if( $(this).val() != '' )	
			$(this).prev().css('display', 'none');
    }); 
    $elements.focus(function(){
        if( $(this).val() == '' )	
			$(this).prev().css('display', 'none');
    }); 
    $elements.blur(function(){ 
        if( $(this).val() == '' )	
        	$(this).prev().css('display', 'block');
    });       
	
	// quick contact form                     
    var error = true;     
	var value_submit = $('#footer .quick-contact-widget .submit-button input[type="submit"]').val();  
	var message_container = $('#footer .quick-contact-widget .usermessagea');  
    
	$('#footer .quick-contact-widget form').submit(function(){
		if( !error )
		{                                                
			var datastring = 'type-send=ajax&';
			
			$('#footer .quick-contact-widget input, #footer .quick-contact-widget select, #footer .quick-contact-widget textarea').each(function(){
				datastring = datastring + $(this).attr('name') + "=" + $(this).val() + '&';
			});
			
			$('#footer .quick-contact-widget .usermessagea').html(''); 
			addLoading( '#footer .quick-contact-widget .submit-button input[type="submit"]' );
			
			$.post( $(this).attr('action'), datastring, function(response){
				removeLoading( '#footer .quick-contact-widget .submit-button input[type="submit"]' );	           
				$('#footer .quick-contact-widget ul').slideUp(500, function(){	
					message_container.css({opacity:0}).html(response).animate({opacity:1}, 500);
					$( '<a href="#"> Close</a>' ).appendTo( message_container.find('p') ).addClass('close_msg');
				});
			});
		}
		else    
			addError('<p class="error">One or more field aren\'t filled correctly!</p>', this);
		
		return false;
	});     
	
	$('.close_msg').live( 'click', function(){
		$(this).parent().remove();
		$('#footer .quick-contact-widget ul').slideDown(500);
		return false;
	});
					
	$('.twitter-container').tweetable({
		id: 'tweets',
		username: 'YIW', 
		time: true, 
		limit: 2, 
		replies: true
	});
	
	//$(".accordion-slider li:not(.accordion-closed)").addClass('accordion-closed');
	//$(".accordion-slider").msAccordion();
});    