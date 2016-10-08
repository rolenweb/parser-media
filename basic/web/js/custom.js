$(function() {
	var home = $('.wrap');
	initTinymce();

	home.on('click', 'div.block-list-subject div[name = "sigle-subject"] h4[name = "title-silgle-subject"]',function( event ) {	
		var sigle_subject = $(this).parents('div[name = "sigle-subject"]');
		activeSingleSubject(sigle_subject);
		titleSubjectReplace(sigle_subject);
		titleSubjectTemplate(sigle_subject)
		loadDetailsSubject(sigle_subject);
		numberSubjectReplace(sigle_subject);
		
		tinyMCE.activeEditor.setContent('<p></p>');
	});

	function activeSingleSubject(obj) {
		var list = home.find('div[name = "sigle-subject"]');
		for (var i = 0; i < list.length; i++) {
			if ($(list[i]).hasClass('active-subject')) {
				$(list[i]).removeClass('active-subject');
			}
			obj.addClass('active-subject');
		}
	}

	function titleSubjectReplace(obj) {
		home.find('th[name = "title-subject"]').text(obj.find('h4[name = "title-silgle-subject"]').text());
	}

	function titleSubjectTemplate(obj) {
		home.find('div[name = "block-template-news"] input[name = "title"]').val(obj.find('h4[name = "title-silgle-subject"]').text());
	}

	function numberSubjectReplace(obj) {
		home.find('div.pult-details-subject span.title span.number').text(obj.find('span.number').text());
	}



	function loadDetailsSubject(obj) {
		var block_reload = home.find('div[name = "block-details-subject"]');
		block_reload.append('<div class="text-center"><i class = "fa fa-spinner fa-pulse fa-4x"></i></div>');
		$.post(
            '/site/load-details-subject',
            {
            	subject: obj.attr('subject')
            }
        ).done(function( data ) {
            	block_reload.html(data);
            	setKeywordsInput();
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
	}

	function setKeywordsInput(){
		var list_li = home.find('div.keywords-stats li span.keywords-stats');
		var keys;
		for (var i = 0; i < list_li.length; i++) {
			if (i < 3) {
				if (i === 0) {
					keys = $(list_li[i]).text();	
				}else{
					keys = keys+', '+$(list_li[i]).text();
				}	
			}
		}
		home.find('div.pult-details-subject input[name = "keyword"]').val(keys);
	}

	function initTinymce() {
		if (home.find('div[name = "block-template-news"] [name = "text"]').length !== 0) {
			tinymce.init(
		    	{ 
		        	selector:'div[name = "block-template-news"] [name = "text"]',
		        	height : 300
		    	}
		    );		
		}
	}

	

    home.on('click', 'div[name = "sigle-subject"] button[name = "processed-subject"]',function( event ) {	
    	
		var button = $(this);
		var sigle_subject = $(this).parents('div[name = "sigle-subject"]');
		var block_result = sigle_subject.find('div[name = "block-display-results"]');
		$.post(
            '/site/processed-subject',
            {
            	subject: button.attr('subject')
            }
        ).done(function( data ) {
            	if (data === 'ok') {
            		sigle_subject.next('hr').remove();
            		sigle_subject.remove();
            	}else{
            		block_result.html(data)	
            	}
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
        event.preventDefault();

	});

	home.on('click', 'div[name = "block-details-subject"] button[name = "input-to-template"]',function( event ) {	
    	var button = $(this);
		var single_news = $(this).parents('ul[name = "single-news"]');
		var text = single_news.find('li.full-text-news');
		var block_template = home.find('div[name = "block-template-news"]');
		var old_content = tinyMCE.activeEditor.getContent();
		tinyMCE.activeEditor.setContent(old_content+'<hr><p>'+text.text()+'</p>');
	});

	home.on('click', 'div[name = "block-details-subject"] button[name = "btn-status-news"]',function( event ) {	
    	var button = $(this);
		var block_result = home.find('ul[name = "single-news"] li[name = "block-result"]');
		$.post(
            '/site/processed-news',
            {
            	news: button.attr('news')
            }
        ).done(function( data ) {
        		if (data === 'ok') {
        			button.text('Обработана');
        			button.removeClass('btn-danger').addClass('btn-default');
        		}else{
        			block_result.html(data)
        		}
            	
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
	});


	home.on('click', 'div.sort-list-smi label[for = "keyword"]',function( event ) {	
    	home.find('div.keywords-stats').toggle();
	});

	home.on('click', 'ul.head-pult li span',function( event ) {	
		deactiveHeadPult();
		var span = $(this);
		span.parents('li').addClass('active');
		reloadLeaftArea(span.attr('type'));
	});

	function deactiveHeadPult() {
		var list = home.find('ul.head-pult li').removeClass('active');

	}

	function reloadLeaftArea(type) {
		var block_reload = home.find('td[name = "td-left-area"]');
		block_reload.empty().append('<div class="text-center"><i class = "fa fa-spinner fa-pulse fa-4x"></i></div>');
		$.post(
            '/site/reload-left-area',
            {
            	type: type
            }
        ).done(function( data ) {
            	block_reload.html(data)	
            	
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
        
	}

	home.on('click', 'td[name = "td-left-area"] div.block-list-rss li.li-rss',function( event ) {	
		var li = $(this);
		loadDetailsRss(li);
	});

	function loadDetailsRss(obj) {
		var block_reload = home.find('div[name = "block-details-subject"]');
		block_reload.append('<div class="text-center"><i class = "fa fa-spinner fa-pulse fa-4x"></i></div>');
		$.post(
            '/site/load-details-rss',
            {
            	rss: obj.attr('rss')
            }
        ).done(function( data ) {
            	block_reload.html(data);
            	//setKeywordsInput();
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
	}

	home.on('click', 'td[name = "td-left-area"] div.block-list-mail li.li-mail',function( event ) {	
		var li = $(this);
		loadDetailsMail(li);
	});

	function loadDetailsMail(obj) {
		var block_reload = home.find('div[name = "block-details-subject"]');
		block_reload.append('<div class="text-center"><i class = "fa fa-spinner fa-pulse fa-4x"></i></div>');
		$.post(
            '/site/load-details-mail',
            {
            	mail: obj.attr('mail')
            }
        ).done(function( data ) {
            	block_reload.html(data);
            	//setKeywordsInput();
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
	}

	home.on('submit', 'div[name = "block-template-news"] form[name = "create-news"]',function( event ) {	
		var form = $(this);
		var block_result = form.find('div[name = "block-result"]');
		block_result.empty().append('<div class="text-center"><i class = "fa fa-spinner fa-pulse fa-4x"></i></div>');
		
        $.post(
	            '/site/create-news',
	            form.serializeArray()
	        ).done(function( data ) {
	          block_result.html(data);
	          }
	        ).fail( function(xhr, textStatus, errorThrown) {
	            alert(xhr.responseText);
	            }
	    );
      	event.preventDefault();
	});

});