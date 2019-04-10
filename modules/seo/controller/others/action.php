<?php
/*************************************************************************************************
Add / Edit Other Section Started
*************************************************************************************************/
if(isset($Save) && $SourceForm == 'Other')
{		
    if($IdToEdit!='')
    {
        $obj = new PageTitle;
        $params = array();
        $params['seoData']          = $seoData;
        $params['googleAnalytics']  = $googleAnalytics;
        $params['tagManager']       = $tagManager;
        $obj->siteUpdateById($params, $IdToEdit);

        $ErrMsg = '<div class="success">Data Updated Successfully</div>';

        if($_FILES['RobotFile']['name'])	
        {		
            $extension_lg_array = pathinfo($_FILES['RobotFile']['name']);
            if($extension_lg_array['basename'])
                $extension_lg = strtolower($extension_lg_array['extension']);
            if($extension_lg=='txt'){
                $RobotFileName = $_FILES['RobotFile']['name'];
                $target_path_robot = $ROOT_PATH.'/'.$RobotFileName;
                if(file_exists($target_path_robot))
                {
                    @unlink($target_path_robot);
                }
                @move_uploaded_file($_FILES['RobotFile']['tmp_name'], $target_path_robot);
            }
            else
                $ErrMsg .= '<div class="error">Invalid file type!</div>';
        }

        if($_FILES['SiteMapFile']['name'])	
        {
            $extension_lg_array = pathinfo($_FILES['SiteMapFile']['name']);
            if($extension_lg_array['basename'])
                $extension_lg = strtolower($extension_lg_array['extension']);
            if($extension_lg=='xml'){
                $SiteMapFileName = $_FILES['SiteMapFile']['name'];
                $target_path_SiteMapt = $ROOT_PATH.'/'.$SiteMapFileName;
                if(file_exists($target_path_SiteMapt))
                {
                    @unlink($target_path_SiteMapt);
                }
                @move_uploaded_file($_FILES['SiteMapFile']['tmp_name'], $target_path_SiteMapt);	
            }
            else
                $ErrMsg .= '<div class="error">Invalid sitemap file!</div>';
        }       
    }
}
/*************************************************************************************************
Add / Edit Other Section Ended
*************************************************************************************************/
?>