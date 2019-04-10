<?php
if($id!='')
{
    $cObj = new Contact;
    $idToDelete = explode("@", $id);
    foreach($idToDelete as $val)
    {
        $cObj->deleteContactByid($val);
    }
}
$decodedStr = base64_decode($redstr);

?>
<script language="javascript">
window.location = 'index.php?<?php echo $decodedStr?>';
</script>