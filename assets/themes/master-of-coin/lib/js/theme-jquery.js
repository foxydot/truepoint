jQuery(document).ready(function($) {	
    $('*:first-child').not('.no-break span').addClass('first-child');
    $('*:last-child').not('.no-break span').addClass('last-child');
    $('*:nth-child(even)').not('.no-break span').addClass('even');
    $('*:nth-child(odd)').not('.no-break span').addClass('odd');
	
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
});