<!DOCTYPE html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" lang="en-US">
    <head>
        <!--[if IE 7]> <html class="ie7"> <![endif]-->
        <!--[if IE 8]> <html class="ie8"> <![endif]-->
        <!--[if IE 9]> <html class="ie9"> <![endif]-->
        <title><?php echo $TitleofSite;?></title>
        <?php
        if($pageType!='404')
            echo SEO_DATA;	
        if($MetaRobots) 
            echo '<meta name="Robots" content="'.$MetaRobots.'" />';

        if($canonical)
            echo '<link rel="canonical" href="'.$canonical.'" />';
        ?>
        <meta name="keywords" content="<?php echo $MetaKeyOfSite;?>" />
        <meta name="description" content="<?php echo $MetaDescOfSite;?>" />
        <link rel="shortcut icon" href="<?php echo $STYLE_FILES_SRC;?>/images/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        
        <?php if($_SESSION['FUSERLOGIN']=='ok' && $pageType=='dashboard') {?>
            <!-- Bootstrap core CSS -->
            <link href="<?php echo $STYLE_FILES_SRC;?>/user/css/bootstrap.min.css" rel="stylesheet">

            <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">


            <link href="<?php echo $STYLE_FILES_SRC;?>/user/css/custom.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/user/css/responsive.css" rel="stylesheet">

            <link href="<?php echo $STYLE_FILES_SRC;?>/user/css/zafooter.css" rel="stylesheet">        
        <?php }
        else {?>
            <!-- REVOLUTION BANNER CSS SETTINGS -->
            <link rel="stylesheet" type="text/css" href="<?php echo $STYLE_FILES_SRC;?>/rs-plugin/css/responsive.css" media="screen" />
            <link rel="stylesheet" type="text/css" href="<?php echo $STYLE_FILES_SRC;?>/rs-plugin/css/settings.css" media="screen" />
            <link rel="stylesheet" href="<?php echo $STYLE_FILES_SRC;?>/rs-plugin/css/captions.css">

            <!-- Flex Slider CSS -->
            <link rel="stylesheet" href="<?php echo $STYLE_FILES_SRC;?>/flexslider/flexslider.css" type="text/css">

            <!-- Le styles -->
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/bootstrap.css" rel="stylesheet">
            <!--http://eclickapplications.com/websites/annexis/images/assets/css/main.css-->
            <link href="<?php echo $STYLE_FILES_SRC;?>/images/assets/css/main.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/bootstrap-responsive.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/royalslider.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/rs-defaulte166.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/boxed_960.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/docs.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/style.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/options.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/commander.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/nivo/nivo-slider.css" media="screen" rel="stylesheet" type="text/css">
            <link href="<?php echo $STYLE_FILES_SRC;?>/assets/css/prettyPhoto.css" media="screen" rel="stylesheet" type="text/css">

            <link href="http://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C700italic%2C800italic%2C400%2C300%2C600%2C700%2C800&amp;subset=latin%2Ccyrillic-ext%2Cgreek-ext%2Cgreek%2Cvietnamese%2Clatin-ext%2Ccyrillic&amp;ver=3.4.2" id="gOpenSans-css" media="all" rel="stylesheet" type="text/css"/>
			<link href="<?php echo $STYLE_FILES_SRC;?>/css/common.css" rel="stylesheet">
            <!-- Le fav and touch icons -->
        <?php }?>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="<?php echo $STYLE_FILES_SRC;?>/user/js/bootstrap.min.js"></script>
        
        <script src="<?php echo $STYLE_FILES_SRC;?>/js/jquery.tabSlideOut.v1.3-1.js"></script>
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jquery.royalslider.minf76d.js"></script>
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/easyResponsiveTabs.js"></script>
        
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/jSignature.min.js"></script>
        <script src="<?php echo $STYLE_FILES_SRC;?>/assets/js/html2canvas.js"></script>
        <script src="<?php echo $STYLE_FILES_SRC;?>/js/jquery.tagsinput.js"></script>
    </head>
    <?php
    if($dtls!='signpdf')
    {
        ?>
        <body <?php echo ($pageType=='contact-annexis')? 'class="contacth"':'';?>>
    
        <div <?php echo ($pageType=='register')? 'class="wide_cont nobg"': 'class="wide_cont"'?>>
        
            <?php if($_SESSION['FUSERLOGIN']=='ok' && $pageType=='dashboard') {?>
            <nav class="navbar navbar-inverse">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand hidden-xs" href="<?php echo $SITE_LOC_PATH;?>/">
                            <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/logo.png" class="img-responsive">
                        </a>
                    </div>
                    <!--<div id="navbar" class="navbar-collapse collapse">-->
                        <!--<ul class="nav navbar-nav navbar-left">
                            
                            <li><a href="index.html">HOME</a></li>
                            <li><a href="portfolio.html">PORTFOLIO</a></li>
                            <li><a href="contact.html">CONTACT</a></li>
                            
                        </ul>-->
                        <?php if($pageType!='register'){ ?>
                        <ul class="nav navbar-nav navbar_user hidden-xs">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Hi, <?php echo $_SESSION['FUSERNAME'];?></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo $SITE_LOC_PATH;?>/">Visit Website</a></li>
                                    <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/accounts-settings/">Accounts Settings</a></li>   
                                    <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/company/">Company Profile</a></li> 
                                    <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/company-address/">Address Book</a></li>                    
                                    <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/logout/">Logout</a></li>           
                                </ul>
                            </li>   
                        </ul>
                        <?php } ?>
                    <!--</div>-->
                </div>
            </nav>
            <?php } else {?>
            
            
            <!-- START TOP LINE-->
            <div class="top_line">
                <div class="container">
                    <div class="row">
                        <div class="span6"> 
                            <!--<p class="feed">Subscribe to be notified for updates: <a href="http://html.orange-idea.com/feed">RSS Feed</a></p>--> 
                        </div>
                        <div class="span6 soc_icons"> 
                            <?php if($_SESSION['FUSERLOGIN']=='ok') {?>
                                <ul class="nav navbar-nav navbar_user hidden-xs">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Hi, <?php echo $_SESSION['FUSERNAME'];?></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/">My Dashboard</a></li>
                                            <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/accounts-settings/">Accounts Settings</a></li>   
                                            <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/company/">Company Profile</a></li>                    
                                            <li><a href="<?php echo $SITE_DASHBOARD_PATH;?>/logout/">Logout</a></li>          
                                        </ul>
                                    </li>   
                                </ul>
                            <?php } else {?>
                                <a href="<?php echo $SITE_LOC_PATH;?>/membership-packages/compare-packages/" class="tlink">Register</a>
                                <a href="<?php echo $SITE_LOC_PATH;?>/login/" class="tlink">Login</a>
                            <?php }?>

                            <a href="https://plus.google.com/u/0/105981399301260936627/posts" target="_blank">
                                <div class="icon_google"></div>
                            </a> 
                            <a href="https://www.facebook.com/annexisbusinesssolutions?ref=hl" target="_blank">
                                <div class="icon_facebook"></div>
                            </a> 
                            <a href="http://twitter.com/" target="_blank">
                                <div class="icon_t"></div>
                            </a>
                            <span class="phoneno"><img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/phone-iconw.png"> <?php echo SITE_PHONE?></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TOP LINE--> 

            <!--PAGE HEAD-->
            <div class="page_head">
                <div class="container">
                    <div class="row">
                        <div class="span3"> 
                            <!--START LOGO IMAGE-->
                            <div class="logo"> <a href="<?php echo $SITE_LOC_PATH;?>/"> <img src="<?php echo $STYLE_FILES_SRC;?>/assets/images/logo.png"/></a> </div>
                            <!-- END LOGO IMAGE--> 
                        </div>
                        <div class="span9"> 
                            <!-- START MAIN MENU-->
                            <nav>
                                <?php include("topmenu.php");?>
                            </nav>
                        <!-- END MAIN MENU--> 
                        </div>
                    </div>
                </div>
            </div>
            <!--/PAGE HEAD--> 
            <!--WELCOME AREA-->


            <!-- START REVOLUTION SLIDER 2.0.3 -->
            <link rel='stylesheet' id='rev-google-font' href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,600,700,800' type='text/css' media='all' />
            <?php
        }
    }
    ?>