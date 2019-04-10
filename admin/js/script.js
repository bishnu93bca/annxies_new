/* Author:



*/



$(function () {




    /*
    	$("#navigation li").click(function(){

    		$("#navigation li").children("ul").stop(true, true).slideUp(600);

    		$(this).children("ul").stop(true, true).slideToggle(600);

    	});

    	

    	$("#navigation > nav > ul > li > a").click(function(){

    		if($(this).data("clicked")!="clicked"){

    			$(this).data("clicked", "clicked");

    			$(this).addClass("active").parent().children("ul").css({"display":"block"});			

    			console.log($(this).data("clicked") + "hi")

    		}else{

    		if($(this).data("clicked")=="clicked"){

    				console.log($(this).data("clicked"));

    				$(this).removeClass("active").parent().next("ul").slideUp(600);

    				$(this).removeData("clicked");

    		}

    		}

    		return false;

    	});*/







    Modernizr.addTest("toast_it", $(".toast").length > 0);



    Modernizr.load({

        test: Modernizr.toast_it,

        yep: ["js/libs/jquery.toastmessage.js", "css/jquery.toastmessage.css"],

        callback: function () {

            $(".toast").live("click", function () {

                var name = $(this).data("message");

                var src = "http://translate.google.com/translate_tts?tl=en&q=" + name;



                $('#ifrm').attr("src", src);



                $(".toast-item-wrapper").eq(1).detach();

                $().toastmessage('showToast', {



                    text: name,

                    sticky: $(this).data("sticky"), //true, false

                    inEffectDuration: 600, // in effect duration in miliseconds

                    stayTime: 3000, // time in miliseconds before the item has to disappear

                    type: $(this).data("type"), // notice, warning, error, success 

                    position: 'middle-center', // top-left, top-center, top-right, middle-left, middle-center, middle-right

                    close: function () {}

                });



                return false;

            })



        }

    })



    Modernizr.addTest("preety", $(".preety_image").length > 0);



    Modernizr.load({

        test: Modernizr.preety,

        yep: ["js/libs/jquery.prettyPhoto.js", "css/prettyPhoto.css"],

        callback: function () {

            $(".preety_image").prettyPhoto({
                deeplinking: false,
                theme: 'light_square',
                show_title: false,
                social_tools: false,
                slideshow: 5000,
                autoplay_slideshow: true,
                animation_speed: 'slow'
            });



        }



    });

    /*$(document).on('mouseover mouseout mouseenter', '.document_list_last', function (event) {
		var $this = $(this); 
        if (event.type == 'mouseover' || event.type == 'mouseenter') {           
            var tp = $this.find(".document_list").offset().top;
            var ch = $this.find(".document_list").height();
            var wtp = $(window).scrollTop();

            if (((tp + ch) - wtp) >= $(window).height() - 10){
                $this.addClass('touch_bottom');           
				}

        } else if (event.type == 'mouseout') {			
			setTimeout(function() {
				$this.removeClass('touch_bottom');
			},0);            
        }
    });*/

    $('.document_list_last').hover(function () {
            var $this = $(this);
            var tp = $this.find(".document_list").offset().top;
            var ch = $this.find(".document_list").height();
            var rp = $this.find(".document_list").offset().left;
            //var cwidth = $this.find(".document_list").width();

            var wtp = $(window).scrollTop();

            if (((tp + ch) - wtp) > $(window).height() - 10) {
                $this.addClass('touch_bottom');
            }
            if ((rp) < 0) {
                $this.addClass('touch_left');
            }

        },
        function () {
            var $this = $(this);
            setTimeout(function () {
                $this.removeClass('touch_bottom, touch_left');
            }, 0);
        }
    );


    /********** responsive ************/

    $(window).load(function () {
        var ht = $("#navigation nav").html();
        $(".responsive_nav").append(ht);
    });
    $('.responsive_btn').click(function () {
        $('body').addClass('responsive');
        $(this).attr('data-click', 'y');
    });
    $('.res_click').click(function () {
        $('body').removeClass('responsive');
        $('.responsive_btn').attr('data-click', 'n');
    });

    var $window = $(window),
        $bdy = $('body');

    function resize() {
        if ($window.width() > 1024) {
            $bdy.removeClass('responsive');
        }
        if ($window.width() < 1199) {
            var dr = $('.responsive_btn').attr('data-click');
            if (dr == 'y') {
                $bdy.addClass('responsive');
            }
        }
    }
    $window.resize(resize).trigger('resize');


    $('.numbersOnly').keyup(function () {
        this.value = this.value.replace(/[^0-9\,.]/g, '');
    });
    
    
    $("#navigation nav > ul > li > a").each(function(){
        if($(this).parent().hasClass('active')){
            $(this).addClass('side_arrow_on');
            $(this).next().show();
        } else{
            $(this).removeClass('side_arrow_on');
            $(this).next().hide();
        }
        
        $(this).bind("click",function(){
            if($(this).hasClass('side_arrow_on')){
                $("#navigation nav > ul > li > a").removeClass('side_arrow_on');
                $("#navigation nav > ul > li > a").next().slideUp(300);
                $(this).removeClass('side_arrow_on');
                $(this).next().slideUp(300);
                return false;
            }
            else{
                $("#navigation nav > ul > li > a").removeClass('side_arrow_on');
                $("#navigation nav > ul > li > a").next().slideUp(300);
                $(this).addClass('side_arrow_on');
                $(this).next().slideDown(300);
                return false;
            }
        });
	});
    
    
    $('.offmenu').click(function(){
        $(this).parent().toggleClass('nomenu');
    });
      
    $(document).on('keyup','.qty_input', function(){
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
    });


});
