<?php
if($_POST['ajax']=='1') 
    include ('../../../../ext_include.php');
    
	$obj    = new MemberAdmin;   
    $params                  = array();
    $params['book_status']   = $_REQUEST['bid'];
    $obj->bookingUpdateById($params, $_REQUEST['bst']);
    echo $ErrMsg = '<div class="success">Data updated successfully</div>';
?>