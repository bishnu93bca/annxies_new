<?php 
if($_POST['ajx']==1){
    if($page == 'exam'){
        if($_SESSION['FUSERTYPE']=='Student'){
            if($permalink){
                $crObj     = new CoursesView;
                $course    = $crObj->courseByPermalink($permalink);
                
                if($course){
                    $cnfData = $crObj->quizConfig($course['id'], 0, 3);
                    if($cnfData){
                        ?>
                        <div class="post_form">
                            <div class="sp_box exm_box clearfix">										
                                <figure class="sj_pic">
                                    <a href="<?php echo $SITE_LOC_PATH.'/online-exam/'.$course['permalink'].'/';?>">
                                        <?php        
                                        if($course['courseImage'] && file_exists($MEDIA_FILES_ROOT.'/course/large/'.$course['courseImage']))
                                            echo '<img src="'.$MEDIA_FILES_SRC.'/course/large/'.$course['courseImage'].'"  alt="'.$course['courseName'].'"> ';
                                        else
                                            echo '<img src="images/profileImage.png"  alt="'.$course['courseName'].'"> ';
                                        ?>
                                    </a>
                                </figure>
                                <div class="sj_right">
                                    <div class="subheading"><a href="<?php echo $SITE_LOC_PATH.'/online-exam/'.$course['permalink'].'/';?>"><?php echo $course['courseName'];?></a></div>
                                    <strong class="orange">Note: Once you start exam, please don't refresh this page.</strong>
                                </div>
                                <div class="timer_wrap">
                                    <div class="test_timer">00 : 00</div>
                                </div>
                            </div>
                            
                            <div class="exmpanel">
                                <form id="qppr" method="post" action="">
                                    <div class="paperlst">
                                        <table>
                                            <tr>
                                                <th align="left">Level</th>
                                                <th>Time Limit</th>
                                                <th>Total Quiz</th>
                                                <th>Marks Per Quiz</th>
                                                <th>Total Marks</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php foreach($cnfData as $paper){?>
                                            <tr>
                                                <td><?php echo $paper['quizLevel'];?></td>
                                                <td align="center"><?php echo $paper['quizDuration'];?> Mins.</td>
                                                <td align="center"><?php echo $paper['totalQuiz'];?></td>
                                                <td align="center"><?php echo $paper['marksPerQuiz'];?></td>
                                                <td align="center"><?php echo $paper['totalMarks'];?></td>
                                                <td align="center">
                                                    <label class="radio radio_btn">
                                                        <input name="q1" class="qtype" type="radio" value="<?php echo saltCrypt($paper['configId']);?>">
                                                        <span class="btn strtexm">Start</span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    else
                        echo 'error>Sorry! No question paper available for this course. Please try some other day.';
                }
                else
                    echo 'error>Something went wrong. Please close window and try again.';
            }
            else
                echo 'error>Something went wrong. Please close window and try again.';
        }
    }
    elseif($page == 'cs-connect'){
        if($_SESSION['FUSERTYPE']=='Student'){
            $returnArr['ws']        =  $SOCKET_URI;
            $returnArr['me']        =  $_SESSION['FUSERFULLNAME'];
            $returnArr['publicId']  =  $_SESSION['PUBLICID'];
            $returnArr['myDP']      =  $_SESSION['DPURL'];
            echo json_encode($returnArr);
        }
    }
    elseif($page == 'chat'){
        if($_SESSION['FUSERTYPE']=='Student'){
            //header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            /*header("HTTP/1.x 501 Internal Error", true);*/
            session_write_close();
            
            $lastChatId = saltDecrypt(@$_COOKIE["cht_token"]);

            if (!$lastChatId) 
                $lastChatId = 0;
            
            $newChat = $eObj -> getNewChat($_SESSION['FUSERID'], $lastChatId, 0, 1);
            
            /*if(sizeof($newChat)<1)
                usleep(5000000);*/
            /*while(sizeof($newChat)<1){
                
                usleep(1000000);
                //sleep(1);
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
                
                $lc = saltCrypt($newChat[0]['chatId']);
                setcookie("cht_token", $lc);
            }
            header("HTTP/1.x 200 OK", true);
            echo $chatData;
            flush();
        }
    }
    elseif($page == 'message'){
        $fData      = $eObj -> getMemberByprofileId($track);
        $checkBlock = $eObj -> isBlocked($_SESSION['FUSERID'], $fData['id']);
        
        if(!$checkBlock){
            $friend['member'] = json_encode(array(
                                    'publicId'      => $track, 
                                    'fullname'      => $fData['fullname'], 
                                    'profilePic'    => $fData['profilePic'], 
                                    'gender'        => $fData['gender']
                                ));
            
            $friend['thread'] = $eObj -> chatIndividual($_SESSION['FUSERID'], $fData['id'], 1, 0, 30);
            
            echo json_encode($friend);
        }
        else
            echo "error>Blocked";
    }
    elseif($page == 'doc-download'){
        $smObj      = new StudyMaterialsView();
        $fileId     = saltDecrypt($track);
        $fData      = $smObj->getFileByfileId($fileId);
        
        if($fData){
            if($fData['status']=='A' || $fData['memberId']==$_SESSION['FUSERID']){
                if($fData['docFile'] && file_exists($MEDIA_FILES_ROOT.'/docs/'.$fData['docFile'])){
                    
                    $_SESSION['FlToDl']     = $fData['docFile'];
                    $_SESSION['fpath']      = $MEDIA_FILES_ROOT.'/docs/';

                    if($_SESSION['FUSERID'] != $fData['memberId']) {
                        $params = array();
                        $params['downloadCount'] = $fData['downloadCount']+1;
                        $smObj->updateStudyMaterial($params, $fileId);
                    }

                    echo 'success';
                }
                else
                    echo "error>Sorry! File does not exist.";
            }
            else
                echo "error>File can't be downloaded.";
        }
        else
            echo 'error>Something went wrong.';
    }
    elseif($page == 'brochure-download'){
        $iObj      = new InstitutionView();
        $fData      = $iObj->getInstitutionsInfoBypermalink($_SESSION['FUSERID'], $track);
        
        if($fData){

            if($fData['brochure'] && file_exists($MEDIA_FILES_ROOT.'/institutions/pdf/'.$fData['brochure'])){

                $_SESSION['FlToDl']     = $fData['brochure'];
                $_SESSION['fpath']      = $MEDIA_FILES_ROOT.'/institutions/pdf/';

                $params                     = array();
                $params['downloadCount']    = $fData['downloadCount']+1;
                
                $iObj->updateInstitute($params, $fData['id']);

                echo 'success';
            }
            else
                echo "error>Sorry! File does not exist.";
            
        }
        else
            echo 'error>Something went wrong.';
    }
    elseif($page == 'cv-download'){
        if($_SESSION['FUSERTYPE']=='Recruiter'){
            $eObj      = new MemberView();
            $track     = saltDecrypt($track);
            $fData     = $eObj -> viewApplication($_SESSION['FUSERID'], $track);

            if($fData){

                if($fData['cv'] && file_exists($MEDIA_FILES_ROOT.'/cv/'.$fData['cv'])){

                    $_SESSION['FlToDl']     = $fData['cv'];
                    $_SESSION['fpath']      = $MEDIA_FILES_ROOT.'/cv/';
                    
                    echo 'success';
                }
                else
                    echo "error>Sorry! File does not exist.";

            }
            else
                echo 'error>Something went wrong. Please close window and try again.';
        }
        else
            echo 'error>Something went wrong. Please close window and try again.';
    }
    elseif($page == 'browse'){
        include($ROOT_PATH."/modules/dashboard/student/ajxload/browse_pic.php");
    }
    elseif($page == 'job-apply'){
        include($ROOT_PATH."/modules/dashboard/student/ajxload/job_apply.php");
    }
    elseif($tab){
        if($page == 'study-material')
            $_SESSION['STUDY_TAB'] = $tab;
        elseif($page == 'social-media')
            $_SESSION['SOCIAL_TAB'] = $tab;
        elseif($page == 'my-favourites')
            $_SESSION['FAVOURITE_TAB'] = $tab;
        
        $ldfile                 = $tab.'.php';
        include($ROOT_PATH."/modules/dashboard/student/ajxload/".$ldfile);
    }
}
elseif($dtaction=='friend-requests'){
    include($ROOT_PATH."/modules/dashboard/student/ajxload/friend_requests.php");
}
elseif($dtaction=='search-member'){
    if($srchtxt){
        $srchtxt        = addslashes(trim($srchtxt));
        $ExtraQryStr    = " (m.fullname like '%".$srchtxt."%' or m.email like '%".$srchtxt."%' or m.address like '%".$srchtxt."%') ";
        
        $recSet         = $eObj->searchMemberList($_SESSION['FUSERID'], $ExtraQryStr, 0, 30);
        
        echo json_encode($recSet);
    }
}
?>