/***************************************************
			SuperFish Menu
***************************************************/	
// initialise plugins
	jQuery.noConflict()(function(){
		jQuery('ul.menu').superfish();
	});
	
	
	
jQuery.noConflict()(function($) {
  if ($.browser.msie && $.browser.version.substr(0,1)<7)
  {
	$('li').has('ul').mouseover(function(){
		$(this).children('ul').css('visibility','visible');
		}).mouseout(function(){
		$(this).children('ul').css('visibility','hidden');
		})
  }
});



jQuery.noConflict()(function($){

      // Create the dropdown base
      $("<select />").appendTo("nav");

      // Create default option "Go to..." 
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Please choose page" 
      }).appendTo("nav select");
      //new dropdown menu
      $("nav a").each(function() {
                var el = $(this);
                var perfix = '';
                switch(el.parents().length){
                        case(11):
                                perfix = '';
                        break;
                        case(13):
                                perfix = '-- ';
                        break;
                        default:
                                perfix = '';
                        break;

                }
                $("<option />", {
                "value"   : el.attr("href"),
                "text"    : perfix + el.text()
                }).appendTo("nav select");
				
			  $("nav select").change(function() {
				window.location = $(this).find("option:selected").val();
			  });
});});




jQuery.noConflict()(function($){
	$(document).ready(function() {  
		$("a[rel^='prettyPhoto']").prettyPhoto({opacity:0.80,default_width:200,default_height:344,hideflash:false,modal:false,social_tools:false});
	});
});

jQuery.noConflict()(function($){
	$(window).load(function() {
        $('#slider').nivoSlider();
    });
})

jQuery.noConflict()(function($){
	jQuery(document).ready(function () {
		JQTWEET.loadTweets();
	});
})


jQuery.noConflict()(function($){
	$(".testimonialrotator").testimonialrotator({
		settings_slideshowTime:3
	});
});


// PORTFOLIO FILTERING - ISOTOPE
//**********************************
jQuery.noConflict()(function($){
var $container = $('#portfolio');
		
if($container.length) {
	$container.waitForImages(function() {
		
		// initialize isotope
		$container.isotope({
		  itemSelector : '.block',
		  layoutMode : 'fitRows'
		});
		
		// filter items when filter link is clicked
		$('#filters a').click(function(){
		  var selector = $(this).attr('data-filter');
		  $container.isotope({ filter: selector });
		  $(this).removeClass('filter_button').addClass('filter_button filter_current').siblings().removeClass('filter_button filter_current').addClass('filter_button');
		  
		  return false;
		});
		
	},null,true);
}});


// PORTFOLIO FILTERING - ISOTOPE
//**********************************
jQuery.noConflict()(function($){
var $container = $('#portfolio_sidebar');
		
if($container.length) {
	$container.waitForImages(function() {
		
		// initialize isotope
		$container.isotope({
		  itemSelector : '.block',
		  layoutMode : 'fitRows'
		});
		
		// filter items when filter link is clicked
		$('#filters_sidebar a').click(function(){
		  var selector = $(this).attr('data-filter');
		  $container.isotope({ filter: selector });
		  $(this).removeClass('filter_sidebar').addClass('filter_sidebar filter_sidebar_current').siblings().removeClass('filter_sidebar filter_sidebar_current').addClass('filter_sidebar');
		  
		  return false;
		});
		
	},null,true);
}});

/***************************************************
			SlideOut
***************************************************/
jQuery.noConflict()(function($){
             $('.slide-out-div').tabSlideOut({
                 tabHandle: '.handle',                              //class of the element that will be your tab
                 pathToTabImage:'../images/contact_tab.gif',          //path to the image for the tab (optionaly can be set using css)
                 imageHeight: '115px',                               //height of tab image
                 imageWidth: '50px',                               //width of tab image    
                tabLocation: 'left',                               //side of screen where tab lives, top, right, bottom, or left
                 speed: 300,                                        //speed of animation
                 action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
                 topPos: '-33px',                                   //position from the top
                 fixedPosition: true                               //options: true makes it stick(fixed position) on scroll
             });
         });