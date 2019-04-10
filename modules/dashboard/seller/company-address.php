<div class="h-box-100">
    <div class="h-heading">Address Book</div>

    <div class="h-table">  
        <?php echo $eObj->readcompanyaddress($_SESSION['FUSERID'], 0, 30);?>  
        <div id="succ" class="col-md-12 alert alert-success" style="display:none"></div>
        <div id="prev" class="margintop30"></div>
    </div><!-- col-md-9 -->  
    
</div><!-- end row -->

<div class="clear"></div>
<div id="sadrzaj"></div>