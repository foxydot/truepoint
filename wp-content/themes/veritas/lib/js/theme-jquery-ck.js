function strripos(e,t,n){e=(e+"").toLowerCase();t=(t+"").toLowerCase();var r=-1;if(n){r=(e+"").slice(n).lastIndexOf(t);r!==-1&&(r+=n)}else r=(e+"").lastIndexOf(t);return r>=0?r:!1}jQuery(document).ready(function(e){e("*:first-child").addClass("first-child");e("*:last-child").addClass("last-child");e("*:nth-child(even)").addClass("even");e("*:nth-child(odd)").addClass("odd");var t=e("#footer-widgets div.widget").length;e("#footer-widgets").addClass("cols-"+t);e(".ftr-menu ul.menu>li").after(function(){if(!e(this).hasClass("last-child")&&e(this).hasClass("menu-item")&&e(this).css("display")!="none")return'<li class="separator">|</li>'});e(".menu").not("#menu-primary-links").children("li.menu-item").children("a").prepend('<i class="fa"></i>');e("li.Client-Login>a>i").addClass("fa-sign-in");e("li.Contact-Us>a>i").addClass("fa-comments");e("li.Disclosures>a>i").addClass("fa-align-left");e("li.Careers>a>i").addClass("fa-briefcase");e("li.Sitemap>a>i").addClass("fa-sitemap");!e("body").hasClass("home")&&!e("#menu-primary-links .about-you").hasClass("current-menu-ancestor")&&e("#menu-primary-links .about-us").addClass("current-menu-ancestor");e("#menu-primary-links .about-you").hover(function(){e("#menu-primary-links .about-us").hasClass("current-menu-ancestor")&&e("#menu-primary-links .about-us").removeClass("current-menu-ancestor").addClass("current-menu-ancestor-temp")},function(){e("#menu-primary-links .about-us").hasClass("current-menu-ancestor-temp")&&e("#menu-primary-links .about-us").removeClass("current-menu-ancestor-temp").addClass("current-menu-ancestor")});e("#menu-primary-links .about-us").hover(function(){e("#menu-primary-links .about-you").hasClass("current-menu-ancestor")&&e("#menu-primary-links .about-you").removeClass("current-menu-ancestor").addClass("current-menu-ancestor-temp")},function(){e("#menu-primary-links .about-you").hasClass("current-menu-ancestor-temp")&&e("#menu-primary-links .about-you").removeClass("current-menu-ancestor-temp").addClass("current-menu-ancestor")});e("ul").prev("p").css("margin-bottom","1rem");e(".tablepress tbody tr.first-child").addClass(function(){var t;e(this).find("td").each(function(){t+=e(this).text()});if(t=="undefined")return"hidden"});var n=Array("truepoint.oc","72.52.131.35","truepointwealth.com","truepointinc.com");e("a").attr("target",function(){var t=e(this).attr("href"),r=e(this).attr("target");if(strripos(t,"mailto",0)===0)return"_blank";if(t=="#"||strripos(t,"http",0)===!1)return"_self";var i=0;while(n[i]){if(strripos(t,n[i],0))return r;i++}return"_blank"})});