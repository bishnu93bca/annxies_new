<?php
require_once("../lib/includes/pages_admin.php");
$rqs = explode('&redstr=', $_SERVER['QUERY_STRING']);
$redirectString = base64_encode($rqs[0]);
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo SITE_NAME;?> :: Admin Console</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="<?php echo $STYLE_FILES_SRC;?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/responsive.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/liteaccordion.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">  
    
    
	<script src="js/libs/modernizr-2.5-respond-1.1.0.min.js"></script>
	<script src="js/libs/jquery-1.7.1.min.js"></script>
    
    <script type="text/javascript" src="uploadify/js/jquery.uploadify.js"></script>
	<?php 
    if($_SESSION['UTYPE']=="A") 
	{
		if($dtaction=='modulepermissions' || ($pageType=='usermanagement' && $step==2) || ($pageType=="sitepage" && $dtaction=="new")) 
		{
			?>
            <!--Jquery TreeView-->
            <link rel="stylesheet" href="css/jquery.treeview.css" />
            <script src="js/jquery.cookie.js" type="text/javascript"></script>
            <script src="js/jquery.treeview.js" type="text/javascript"></script>
            <script type="text/javascript" src="js/demo.js"></script>
            <!--Jquery TreeView-->
            <?php 
		}
	}
	else 
	{
		?>
		<!--///*ask to delete*/-->
		<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.ask').jConfirmAction();
			});
		</script>
		<?php 
	}?>
	<script src="js/ajax.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/libs/queryLoader.js"></script>
    <script type="text/javascript" src="js/libs/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="js/libs/jquery.mCustomScrollbar.min.js"></script>
    <script type="text/javascript" src="js/libs/jquery.mousewheel.min.js"></script>
    <script type="text/ecmascript" src="js/libs/liteaccordion.jquery.min.js"></script>
    <script type="text/javascript">
    	$(function(){
			$('#one').liteAccordion({
					onTriggerSlide : function() {
					},
					onSlideAnimComplete : function() {  
					},	
					autoPlay : false,	
					pauseOnHover : true,	
					theme : '',	
					rounded : false,	
					enumerateSlides : true  
				}).find('div').show();
			});
			/*
			window.addEventListener('DOMContentLoaded',function() {
				$("body").queryLoader2({
					barColor: "#6e6d73",
					backgroundColor: "#fff1b0",
					percentage: true,
					barHeight: 30,
					completeAnimation: "grow"
				});
			});
			*/
	</script>
    <script type="text/javascript">
        $(function(){
            $('#one').liteAccordion({
                onTriggerSlide : function() {
                this.find('figcaption').fadeOut();
            },
            onSlideAnimComplete : function() {
                    this.find('figcaption').fadeIn();
                },
                autoPlay : false,
                pauseOnHover : true,
                theme : '',
                rounded : false,
                enumerateSlides : true
            }).find('figcaption:first').show(); 
        })
    </script>
<script src="js/script.js"></script>
<!--------pretty photo css and js------>
<link type="text/css" href="css/prettyPhoto.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<!--------pretty photo css and js------>
<script src="js/jquery.tagsinput.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<style>
#preview{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
}
</style>
<!--hover large image-->
<script src="js/jquery.easytabs.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/tab.css"/>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!--<script type="text/javascript">
    $(document).ready( function() {
    	$('#tab-container').easytabs();
		$( "#datepicker" ).datepicker({
		  	changeMonth: true,
		  	changeYear: true,
			dateFormat: 'yy-mm-dd'
		});

		$( ".datepicker" ).datepicker({
		  	changeMonth: true,
		  	changeYear: true,
			dateFormat: 'yy-mm-dd'
		});
    });
</script>-->
<!---------------------DatePicker------------------------------>
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<!---------------------DatePicker------------------------------>

<!--DIV SWAP SECTION START-->
    
    <?php
	if($pageType=='productmanagement' && $dtls=='product' && $dtaction=='')
	{
		?>
        <style type="text/css">
		.table li {
			cursor: move;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){ 								   
			$(function() {
				$(".table ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&action=proSwap'; 
					$.post("includes/updateDB.php", order, function(theResponse){
						$("#main").html(theResponse);
					}); 															 
				}								  
				});
			});		
		});	
		</script>
        <?php
	}
	elseif($pageType=='content' && $dtaction=='')
	{
		?>
        <style type="text/css">
		.table li {
			cursor: move;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){ 								   
			$(function() {
				$(".table ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
						var order = $(this).sortable("serialize") + '&action=contentswap&editid=<?php echo $editid;?>'; 
						$.post("includes/updateDB.php", order, function(theResponse){
							$("#main").html(theResponse);
						}); 															 
					}								  
				});
			});		
		});	
		</script>
        <?php
	}	
	elseif($pageType=='sitepage' && $dtaction=='' && $parentId=='')
	{
		?>
        <style type="text/css">
		.table li {
			cursor: move;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){ 								   
			$(function() {
				$(".table ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
						var order = $(this).sortable("serialize") + '&action=siteswap'; 
						$.post("includes/updateDB.php", order, function(theResponse){
							$("#main").html(theResponse);
						}); 															 
					}								  
				});
			});		
		});	
		</script>
        <?php
	}
	elseif($pageType=='sitepage' && $parentId!='')
	{
		?>
        <style type="text/css">
		.table li {
			cursor: move;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){								   
			$(function() {
				$(".table ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&action=sitesubswap'; 
					$.post("includes/updateDB.php", order, function(theResponse){
						$("#main").html(theResponse);
					}); 															 
				}								  
				});
			});		
		});	
		</script>
        <?php
	}		
	elseif($pageType=='banner' && $dtls=='homeheader' && $dtaction=='')
	{
		?>
        <style type="text/css">
		.table li {
			cursor: move;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){ 								   
			$(function() {
				$("#header_banner").sortable({ opacity: 0.6, cursor: 'move', update: function() {
						var order = $(this).sortable("serialize") + '&action=photo'; 
						$.post("includes/updateDB.php", order, function(theResponse){
							$("#main").html(theResponse);
						}); 															 
					}
				});
			});		
		});	
		</script>
        <?php
	}	
	elseif($pageType=='photogallery' && $dtls=='photogallerylist' && $dtaction=='')
	{
		?>
        <style type="text/css">
		.table li {
			cursor: move;
		}
		</style>
		<script type="text/javascript">
		$(document).ready(function(){ 								   
			$(function() {
				$(".table ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
					var order = $(this).sortable("serialize") + '&action=photogallery'; 
					$.post("includes/updateDB.php", order, function(theResponse){
						$("#main").html(theResponse);
					}); 															 
				}								  
				});
			});		
		});	
		</script>
        <?php
	}	
	?>
	<!--DIV SWAP SECTION END-->
	
    <script type="text/javascript">
		function addRow(tableID) {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			var colCount = table.rows[0].cells.length;
			for(var i=0; i<colCount; i++) {
				var newcell = row.insertCell(i);
				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
				}
			}
		}
		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length; 
			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Cannot delete all the rows.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}
			}
			}catch(e) {
				alert(e);
			}
		}
		$(document).ready(function(){	
			<!--MULTI ACTION SECTION START-->
			// add multiple select / deselect functionality
			$(".selectall").click(function () {
				  $('.case').attr('checked', this.checked);
			});
		 
			// if all checkbox are selected, check the selectall checkbox
			// and viceversa
			$(".case").click(function(){		 
				if($(".case").length == $(".case:checked").length) {
					$(".selectall").attr("checked", "checked");
				} else {
					$(".selectall").removeAttr("checked");
				}		 
			});
					
			$('.multi_action').change(function(){
				var actionType = $(this).val();
				if(actionType){
					var id=''; 	
					<?php
					if($pageType=='sitepage')
					{
						?>
						var actionFile = '<?php echo '../modules/'.$pageType.'/controller/ajax_action.php';?>'; 
						<?php
					}
					else
					{
						?>
						var actionFile = '<?php echo '../modules/'.$pageType.'/controller/'.$dtls.'/ajax_action.php';?>'; 
						<?php
					}
					?>
					$("input:checkbox[name=selectMulti]:checked").each(function() {
						   id=id+$(this).val()+'@';
					});
					if(id){	
						if (confirm("Are you sure?") == true) {
							$.ajax({
								url:actionFile,	
								type:'post',
								data:{'id':id,'action':actionType,'ajax':1},	
								success: function(data) {
									/*if($('.errmsg').length)
										$('.errmsg').html(data);
									else*/
										location.reload();
								}						
							});	
						}
						else
							$('.multi_action option:eq(0)').prop('selected', true);
					}
					else
					{
						alert("No record selected!");	
						$('.multi_action option:eq(0)').prop('selected', true);
					}
				}				
			});
			<!--MULTI ACTION SECTION END-->
			
			<!--GENERATE PASSWORD ACTION SECTION START-->
			$(".generate").click(function(e){
				e.preventDefault();
				var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
				var string_length = 8;
				var randomstring = '';
				for (var i=0; i<string_length; i++) {
					var rnum = Math.floor(Math.random() * chars.length);
					randomstring += chars.substring(rnum,rnum+1);
				}
				$('.gen_pass').val(randomstring);
				$('.new_pass').fadeIn(400);	
				$('.new_pass > input[type=text]').val(randomstring);
			});	
			<!--GENERATE PASSWORD ACTION SECTION END-->
			
			<!--GENERATE PERMALINK ACTION SECTION START-->
			$('.permalink').keyup(function(){
				var IdToEdit = $(this).data('id');
				var	parentId = $(this).data('parent');
				var	ENTITY = $(this).data('entity');
				var	permalink = $(this).val();
				$.ajax({
					url:'includes/ajax_permalink.php',
                    type:'post',
					data:{'ajax':1, 'permalink':permalink,'IdToEdit':IdToEdit,'parentId':parentId,'ENTITY':ENTITY},
					success:function(output){
						$('.gen_permalink').val(output);
					}
				});
			});
			$('.gen_permalink').bind('keypress', function (e) {
				if ($(this).val().length == 0) {					
					var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122);
					if (!valid) {
						e.preventDefault();
					}
				} else {
					var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122 || e.which == 45 || e.which == 95 || e.which == 8);
					if (!valid) {
						e.preventDefault();
					}
				}
			});			
			<!--GENERATE PERMALINK ACTION SECTION END-->
		});
	</script>   
</head>
<body>
<div class="res_overlay">
	<div class="res_click"></div>
	<div class="responsive_nav"></div>
</div>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<div id="container">	