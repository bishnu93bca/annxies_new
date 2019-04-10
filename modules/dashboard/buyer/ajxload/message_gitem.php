<?php
$thread     = $eObj -> chatMessages($_SESSION['FUSERID'], $fData['groupId'], 1, $start, $limit);

if($thread){
    foreach($thread as $ct){
        if($ct['profilePic']!='')
            $ctdp = $MEDIA_FILES_SRC.'/member/thumb/'.$ct['profilePic'];
        else{
            if($ct['gender']=='Male')
                $ctdp = $STYLE_FILES_SRC.'/images/male.png';
            else
                $ctdp = $STYLE_FILES_SRC.'/images/female.png';
        }
        
        if($ct['chatType']=='attachment')
            $extraAttr = 'data-track="'.saltCrypt($ct['chatId']).'" data-room="group" data-page="attachment-download"';
        else
            $extraAttr = '';
        
        if($ct['publicId'] == $_SESSION['PUBLICID'])
            echo '<li class="me"><figure class="profilePic" title="'.$ct['fullname'].'"><span class="grp_dp" style="background-image: url('.$ctdp.')"></span></figure><div class="msg"><div class="msgbody '.$ct['chatType'].'" '.$extraAttr.'>'.$ct['chat'].'</div></div></li>';
        else
            echo '<li class="myfrnd"><figure class="profilePic" title="'.$ct['fullname'].'"><span class="grp_dp" style="background-image: url('.$ctdp.')"></span></figure><div class="msg"><div class="msgbody '.$ct['chatType'].'" '.$extraAttr.'>'.$ct['chat'].'</div></div></li>';
    }
}
?>