<?php
if($page=='editproduct')
    echo $eObj->editproductshow($_SESSION['FUSERID'],$pId,$proType);
elseif ($page == 'viewProduct')
	echo $eObj->viewProductshow($_SESSION['FUSERID']);
elseif($page=='deleteProduct')
    echo $eObj->deleteProductByproductId($pid);
elseif($page == 'previewProduct')
    echo $eObj->proPreview();
elseif($page == 'company')
    echo $eObj->showCompanyCatagory();
elseif($page == 'addproductType')
    echo $eObj->showproductaddType($_SESSION['FUSERID'],$id_company);
elseif($page == 'category')
    include 'category-ajax.php';
// else 
//     echo $eObj->showproductadd($_SESSION['FUSERID'],$cmpid,$proType);
?>

