<?php
header("HTTP/1.x 501 Internal Error", true);
include("include.php");
//ini_set('display_errors',1); error_reporting(E_ALL);
if($_SESSION['FUSERTYPE']=='Student'){
    
    $lastChatId = saltDecrypt(@$_COOKIE["cht_token"]);

    if (!$lastChatId) 
        $lastChatId = 0;
    $eObj = new MemberView;
    $newChat = $eObj -> getNewChat($_SESSION['FUSERID'], $lastChatId, 0, 1);

    
    /*while(sizeof($newChat)<1){
        usleep(5000000);
        $newChat = $eObj -> getNewChat($_SESSION['FUSERID'], $lastChatId, 0, 1);
    }*/
    

    if($newChat){
        $lastChatId = $newChat[0]['chatId']; 

        if($newChat[0]['profilePic'] && file_exists($MEDIA_FILES_ROOT.'/member/thumb/'.$newChat[0]['profilePic']))
            $chatWithDP = $MEDIA_FILES_SRC.'/member/thumb/'.$newChat[0]['profilePic'];
        else{
            if($newChat[0]['gender']=='Female')
                $chatWithDP = $STYLE_FILES_SRC.'/images/female.png';
            else
                $chatWithDP = $STYLE_FILES_SRC.'/images/male.png';
        }

        $chatData  = json_encode(array(
            'type'      => 'ncht', 
            'fullname'  => $newChat[0]['fullname'],
            'publicId'  => $newChat[0]['publicId'],
            'dp'        => $chatWithDP,
            'chat'      => $newChat[0]['chat'],
            'ts'        => 0
        ));
    }
    
    $lc = saltCrypt($lastChatId);
    setcookie("cht_token", $lc);
    
    echo sizeof($newChat);
    
    header("HTTP/1.x 200 OK", true);
    echo $chatData;
}