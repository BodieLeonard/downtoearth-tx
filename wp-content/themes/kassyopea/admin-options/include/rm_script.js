jQuery(document).ready(function(){
		//delete_links = jQuery('.delete-button a');
		//text_button = delete_links.text();
		//jQuery('.delete-button a').after('<div class="button-secondary delete-item">Delete</div>');
		
		jQuery('.section_effect .rm_options').slideUp();
		
		jQuery('.section_effect .rm_title h3').click(function(){		
			if(jQuery(this).parent().next('.rm_options').css('display')=='none')
				{	jQuery(this).removeClass('inactive');
					jQuery(this).addClass('active');
					jQuery(this).children('img').removeClass('inactive');
					jQuery(this).children('img').addClass('active');
					
				}
			else
				{	jQuery(this).removeClass('active');
					jQuery(this).addClass('inactive');		
					jQuery(this).children('img').removeClass('active');			
					jQuery(this).children('img').addClass('inactive');
				}
				
			jQuery(this).parent().next('.rm_options').slideToggle('slow');	
		});
		
		jQuery('input[type="checkbox"].on_off').iphoneStyle({ checkedLabel: 'Yes', uncheckedLabel: 'No' });  
    });                   	

jQuery(document).ready(function($){
 	$('.rm_upload input[type="button"]').click(function() { 
		var upField = $(this).parent().find('input[type="text"]');
		var upId = $(this).parent().find('input.idattachment');
		
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');    
	
		window.send_to_editor = function(html) {
			//alert(html);
			
			imgurl = $('a', '<div>' + html + '</div>').attr('href');
			//idimg = $('img', html).attr('class').match(/wp-image-(\d+)/);
			upField.val(imgurl);
			//upId.val(idimg[1]);
			
			$image_preview = upField.parents('.sortItem').find('.ss-ImageSample');
			if( $image_preview.length > 0 ) $image_preview.attr('src',imgurl);
			
			tb_remove();
		}          
		
		return false;
	});
});                     

jQuery(document).ready(function($) {
	$('.rm_color').each(function() {
		var divPicker = $(this).find('.colorpicker');
		var inputPicker = $(this).find('input[type=text]');
		divPicker.farbtastic(inputPicker);
		divPicker.hide();
		
        $('.colorpicker-icon', this).click(function(){
           divPicker.slideToggle('fast'); 
        });
	});
  });       

jQuery(document).ready(function($) {
	$('.radioLink input').click(function() {
		value = $(this).val();
		$parent = $(this).parent().parent();
		
		$parent.find('.radioLink').removeClass('checked');
		$(this).parent().addClass('checked');
		
		$parent.find('.ss-Link').hide();
		$parent.find('.'+value).show();	
	});
}); 

jQuery(document).ready(function($) {
	$('#SlideShow').sortable({
		axis: 'y',
		items: 'li.slide-item',
		placeholder: 'ui-sortable-placeholder',
		forcePlaceholderSize: true,
		opacity: 0.5,
		update: function(event,ui) {
			$('.sortItem').each(function(e){
				$('input.item_order_value', this).val(e);
			})	
		}
	});
});


/*homepage*/      	

jQuery(document).ready(function($){
 	$('.add-widget').click(function() { 
		tb_show('', 'add_widget.php');    
	
		window.send_to_editor = function(html) {
			imgurl = $('img', html).attr('src');
			idimg = $('img', html).attr('class').match(/wp-image-(\d+)/);
			upField.val(imgurl);
			upId.val(idimg[1]);
			
			$image_preview = upField.parents('.sortItem').find('.ss-ImageSample');
			if( $image_preview.length > 0 ) $image_preview.attr('src',imgurl);
			
			tb_remove();
		}          
		
		return false;
	});
});                                   	

// contact
jQuery(document).ready(function($){
 	$('.rm_input a.show_tb').click(function() { 
		
		tb_show( '', $(this).attr('href') );    
	
// 		window.send_to_editor = function(datastring) {                      
// 			
// 			$.post( action, datastring, function(response){        
// 				window.location = response;
// 			});      
// 		}          
		
		return false;
	});
});          