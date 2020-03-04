(function ($) { 	
	$(document).ready(function() { 
		$('.bianco-tab ul.bianco-tabs').addClass('active').find('> li:eq(0)').addClass('current');
		$('.bianco-tab ul.bianco-tabs li a').click(function (g) { 
			var tab = $(this).closest('.bianco-tab'),
			index = $(this).closest('li').index();
			tab.find('ul.bianco-tabs > li').removeClass('current');
			$(this).closest('li').addClass('current');
			tab.find('.bianco-tab_content').find('div.bianco-tabs_item').not('div.bianco-tabs_item:eq(' + index + ')').slideUp();
			tab.find('.bianco-tab_content').find('div.bianco-tabs_item:eq(' + index + ')').slideDown();
			g.preventDefault();
		} );
	});
})(jQuery);