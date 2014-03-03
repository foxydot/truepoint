jQuery(document).ready(function($) {
    var numwidgets = $('#homepage-widgets section.widget').length;
    $('#homepage-widgets').addClass('cols-'+numwidgets);
    var cols = 12/numwidgets;
    $('#homepage-widgets section.widget').addClass('col-sm-'+cols);
    $('#homepage-widgets section.widget').addClass('col-xs-12');
    $('#homepage-widgets section.widget .widget-wrap').equalHeightColumns();    
    
    $('#menu-primary-links .about-you').hover(function(){
        $('#menu-primary-links .about-us').addClass('inactive');
    },function(){
        $('#menu-primary-links .about-us').removeClass('inactive');
    });
    
    $('#menu-primary-links .about-us').hover(function(){
        $('#menu-primary-links .about-you').addClass('inactive');
    },function(){
        $('#menu-primary-links .about-you').removeClass('inactive');
    });
});