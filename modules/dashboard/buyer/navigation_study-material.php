<div class="social_nav">
    <ul class="clearfix">
        <li <?php echo (!$_SESSION['STUDY_TAB'] || $_SESSION['STUDY_TAB']=='approved_docs')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/study-material/';?>" data-page="study-material" data-tab="study-material"><i class="fa fa-check"></i> Approved Documents</a>
        </li>
        
        <li <?php echo ($dtaction=='uploaded-documents' || $_SESSION['STUDY_TAB']=='uploaded-documents')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/study-material/uploaded-documents/';?>" data-page="study-material" data-tab="uploaded-documents"><i class="fa fa-cloud-upload"></i> Uploaded Documents</a>
        </li>
        <li <?php echo ($dtaction=='upload-document' || $_SESSION['STUDY_TAB']=='upload-document')? 'class="selected"':'';?>>
            <a href="<?php echo $SITE_DASHBOARD_PATH.'/study-material/upload-document';?>" data-page="study-material" data-tab="upload-document"><i class="fa fa-upload"></i> Upload Document</a>
        </li>
    </ul>
</div>