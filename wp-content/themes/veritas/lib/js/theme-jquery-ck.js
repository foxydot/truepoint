jQuery(document).ready(function(e){function r(e,t,n,r){var i;e.clone().attr("id",n).removeClass().attr("class",r).appendTo(t);i=t.find("> ul");i.find(".menu_slide").remove();i.find("li:first").addClass("sf_first_mobile_item");t.click(function(){if(jQuery(this).hasClass("closed")){jQuery(this).removeClass("closed").addClass("opened");i.slideDown(500)}else{jQuery(this).removeClass("opened").addClass("closed");i.slideUp(500)}return!1});t.find("a").click(function(e){e.stopPropagation()})}e("ul li:first-child").addClass("first-child");e("ul li:last-child").addClass("last-child");e("ul li:nth-child(even)").addClass("even");e("ul li:nth-child(odd)").addClass("odd");e("table tr:first-child").addClass("first-child");e("table tr:last-child").addClass("last-child");e("table tr:nth-child(even)").addClass("even");e("table tr:nth-child(odd)").addClass("odd");e("tr td:first-child").addClass("first-child");e("tr td:last-child").addClass("last-child");e("tr td:nth-child(even)").addClass("even");e("tr td:nth-child(odd)").addClass("odd");e("div:first-child").addClass("first-child");e("div:last-child").addClass("last-child");e("div:nth-child(even)").addClass("even");e("div:nth-child(odd)").addClass("odd");e("section:first-child").addClass("first-child");e("section:last-child").addClass("last-child");e("section:nth-child(even)").addClass("even");e("section:nth-child(odd)").addClass("odd");e("#footer-widgets div.widget:first-child").addClass("first-child");e("#footer-widgets div.widget:last-child").addClass("last-child");e("#footer-widgets div.widget:nth-child(even)").addClass("even");e("#footer-widgets div.widget:nth-child(odd)").addClass("odd");var t=e("#footer-widgets div.widget").length;e("#footer-widgets").addClass("cols-"+t);e(".ftr-menu ul.menu>li").after(function(){if(!e(this).hasClass("last-child")&&e(this).hasClass("menu-item")&&e(this).css("display")!="none")return'<li class="separator">|</li>'});e(".site-inner").addClass("container");e(".content-sidebar .content-sidebar-wrap").addClass("row");e(".content-sidebar .content").addClass("col-md-8 col-sm-12");e(".content-sidebar .sidebar").addClass("col-md-4");e(".menu").not("#menu-primary-links").children("li.menu-item").children("a").prepend('<i class="fa"></i>');e("li.Client-Login>a>i").addClass("fa-sign-in");e("li.Contact-Us>a>i").addClass("fa-comments");e("li.Disclosures>a>i").addClass("fa-align-left");e("li.Careers>a>i").addClass("fa-briefcase");jQuery("#menu-primary-links").wrap('<div id="nav-response" class="nav-responsive">');jQuery("#nav-response").append('<a href="#" id="pull" class="closed"><strong>MENU</strong></a>');if(jQuery("#pull").css("display")!="none"){var n=jQuery(".nav-responsive").find("li.search");jQuery("#pull").before(n)}r(jQuery(".nav-responsive>ul"),jQuery("#pull"),"mobile_menu","sf_mobile_menu")});