<?php
$_SESSION['msgBody'] = '#~#MailBody#~#';
$_SESSION['emailTemplate'] = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:6px solid #e9e9e9; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#666;">
    <tr>
        <td align="center" style="border-top:2px solid #8acb71; padding:10px 20px 20px 20px;text-transform: uppercase; font-weight: bold;font-size: 17px;">
            <a href="'.$SITE_LOC_PATH.'"><img src="'.$STYLE_FILES_SRC.'/assets/images/logo.png" alt="'.SITE_NAME.'"></a>
		</td>
    </tr>
    <tr>
        <td style=" padding:30px; background-color:#e9e9e9; background-image: -webkit-gradient(linear, left top, left bottom, from(#e9e9e9), to(#ffffff)); background-image: -webkit-linear-gradient(top, #e9e9e9, #ffffff); background-image:-moz-linear-gradient(top, #e9e9e9, #ffffff); background-image:-o-linear-gradient(top, #e9e9e9, #ffffff); background-image:linear-gradient(to bottom, #e9e9e9, #ffffff);">
        <table>'.$_SESSION['msgBody'].'</table>
		</td>
    </tr>
    <tr>
    	<td align="center" style="border-top:2px solid #8acb71; padding:5px">'.COPY_RIGHT.' <a href="'.$SITE_LOC_PATH.'" style="color:#8acb71;">'.SITE_NAME.'</a></td>
    </tr>
</table>';
?>