<?php
if($dtls!='signpdf')
{
    if($pageId == 21)  
        echo '<div class="white-color">';
?>
    <div class="container">

        <!-- Modal -->
        <div id="modal_after_contract_sign" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
<!--                        <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                    </div>
                    <div class="modal-body">
                        <h3 class="alert alert-danger" role="alert">Congratulations for signing the contract with Annexis. Please go to your inbox to get your credentials. </h3>
                    </div>
                   <div class="modal-footer">
                        <a href="http://www.annexis.net/login/" class="btn btn-secondary">ok</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <div class="textwidget"> <a href="<?php echo $SITE_LOC_PATH.'/';?>"> <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/footer-logo.png"/> </a> <br>
                        <br>
                        <div class="textwidget">
                            <ul class="unstyled">
                                <li><i class="icon-call"></i> +1 800.816.9554</li>
                                <li><i class="icon-envelope icon-white"></i> <a href="mailto:info@annexis.net">info@annexis.net</a></li>
                                <li><i class="icon-map-marker icon-white"></i> 110 SE 6th Street Suite 1700 ▪ Ft. Lauderdale, Florida 33301</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="span2 pull-right">
                    <h5>Connect Us</h5>
                    <hr>
                    <div class="textwidget">
                        <div class="connectwithus">
                            <ul>
                                <li class="first"><a href="https://www.linkedin.com/grp/home?gid=6711409&sort=POPULAR" title="Linked In" class="linked-in" target="_blank"><img src="<?php echo $STYLE_FILES_SRC;?>/images/footer-linkedin.png" alt="Linked In" border="0"></a></li>
                                <li><a href="https://www.youtube.com/channel/UCprlEiBmIlIPuxvIPWoSJZg" title="Youtube" class="youtube" target="_blank"><img src="<?php echo $STYLE_FILES_SRC;?>/images/footer-youtube.png" alt="Youtube" border="0"></a></li>
                                <li><a href="" title="Twitter" class="twitter" target="_blank"><img src="<?php echo $STYLE_FILES_SRC;?>/images/footer-twitter.png" alt="Twitter" border="0"></a></li>
                                <li><a href="https://www.facebook.com/annexisbusinesssolutions?ref=hl" title="Facebook" class="facebook" target="_blank"><img src="<?php echo $STYLE_FILES_SRC;?>/images/footer-facebook.png" alt="Facebook" border="0"></a></li>
                                <li class="last"><a href="https://plus.google.com/u/0/105981399301260936627/posts" title="Google Plus" class="googleplus" target="_blank"><img src="<?php echo $STYLE_FILES_SRC;?>/images/footer-googleplus.png" alt="RSS" border="0"></a></li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="span5 pull-right">
                    <h5>Quick Links</h5>
                    <hr>
                    <div class="h-textwidget">
                        <?php include($ROOT_PATH.'/'.MODULE_PATH.'/sitepage/footermenu.php');?>
                    </div>
                </div>
                <!-- END WIDGET --> 
            </div>
        </div>
    </div>
    <div class="bottom_line">
        <div class="container">
            <div class="row"> 
                <!-- START COPYRIGHT INFORMATION-->
                <div class="span6">
                    <span class="footer_left">Copyright <?php echo date('Y');?> <a href="http://www.annexis.net" target="_blank">Annexis.</a></span>
                </div>
            <!-- END COPYRIGHT INFORMATION-->
                <div class="span6"> 
                <!-- START FOOTER MENU-->
                    <div class="copyright pull-right visible-desktop">
                        <div class="menu-footer-menu-container">
                            <ul class="unstyled footer_menu" id="menu-footer-menu">
                                <li><a href="<?php echo $SITE_LOC_PATH;?>/">Home</a></li>
                                <li><a href="<?php echo $SITE_LOC_PATH.'/privacy-policy/';?>">Privacy Policy</a></li>
                                <li><a href="<?php echo $SITE_LOC_PATH.'/terms-amp-condition/';?>">Terms & Condition</a></li>
                                <li><a href="<?php echo $SITE_LOC_PATH.'/contact-annexis/';?>">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                <!-- END FOOTER MENU--> 
                </div>
            </div>
        </div>
    </div>
    <?php
    if($pageId == 21)
        echo '</div>';  
    ?>
</div>
        <a href="#" class="scrollToTop"></a>
        <!-- Le javascript
                    ================================================== --> 
        <!-- Placed at the end of the document so the pages load faster --> 

        <?php if($pageId == 24) { ?>

            <!--<script src="<?php echo $STYLE_FILES_SRC;?>/js/jquery-1.10.2.min.js"></script>-->
            <script>
                function addEvent(e, a, $ = jQuery){
                    var c=$("#"+e);
                    var d=$("#"+e+",#"+map_config[e]["namesId"]);var b=$("#map").height();$("#"+map_config[e]["namesId"]).find("tspan").attr({fill:map_config["default"]["namescolor"]});c.attr({fill:map_config[e]["upcolor"],stroke:map_config["default"]["bordercolor"]});d.attr({cursor:"default"});

                    if(map_config[e]["enable"]==true) {
                        d.attr({cursor:"pointer"});d.hover(function(){$("#tip").show().html(map_config[e]["name"]);c.css({fill:map_config[e]["overcolor"]})},function(){$("#tip").hide();$("#"+e).css({fill:map_config[e]["upcolor"]})});d.mousedown(function(){$("#"+e).css({fill:map_config[e]["downcolor"]})});d.mouseup(function(){$("#"+e).css({fill:map_config[e]["overcolor"]});if(map_config[e]["target"]=="_blank"){window.open(map_config[e]["url"])}else{window.location.href=map_config[e]["url"]}});d.mousemove(function(i){var g=i.pageX-20,j=i.pageY+(-38);var h=$("#tip").outerWidth(),f=$("#tip").outerHeight(),g=(g+h>$(document).scrollLeft()+$(window).width())?g-h-(20*2):g;j=(j+f>$(document).scrollTop()+$(window).height())?$(document).scrollTop()+$(window).height()-f-10:j;$("#tip").css({left:g,top:j})})
                    }
                }
                
                jQuery.noConflict()(function ($) {
                    addEvent("map_1");addEvent("map_2");addEvent("map_3");addEvent("map_4");addEvent("map_5");addEvent("map_6");addEvent("map_7");addEvent("map_8");addEvent("map_9");addEvent("map_10");addEvent("map_11");addEvent("map_12");addEvent("map_13");addEvent("map_14");addEvent("map_15");addEvent("map_16");addEvent("map_17");addEvent("map_18");addEvent("map_19");addEvent("map_20");addEvent("map_21");addEvent("map_22");addEvent("map_23");addEvent("map_24");addEvent("map_25");addEvent("map_26");addEvent("map_27");addEvent("map_28");addEvent("map_29");addEvent("map_30");addEvent("map_31");addEvent("map_32");addEvent("map_33");addEvent("map_34");addEvent("map_35");addEvent("map_36");addEvent("map_37");addEvent("map_38");addEvent("map_39");addEvent("map_40");addEvent("map_41");addEvent("map_42");addEvent("map_43");addEvent("map_44");addEvent("map_45");addEvent("map_46");addEvent("map_47");addEvent("map_48");addEvent("map_49");addEvent("map_50");addEvent("map_51")
                });
                
                jQuery.noConflict()(function ($) {
                    
                    if($("#lakes").find("path").eq(0).attr("fill")!="undefined")
                    {
                        $("#lakes").find("path").attr({fill:map_config["default"]["lakescolor"]}).css({stroke:map_config["default"]["bordercolor"]})
                    }
                    
                    $(".tip").css({"box-shadow":"1px 2px 4px "+map_config["default"]["namesShadowColor"],"-moz-box-shadow":"2px 3px 6px "+map_config["default"]["namesShadowColor"],"-webkit-box-shadow":"2px 3px 6px "+map_config["default"]["namesShadowColor"]});
                    
                    if($("#shadow").find("path").eq(0).attr("fill")!="undefined"){var a=map_config["default"]["shadowOpacity"];var a=parseInt(a);if(a>=100){a=1}else{if(a<=0){a=0}else{a=a/100}}$("#shadow").find("path").attr({fill:map_config["default"]["shadowcolor"]}).css({"fill-opacity":a})}
                    
                    
                });
                
                
            </script> 

            <script>var map_config={"default":{bordercolor:"#9CA8B6",lakescolor:"#66CCFF",shadowcolor:"#000000",shadowOpacity:"50",namescolor:"#666666",namesShadowColor:"#666666"},

            map_1:{namesId:"AL",name:"ALABAMA",url:"states/alabama.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_2:{namesId:"AK",name:"ALASKA",url:"states/alaska.html",target:"_blank",upcolor:"#bbbbbb",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_3:{namesId:"AZ",name:"ARIZONA",url:"states/arizona.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_4:{namesId:"AR",name:"ARKANSAS",url:"states/arkansas.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_5:{namesId:"CA",name:"CALIFORNIA",url:"states/california.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_6:{namesId:"CO",name:"COLORADO",url:"states/colorado.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_7:{namesId:"CT",name:"CONNECTICUT",url:"states/connecticut.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_8:{namesId:"DE",name:"DELAWARE",url:"states/delaware.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_9:{namesId:"FL",name:"FLORIDA",url:"states/florida.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_10:{namesId:"GA",name:"GEORGIA",url:"states/georgia.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_11:{namesId:"HI",name:"HAWAII",url:"states/hawaii.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_12:{namesId:"ID",name:"IDAHO",url:"states/idaho.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_13:{namesId:"IL",name:"ILLINOIS",url:"states/illinois.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_14:{namesId:"IN",name:"INDIANA",url:"states/indiana.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_15:{namesId:"IA",name:"IOWA",url:"states/iowa.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_16:{namesId:"KS",name:"KANSAS",url:"states/kansas.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_17:{namesId:"KY",name:"KENTUCKY",url:"states/kentucky.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_18:{namesId:"LA",name:"LOUISIANA",url:"states/louisiana",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_19:{namesId:"ME",name:"MAINE",url:"states/maine.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_20:{namesId:"MD",name:"MARYLAND",url:"states/maryland.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_21:{namesId:"MA",name:"MASSACHUSETTS",url:"states/massachusetts.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_22:{namesId:"MI",name:"MICHIGAN",url:"states/michigan.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_23:{namesId:"MN",name:"MINNESOTA",url:"states/minnesota.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_24:{namesId:"MS",name:"MISSISSIPPI",url:"states/mississippi.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_25:{namesId:"MO",name:"MISSOURI",url:"states/missouri.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_26:{namesId:"MT",name:"MONTANA",url:"states/montana.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_27:{namesId:"NE",name:"NEBRASKA",url:"states/nebraska.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_28:{namesId:"NV",name:"NEVADA",url:"states/nevada.html",target:"_blank",upcolor:"#bbbbbb",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_29:{namesId:"NH",name:"NEW HAMPSHIRE",url:"states/new-hampshire.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_30:{namesId:"NJ",name:"NEW JERSEY",url:"states/new-jersey.html",target:"_blank",upcolor:"#bdd8f2",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_31:{namesId:"NM",name:"NEW MEXICO",url:"states/new-mexico.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_32:{namesId:"NY",name:"NEW YORK",url:"states/new-york.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_33:{namesId:"NC",name:"NORTH CAROLINA",url:"states/north-carolina.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_34:{namesId:"ND",name:"NORTH DAKOTA",url:"states/north-dakota.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_35:{namesId:"OH",name:"OHIO",url:"states/ohio.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_36:{namesId:"OK",name:"OKLAHOMA",url:"states/oklahoma.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_37:{namesId:"OR",name:"OREGON",url:"states/orgeon.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_38:{namesId:"PA",name:"PENNSYLVANIA",url:"states/pennsylvania.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_39:{namesId:"RI",name:"RHODE ISLAND",url:"states/rhode-island.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_40:{namesId:"SC",name:"SOUTH CAROLINA",url:"states/south-carolina.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_41:{namesId:"SD",name:"SOUTH DAKOTA",url:"states/south-dakota.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_42:{namesId:"TN",name:"TENNESSEE",url:"states/tennessee.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_43:{namesId:"TX",name:"TEXAS",url:"states/texas.html",target:"_blank",upcolor:"#92badf",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_44:{namesId:"UT",name:"UTAH",url:"states/utah.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_45:{namesId:"VT",name:"VERMONT",url:"states/vermont.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},

            map_46:{namesId:"VA",name:"VIRGINIA",url:"states/virginia.html",target:"_blank",upcolor:"#a8caea",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_47:{namesId:"WA",name:" WASHINGTON: 2 Offices",url:"states/washington.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_48:{namesId:"WV",name:"WEST VIRGINIA",url:"states/west-virginia.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_49:{namesId:"WI",name:"WISCONSIN",url:"states/wisconsin.html",target:"_blank",upcolor:"#e5f3ff",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_50:{namesId:"WY",name:"WYOMING",url:"states/wyoming.html",target:"_blank",upcolor:"#d3e7f9",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true},


            map_51:{namesId:"DC",name:"WASHINGTON DC",url:"states/washington-dc.html",target:"_blank",upcolor:"#FF6600",overcolor:"#f0ab33",downcolor:"#ff9908",enable:true}};</script>
            <script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', 'UA-42291951-2', 'html5interactivemaps.com');ga('send', 'pageview');</script>
            
            <?php 
             /*<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>

            <script type="text/javascript">
                stLight.options({publisher: "1ea7e5c5-d7eb-4978-983a-8c5425cef1dd", doNotHash: false, doNotCopy: false, hashAddressBar: false});
            </script>
            <script>
                var options={ "publisher": "1ea7e5c5-d7eb-4978-983a-8c5425cef1dd", "position": "left", "ad": { "visible": false, "openDelay": 5, "closeDelay": 0}, "chicklets": { "items": ["facebook", "twitter", "googleplus", "linkedin", "email", "sharethis"]}};var st_hover_widget = new sharethis.widgets.hoverbuttons(options);
            </script>*/?>
            <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/videopopup.js"></script>
            <script type="text/javascript">
                jQuery.noConflict()(function ($) {
                   $('#vidBox').VideoPopUp({
                      backgroundColor: "#17212a",
                      opener: "video1",
                        maxweight: "340",
                        idvideo: "v1"
                    });
                });
            </script>
        <?php }?>
        
        <script type="text/javascript" src="<?php echo $STYLE_FILES_SRC;?>/rs-plugin/js/jquery.themepunch.plugins.min.js"></script> 
        <script type="text/javascript" src="<?php echo $STYLE_FILES_SRC;?>/rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 
        
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/google-code-prettify/prettify.js"></script> 
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.easing.1.3.js"></script>
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.nivo.slider.js"></script> 
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.prettyPhoto.js"></script> 
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jflickrfeed.min.js"></script> 
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/testimonialrotator.js"></script> 
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.waitforimages.js"></script> 
        
        <script src="<?php echo $STYLE_FILES_SRC;?>/flexslider/jquery.flexslider-min.js"></script> 
        
        <script type="text/javascript">
            jQuery.noConflict()(function ($) {
                
                $(window).on('scroll', function(){
                    if ($(this).scrollTop() > 100) {
                        $('.scrollToTop').fadeIn();
                    } else {
                        $('.scrollToTop').fadeOut();
                    }
                });

                //Click event to scroll to top
                $('.scrollToTop').on('click', function(){
                    $('html, body').animate({scrollTop : 0},800);
                    return false;
                });
                
                $(window).on('load', function() {
                    $('.flexslider').flexslider({animation: "slide", controlNav: false,});
                });
                
                
            });
        </script> 
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/custom.js"></script> 
        <script type="text/javascript">
            var tpj=jQuery;
            tpj.noConflict();
            var revapi2;
            tpj(document).ready(function() {

                if (tpj.fn.cssOriginal != undefined)
                    tpj.fn.css = tpj.fn.cssOriginal;

                if(tpj('#rev_slider_2_1').revolution == undefined)
                    revslider_showDoubleJqueryError('#rev_slider_2_1');
                else
                   revapi2 = tpj('#rev_slider_2_1').show().revolution({
                            delay:9000,
                            startwidth:770,
                            startheight:440,
                            hideThumbs:200,

                            thumbWidth:100,
                            thumbHeight:50,
                            thumbAmount:3,

                            navigationType:"none",
                            navigationArrows:"verticalcentered",
                            navigationStyle:"navbar",

                            touchenabled:"on",
                            onHoverStop:"on",

                            navOffsetHorizontal:0,
                            navOffsetVertical:20,

                            shadow:0,
                            fullWidth:"on",

                            stopLoop:"off",
                            stopAfterLoops:-1,
                            stopAtSlide:-1,

                            shuffle:"off"
                        });

            }); //ready
        </script> 
        <script type="text/javascript" src="<?php echo $STYLE_FILES_SRC;?>/assets/js/tabslide.js"></script> 
        <script type="text/javascript" src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.cookie.js"></script>
        <script type="text/javascript">
            jQuery.noConflict()(function($) {
                var $items = $('#vtab>ul>li>span');
                $items.mouseover(function() {
                    $items.removeClass('selected');
                    $(this).addClass('selected');

                    var index = $items.index($(this));
                    $('#vtab>div').hide().eq(index).show();
                }).eq(0).mouseover();
            });
        </script>
        <script type="text/javascript">
            var SITE_LOC_PATH        = '<?php echo $SITE_LOC_PATH;?>';
            var SITE_LOC_DASH_PATH   = '<?php echo $SITE_LOC_PATH.'/dashboard';?>';
            var MEDIA_FILES_SRC      = '<?php echo $MEDIA_FILES_SRC;?>';
            var MEDIA_FILES_ROOT     = '<?php echo $MEDIA_FILES_ROOT;?>';
            var MODULE_PATH          = '<?php echo $SITE_LOC_PATH.'/modules';?>';
            var TMPL_PATH            = '<?php echo $SITE_LOC_PATH.'/templates';?>';
            var PAGETYPE             = '<?php echo $pageType;?>';
            var DTACT                = '<?php echo $dtaction;?>';
                 

            var CaptchaCallback = function() {
                $('.g-recaptcha').each(function(){
                    var el = $(this);
                    grecaptcha.render(el.get(0), {'sitekey' : el.data("sitekey")});
                });  
            };
        </script>
        
        <?php if($pageType=='register'){ ?>
        <script language="javascript">
            //$(function () {
             jQuery.noConflict()(function ($) {    
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>


        <?php } if($dtaction=='contractsign' || $dtaction=='samplecontractsign') {?>
        
                    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.3/angular.min.js"></script>
                    <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.PrintArea.js_4.js"></script>
                    

                    <script type="text/javascript">
                            jQuery.noConflict()
                            (function ($) {
                            var DTACT = '<?php echo $dtaction;?>';
                            $("#signature").jSignature();

                            $('.smtcnt').click(function(e){
                                e.preventDefault();
                                var clickckedBtn = $(this);                               
                                       
                                /*var frm = $(this);
                                var btn = frm.children('button');*/
                                
                                if($("#signature").jSignature('getData', 'native').length == 0) {
                                    alert('Please draw your signature.');
                                }
                                else{
                                    clickckedBtn.addClass('clicked');                                    
                                    //btn.addClass('clicked');

                                    var datapair = $("#signature").jSignature("getData", "image");
                                    
                                    var i = new Image();

                                    img="data:" + datapair[0] + "," + datapair[1];
                                    i.src ="data:" + datapair[0] + "," + datapair[1];

                                    if(DTACT=='samplecontractsign')                                    
    var dataString1 = 'id_contract=<?php echo $smValid['id_contract'];?>&sampleId=<?php echo $smValid['sampleId']?>&SourceForm=signaturesmcont&ajax=1&img='+encodeURIComponent(img);
                                    else
                                        var dataString1 = 'id_contract=<?php echo $validation['id_contract'];?>&SourceForm=signaturecont&ajax=1&img='+encodeURIComponent(img);
                                    
                                    $.ajax({
                                        type: "POST",
                                        url: MODULE_PATH + "/dashboard/action.php",
                                        data: dataString1,
                                        success: function(msg){
                                            //btn.removeClass('clicked');
                                            clickckedBtn.removeClass('clicked');
                                            $("html, body").animate({ scrollTop: 60 }, 600);

                                            $("#modal_after_contract_sign").modal('show');

                                            setTimeout(function(){window.location = SITE_LOC_PATH+"/dashboard";},10000);
                                        }
                                    });
                                }
                            });
                        });

                        function review()
                        {
                            <?php
                            if($helpflag==1)
                            {
                                ?>
                                phone_ch=$("input:radio[name ='RadioGroup1']:checked").val();
                                if(typeof(phone_ch) == "undefined")
                                {
                                    alert('Please select Toll Free (800) or Local Telephone Number ');
                                    return false;
                                }
                                <?php
                            }

                            if($helpflag==2)
                            {
                                ?>
                                phone_ch=$("input:radio[name ='RadioGroup2']:checked").val();
                                if(typeof(phone_ch) == "undefined")
                                {
                                    alert('Please select Toll Free (800) or Local Telephone Number ');
                                    return false;
                                }
                                <?php
                            }
                            ?>
                            $("html, body").animate({ scrollTop: 0 }, 600);
                            $(".loader").show();

                            html2canvas($("#first"), {
                                onrendered: function(canvas) {
                                    img = canvas.toDataURL("image/png");
                                    $("#first").hide();
                                    $(".but").hide();
                                    $("#sec").show();		  
                                    $("#small").html('<img id="prn" src="'+img+'" width="100%">');
                                    $(".loader").hide();
                                }
                            });
                        }
                        function backshow()
                        {
                            $("html, body").animate({ scrollTop: 0 }, 600);
                            $(".loader").show();
                            $("#sec").hide();	
                            $("#first").show();
                            $(".but").show();
                            $(".loader").hide();
                            $("#signature2").html('');
                            /*contract=$("#first").html();
                            //alert(contract);
                            $("#first").hide();
                            //$("#sec").show();
                            $("#small").add(contract);*/
                            /*var datapair = $("#signature").jSignature("getData", "image");
                            var i = new Image();*/
                            //img = "data:" + datapair[0] + "," + datapair[1];
                            //img="data:" + datapair[0] + "," + datapair[1];
                            // i.src ="data:" + datapair[0] + "," + datapair[1];
                            //$(i).appendTo($("#signature"));
                            //return false;
                            //$("<img class='imported'></img>").attr("src",$("#signature").jSignature('getData', 'base30')).appendTo("#signature");
                        }
                        function printscr()
                        {
                            //alert('dsadsa');
                            var datapair = $("#signature").jSignature("getData", "image");
                            var i = new Image();
                            //img = "data:" + datapair[0] + "," + datapair[1];
                            img="data:" + datapair[0] + "," + datapair[1];
                            i.src ="data:" + datapair[0] + "," + datapair[1];
                            $(i).appendTo($("#signature2"));		
                            $('#first').printArea();
                            return false;
                            /*$("#first").printThis({
                                printContainer: false,
                                importCSS:true,
                                pageTitle: 'test',
                                debug: false,
                                printDelay: 333,
                                header: null,				
                            });*/
                            /*var doc = new jsPDF();
                            var specialElementHandlers = {
                                '#editor': function (element, renderer) {
                                    return true;
                                }
                            };*/

                            //opt = { pagesplit: true };
                            /*doc.fromHTML($('#first').html(), 15, 15,{
                                'width': 170,
                                'elementHandlers': specialElementHandlers
                            });
                            doc.save('sample-file.pdf');*/
                        }

                        function senduser()
                        {
                            var phone_ch;
                            <?php
                            if($helpflag==1)
                            {
                                ?>
                                phone_ch=$("input:radio[name ='RadioGroup1']:checked").val();
                                <?php
                            }

                            if($helpflag==2)
                            {
                                ?>
                                phone_ch=$("input:radio[name ='RadioGroup2']:checked").val();
                                <?php
                            }
                            ?>		

                            var datapair = $("#signature").jSignature("getData", "image");
                            var i = new Image();
                            //img = "data:" + datapair[0] + "," + datapair[1];
                            imgsig="data:" + datapair[0] + "," + datapair[1];

                            $(".loader").show();

                            var dataString1 = 'id_contract=<?php echo $data[id_contract];?>&func=sendcontracttouser&img='+encodeURIComponent(imgsig)+'&phone_ch='+phone_ch;

                            $.ajax({
                                type: "POST",
                                url: "funcAjax.php",
                                data: dataString1,
                                success: function(msg){	
                                    $("html, body").animate({ scrollTop: 0 }, 600);

                                    $(".loader").hide();
                                    $("#alertcontract").show();
                                    $("#alertcontract").html('Sent');
                                    setTimeout(function(){$("#alertcontract").hide();},2000);
                                }
                            });
                        }

                        function finish()
                        {
                            $(this).addClass('clicked');
                            var datapair = $("#signature").jSignature("getData", "image");



                            var i = new Image();
                            //img = "data:" + datapair[0] + "," + datapair[1];
                            img="data:" + datapair[0] + "," + datapair[1];
                            i.src ="data:" + datapair[0] + "," + datapair[1];
                            //$(i).appendTo($("#signature"));
                            //return false;
                            var dataString1 = 'id_contract=<?php echo $data[id_contract];?>&func=signaturecont&img='+encodeURIComponent(img)+'&phone_ch='+phone_ch;

                            /*$.ajax({
                                type: "POST",
                                url: "funcAjax.php",
                                data: dataString1,
                                success: function(msg){	
                                    $("html, body").animate({ scrollTop: 0 }, 600);
                                    $("#alertcontract").show();
                                    setTimeout(function(){window.location = "login.php";},2000);
                                }
                            });*/

                            //$("<img class='imported'></img>").attr("src",$("#signature").jSignature('getData', 'base30')).appendTo("#signature");
                        }	
                    </script> 

        <?php } if($_SESSION['FUSERLOGIN']=='ok' && $pageType=='dashboard') {?>
            <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <?php } ?>
        <script type="text/javascript" src="<?php echo $STYLE_FILES_SRC;?>/js/custom.js"></script>
    </body>        
</html>
    <?php
}
?>