$(function() {
	var home = $('.wrap');

	home.on('click', 'div.block-list-subject div[name = "sigle-subject"]',function( event ) {	
		activeSingleSubject($(this));
		titleSubjectReplace($(this));
		loadDetailsSubject($(this));
		numberSubjectReplace($(this));
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
        	}
        ).fail( function(xhr, textStatus, errorThrown) {
            	alert(xhr.responseText);
        	}
        );
	}

	tinymce.init(
    	{ 
        	selector:'div[name = "block-template-news"] [name = "text"]',
        	height : 300
    	}
    );
});