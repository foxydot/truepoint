jQuery(document).ready(function(e){var t=e("#homepage-widgets section.widget").length;e("#homepage-widgets").addClass("cols-"+t);var n=12/t;e("#homepage-widgets section.widget").addClass("col-sm-"+n);e("#homepage-widgets section.widget").addClass("col-xs-12");window.innerWidth>500&&e("#homepage-widgets section.widget .widget-wrap").equalHeightColumns();e("#menu-primary-links .about-you").hover(function(){e("#menu-primary-links .about-us").addClass("inactive")},function(){e("#menu-primary-links .about-us").removeClass("inactive")});e("#menu-primary-links .about-us").hover(function(){e("#menu-primary-links .about-you").addClass("inactive")},function(){e("#menu-primary-links .about-you").removeClass("inactive")});e(".in-the-news.widget ul").addClass("fa-ul");e(".truepoint-viewpoint.widget ul").addClass("fa-ul")});