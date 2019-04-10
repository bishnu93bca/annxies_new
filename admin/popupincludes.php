<?php
$SYSTEM_PATH ='http://'.$_SERVER['HTTP_HOST'];

$ROOT_PATH =$_SERVER['DOCUMENT_ROOT'];

require_once("../../../include.php");

include_once("../../../ckeditor/ckeditor.php");

require_once("modulemanagement/modules/class/module.class.php");



while(list($key,$val)=each($_REQUEST))
	$$key = trim(stripslashes($val));

?>
<link rel="stylesheet" type="text/css" href="../../css/style.css"/>
<?php /*?><script type="text/javascript">	
	redirPath = '<?php echo $_SESSION['currentPageUri'];?>';
	console.log(redirPath);
</script>
<?php */?>