jQuery(window).load(function($){
    graytabs();
});
jQuery(document).ready(function($) {	
	$('ul li:first-child').addClass('first-child');
	$('ul li:last-child').addClass('last-child');
	$('ul li:nth-child(even)').addClass('even');
	$('ul li:nth-child(odd)').addClass('odd');
	$('table tr:first-child').addClass('first-child');
	$('table tr:last-child').addClass('last-child');
	$('table tr:nth-child(even)').addClass('even');
	$('table tr:nth-child(odd)').addClass('odd');
	$('tr td:first-child').addClass('first-child');
	$('tr td:last-child').addClass('last-child');
	$('tr td:nth-child(even)').addClass('even');
	$('tr td:nth-child(odd)').addClass('odd');
    $('div:first-child').addClass('first-child');
    $('div:last-child').addClass('last-child');
    $('div:nth-child(even)').addClass('even');
    $('div:nth-child(odd)').addClass('odd');
    $('section:first-child').addClass('first-child');
    $('section:last-child').addClass('last-child');
    $('section:nth-child(even)').addClass('even');
    $('section:nth-child(odd)').addClass('odd');


	$('#footer-widgets div.widget:first-child').addClass('first-child');
	$('#footer-widgets div.widget:last-child').addClass('last-child');
	$('#footer-widgets div.widget:nth-child(even)').addClass('even');
	$('#footer-widgets div.widget:nth-child(odd)').addClass('odd');
	
	var numwidgets = $('#footer-widgets div.widget').length;
	$('#footer-widgets').addClass('cols-'+numwidgets);
	
	//special for lifestyle
	$('.ftr-menu ul.menu>li').after(function(){
		if(!$(this).hasClass('last-child') && $(this).hasClass('menu-item') && $(this).css('display')!='none'){
			return '<li class="separator">|</li>';
		}
	});
    
    //icons
    $('.menu').not('#menu-primary-links').children('li.menu-item').children('a').prepend('<i class="fa"></i>');
    $('li.Client-Login>a>i').addClass('fa-sign-in');
    $('li.Contact-Us>a>i').addClass('fa-comments');
    $('li.Disclosures>a>i').addClass('fa-align-left');
    $('li.Careers>a>i').addClass('fa-briefcase');
    
    //tab greys
    var tabimg = jQuery('.nav-tabs li .grayscale').not('.nav-tabs li.active .grayscale');
    tabimg.mouseover(function(){
        grayscale.reset($(this));
    }).mouseout(function(){
        graytabs();
        //grayscale($(this));
    });
    
   /* jQuery('.nav-tabs li').on('show.bs.tab',function(e){
        var active = jQuery(e.target).find('.grayscale');
        graytabs();
    });
    
	/*RESPONSIVE NAVIGATION, COMBINES MENUS EXCEPT FOR FOOTER MENU*/

    //jQuery('.menu').not('#footer .menu, #footer-widgets .menu').wrap('<div id="nav-response" class="nav-responsive">');
    jQuery('#menu-primary-links').wrap('<div id="nav-response" class="nav-responsive">');
    jQuery('#nav-response').append('<a href="#" id="pull" class="closed"><strong>MENU</strong></a>');   
    
    //move the search box
    if(jQuery('#pull').css('display') != 'none'){
        var mysearch = jQuery('.nav-responsive').find('li.search');
        jQuery('#pull').before(mysearch);
    }
    
    //combinate
    sf_duplicate_menu( jQuery('.nav-responsive>ul'), jQuery('#pull'), 'mobile_menu', 'sf_mobile_menu' );
    
            
            function sf_duplicate_menu( menu, append_to, menu_id, menu_class ){
                var jQuerycloned_nav;
                
                menu.clone().attr('id',menu_id).removeClass().attr('class',menu_class).appendTo( append_to );
                jQuerycloned_nav = append_to.find('> ul');
                jQuerycloned_nav.find('.menu_slide').remove();
                jQuerycloned_nav.find('li:first').addClass('sf_first_mobile_item');
                
                append_to.click( function(){
                    if ( jQuery(this).hasClass('closed') ){
                        jQuery(this).removeClass( 'closed' ).addClass( 'opened' );
                        jQuerycloned_nav.slideDown( 500 );
                    } else {
                        jQuery(this).removeClass( 'opened' ).addClass( 'closed' );
                        jQuerycloned_nav.slideUp( 500 );
                    }
                    return false;
                } );
                
                append_to.find('a').click( function(event){
                    event.stopPropagation();
                } );
            }
});

function graytabs(){
    var tabimg = jQuery('.nav-tabs li .grayscale').not('.nav-tabs li.active .grayscale');
    grayscale(tabimg);
}