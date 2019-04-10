<?php
$friendData  = $eObj->getMyChatGroups("cm.chat IS NOT NULL", $_SESSION['FUSERID'], 0, 6);
if($friendData){
    $jsonData[] = array();
    foreach($friendData as $key => $msg){
        if($msg['isPrivate'] == '1'){
            if($msg['publicId'] == $_SESSION['PUBLICID']){
                
                $pvtMem = $eObj->privateChatGroupMember($msg['groupId'], $_SESSION['FUSERID']);
                
                if($pvtMem['profilePic'])
                    $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$pvtMem['profilePic'];
                else{
                    if($pvtMem['gender'] == 'Male')
                        $dp = $SITE_LOC_PATH.'/templates/images/male.png';
                    else
                        $dp = $SITE_LOC_PATH.'/templates/images/female.png';
                }
                $pageUrl = $SITE_LOC_PATH.'/dashboard/social-media/message/'.$pvtMem['publicId'].'/';
                $cmnname = $pvtMem['fullname'];
                $chthd   = $pvtMem['publicId'];
                $cnv     = 'You: '.$msg['chat'];
            }
            else{
                if($msg['profilePic'])
                    $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$msg['profilePic'];
                else{
                    if($msg['gender'] == 'Male')
                        $dp = $SITE_LOC_PATH.'/templates/images/male.png';
                    else
                        $dp = $SITE_LOC_PATH.'/templates/images/female.png';
                }
                $pageUrl = $SITE_LOC_PATH.'/dashboard/social-media/message/'.$msg['publicId'].'/';
                $cmnname = $msg['fullname'];
                $chthd   = $msg['publicId'];
                $cnv     = $msg['chat'];
            }
            
        }
        else{
            if($msg['groupPic'])
                $dp = $MEDIA_FILES_SRC.'/member/thumb/'.$msg['groupPic'];
            else{
                $dp = $SITE_LOC_PATH.'/templates/images/noimage.png';
            }

            $pageUrl = $SITE_LOC_PATH.'/dashboard/social-media/group/'.$msg['gpublicId'].'/';
            $cmnname = $msg['groupName'];
            $chthd   = $msg['gpublicId'];

            if($msg['publicId'] == $_SESSION['PUBLICID'])
                $cnv    = 'You: '.$msg['chat'];
            else
                $cnv    = $msg['fullname'].': '.$msg['chat'];
        }
        
        $jsonData[$key]['dp']       = $dp;
        $jsonData[$key]['cmnname']  = $cmnname;
        $jsonData[$key]['chthd']    = $chthd;
        $jsonData[$key]['cnv']      = $cnv;
        $jsonData[$key]['chatType'] = $msg['chatType'];
        $jsonData[$key]['pageUrl']  = $pageUrl;
    }
    
    
    echo json_encode($jsonData);
}
?>