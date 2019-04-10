<?php
if($id!='')
{    
    $obj    = new Contact;
    $pobj   = new adminProductClass;
    $ExtraQryStr = 'contactId='.addslashes($id);
    $pAttr  = $pobj->getReqAttributeByproductId($ExtraQryStr, $pid, 0, 99999);
    if($pAttr){
        foreach($pAttr as $pAtr){
            $pobj->deletereqproductAttr($pAtr['proAttrId']);
        }
    }
    $obj->deleteContactByid($id);
}
$decodedStr = base64_decode($redstr);
?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>
