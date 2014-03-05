jQuery(document).ready(function($) {	
    $('*:first-child').addClass('first-child');
    $('*:last-child').addClass('last-child');
    $('*:nth-child(even)').addClass('even');
    $('*:nth-child(odd)').addClass('odd');
	
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
        
    $('.Client-Login.menu-item>a').attr('data-toggle','modal').attr('data-target','#client-login');  
    
    if(!$('body').hasClass('home') && !$('#menu-primary-links .about-you').hasClass('current-menu-ancestor')){
        $('#menu-primary-links .about-us').addClass('current-menu-ancestor');
    }
    
    $('#menu-primary-links .about-you').hover(function(){
        if($('#menu-primary-links .about-us').hasClass('current-menu-ancestor')){
            $('#menu-primary-links .about-us').removeClass('current-menu-ancestor').addClass('current-menu-ancestor-temp');
        }
    },function(){
        if($('#menu-primary-links .about-us').hasClass('current-menu-ancestor-temp')){
            $('#menu-primary-links .about-us').removeClass('current-menu-ancestor-temp').addClass('current-menu-ancestor');
        }
    });
    
    $('#menu-primary-links .about-us').hover(function(){
        if($('#menu-primary-links .about-you').hasClass('current-menu-ancestor')){
            $('#menu-primary-links .about-you').removeClass('current-menu-ancestor').addClass('current-menu-ancestor-temp');
        }
    },function(){
        if($('#menu-primary-links .about-you').hasClass('current-menu-ancestor-temp')){
            $('#menu-primary-links .about-you').removeClass('current-menu-ancestor-temp').addClass('current-menu-ancestor');
        }
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