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
    $('li.Sitemap>a>i').addClass('fa-sitemap');
        
    //$('.Client-Login.menu-item>a').attr('data-toggle','modal').attr('data-target','#client-login-message');  
    
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
    
    $('ul').prev('p').css('margin-bottom','0px');
    
    // add target="_blank" to all *external* 
    var internal_urls = Array('truepoint.oc','72.52.131.35','truepointwealth.com','truepointinc.com');
    $('a').attr('target',function(){
        var url = $(this).attr('href');
        var target = $(this).attr('target');
        if(url == '#' || strripos(url,'http',0)===false){
            return '_self';
        } else {
            var i=0;
            while (internal_urls[i]){
                if(strripos(url, internal_urls[i], 0)){
                    return target;
                }
                i++;
            }
            return '_blank';
        }
    });
});

function strripos(haystack, needle, offset) {
  //  discuss at: http://phpjs.org/functions/strripos/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Onno Marsman
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //    input by: saulius
  //   example 1: strripos('Kevin van Zonneveld', 'E');
  //   returns 1: 16

  haystack = (haystack + '')
    .toLowerCase();
  needle = (needle + '')
    .toLowerCase();

  var i = -1;
  if (offset) {
    i = (haystack + '')
      .slice(offset)
      .lastIndexOf(needle); // strrpos' offset indicates starting point of range till end,
    // while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
    if (i !== -1) {
      i += offset;
    }
  } else {
    i = (haystack + '')
      .lastIndexOf(needle);
  }
  return i >= 0 ? i : false;
}