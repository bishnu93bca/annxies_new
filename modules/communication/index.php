<?php
$conObj          = new ContentView();
$mObj            = new MemberView();	
$contentData     = $conObj->getContentBycontentID(1);
$contentData2    = $conObj->getContentBycontentID(2);
$contentData3    = $conObj->getContentBycontentID(3);
$contentData4    = $conObj->getContentBycontentID(4);
?>
<div class="tag_line">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="welcome"> 
                    <h2><strong class="colored">ANNEXIS:- </strong> Business presence virtually anywhere in the world</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main_content_area">
    <div class="container">
        <div class="row">
            <div class="span12 mrgbtm35">
                <!-- GOOGLE MAP -->
                <div class="row-fluid mrgbtm35 gmap" style="margin-bottom:20px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3582.52812485643!2d-80.141755!3d26.114317999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9005868c4f8e3%3A0x944a171f7700a9ab!2sEmpire+Executive+Offices!5e0!3m2!1sen!2s!4v1431883028939" width="100%" height="450" frameborder="0" style="border:0"></iframe>
                </div>
                <div class="row-fluid">
                    <div class="span8">
                        <div class="h-h2">Feel free to contact us</div>
                        <div id="note"></div>
                            <div id="fields">
                                <form name="" method="post" id="contactBtn">
                                    <input type="text" id="name" name="name" class="span6" placeholder="Name"/>
                                    <br/>
                                    <input id="email" type="text" class="span6" name="email" placeholder="Email"/>
                                    <br/>
                                    <input id="phone" type="text" class="span6" name="phone" placeholder="Phone"/>
                                    <br/>
                                    
                                    <select id="state_office" name="state_office" class="span6">
                                        <?php echo $mObj->readstate();?>
                                    </select>
                                    <br/>
                                    <select id="city_office" name="city_office" class="span6">
                                        <?php echo $mObj->readoffice();?>
                                    </select>
                                    <br/>
                                    <select id="office_name" name="office_name" class="span6">
                                        <?php echo $mObj->readofficename();?>
                                    </select>
                                    <br/>
                                    <select name="productOfIn" id="productOfIn" class="span6">
                                        <option value="">Select Product of interested</option>
                                        <option value="Business directory">Business directory</option>
                                        <option value="Phone Number / Virtual Address">Phone Number / Virtual Address</option>
                                        <option value="Mail Handling and Delivery">Mail Handling and Delivery</option>
                                        <option value="Client Samples and Distribution">Services</option>
                                        <option value="Office Space">Office Space</option>
                                        <option value="Receptionist Services">Receptionist Services</option>
                                        <option value="Website">Duplication in US</option>
                                    </select>
                                    <textarea id="message" class="span11" type="text" name="contactComments" placeholder="Message" rows="8"></textarea>
                                    <br/>
                                      <button type="submit" class="btn">Send message</button>
                                    <br/>
                                    <div>
                                    <input type="hidden" value="contactUs" name="SourceForm">
                                    <input type="hidden" value="1" name="ajax">
                                    </div>
                                    <div class="errMsg clearfix"></div>
                                </form>
                                <br/>
                            </div>
                    </div>
                    <div class="span4">
                        <div class="row-fluid">
                            <div class="span12">
                                <?php 
                                echo ($contentData['displayHeading']=='Y')? '<div class="h-h2">'.$contentData['contentHeading'].'</div>':'';
                                
                                echo $contentData['contentDescription'];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="row">
                <?php if($contentData2) { ?> 
                    <div class="span4">
                        <div class="box-whites contntDesc">
                            <?php
                             echo ($contentData2['displayHeading']=='Y')? '<div class="h-h2">'.$contentData2['contentHeading'].'</div>':'';
                             echo $contentData2['contentDescription'];
                            ?>
                        </div>
                    </div>
                <?php } if($contentData3){ ?>
                
                <div class="span4">
                    <div class="box-whites contntDesc">
                        <?php
                        echo ($contentData3['displayHeading']=='Y')? '<div class="h-h2">'.$contentData3['contentHeading'].'</div>':'';
                        echo $contentData3['contentDescription'];
                        ?>
                    </div>
                </div>
                <?php } if($contentData4){ ?>
                <div class="span4">
                    <div class="box-whites contntDesc">
                        <?php
                        echo ($contentData4['displayHeading']=='Y')? '<div class="h-h2">'.$contentData4['contentHeading'].'</div>':'';
                        echo $contentData4['contentDescription'];
                        ?>
                    </div>
                </div>
                <?php }?>
            </div>
                <div class="clr"></div>

            </div>
        </div>
    </div>
</div>