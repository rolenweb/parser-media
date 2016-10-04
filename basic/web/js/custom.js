$(function() {
	var home = $('.wrap');

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

	tinymce.init(
    	{ 
        	selector:'div[name = "block-template-news"] [name = "text"]',
        	height : 300
    	}
    );

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
		console.log(old_content);
		tinyMCE.activeEditor.setContent(old_content+'<hr><p>'+text.text()+'</p>');
	});

	home.on('click', 'div.sort-list-smi label[for = "keyword"]',function( event ) {	
    	home.find('div.keywords-stats').toggle();
	});
});