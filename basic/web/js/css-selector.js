$(function() {
	var home = $('.wrap');
	
	home.on('click', 'div.css-selector-view button[name = "test-css-selector"]',function( event ) {	
		var button = $(this);
    	var block_result = home.find('div.css-selector-view p.block-result-test');
    	var input_url = home.find('div.css-selector-view input[name = "test-url"]');
    	block_result.empty().append('<div class="text-center"><i class = "fa fa-spinner fa-pulse fa-4x"></i></div>');
    	if (input_url.length === 0) {
    		$.post(
	            '/css-selector/test-css-selector',
	            {
	            	selector: button.attr('css-selector'),
	            }
	        ).done(function( data ) {
	            	block_result.html(data)	
	        	}
	        ).fail( function(xhr, textStatus, errorThrown) {
	            	alert(xhr.responseText);
	        	}
	        );
    	}else{
    		$.post(
	            '/css-selector/test-css-selector',
	            {
	            	selector: button.attr('css-selector'),
	            	testurl: input_url.val()
	            }
	        ).done(function( data ) {
	            	block_result.html(data)	
	        	}
	        ).fail( function(xhr, textStatus, errorThrown) {
	            	alert(xhr.responseText);
	        	}
	        );
    	}
    	
        
	});

	home.on('change', 'div.css-selector-form select#cssselector-type',function( event ) {	
		var input_attr = home.find('div.css-selector-form input#cssselector-attr');
		console.log(input_attr.length);
		input_attr.val('');
		if ($(this).val() === 'attribute') {
			input_attr.attr('type','text');
		}else{
			input_attr.attr('type','hidden');
		}
	});

	home.on('click', 'div.css-selector-form label.control-label span',function( event ) {	
		home.find('div.css-selector-form input#cssselector-name').val($(this).text());
	});
	
	
});