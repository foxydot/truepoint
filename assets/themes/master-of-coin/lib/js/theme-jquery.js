jQuery(document).ready(function($) {	
    $('body *:first-child').not('.no-break span').addClass('first-child');
    $('body *:last-child').not('.no-break span').addClass('last-child');
    $('body *:nth-child(even)').not('.no-break span').addClass('even');
    $('body *:nth-child(odd)').not('.no-break span').addClass('odd');
    $('body').css('opacity','1');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	
	$('.ftr-menu ul.menu>li').after(function(){
		if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!=='none'){
			return '<li class="separator">|</li>';
		}
	});
    
    $('ul').prev('p').css('margin-bottom','1rem');
    
    $('.tablepress tbody tr.first-child').addClass(function(){
       var text;
       $(this).find('td').each(function(){
           text = text + $(this).text();
       });
       if(text === 'undefined'){
           return 'hidden';
       }
    });
    
    $('.blog article.entry,.blog article.entry').each(function(){
        $(this).find('.thumb-wrapper, .entry-header').equalHeightColumns();
    }); 

    $(".site-header").sticky();
    $(window).scroll(function() {
            $("#sticky-wrapper").not(".is-sticky").removeAttr("style");
    });
});