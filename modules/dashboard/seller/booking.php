<?php
$planData = $eObj->get_general_info($_SESSION['FUSERID']);
$item = $eObj->getavoffice();
?>


<!-------------- CONTENT --------------------->

<!-- column right -->
<div class="h-box-100">
    <div class="h-heading">Booking Schedule</div>

    <div class="h-table">
        <?php echo $eObj->monthlyUsage($_SESSION['FUSERID'], $planData['plan'], $planData['plan_start'], $planData['plan_end'], $planData['mjesec'], $planData['ofcUse']);?>
    </div>

    <!-- table -->

    <div class="h-table">
        <?php echo $eObj->readbooking($_SESSION['FUSERID'], $planData['ofcUse'], 0, 50);?>
    </div>
         <!-- pagination -->

    <?php /*<div class="col-md-12 text-center">
        <nav>
            <ul class="pagination">
                <?php echo pagi('B');?>
            </ul>
        </nav>
    </div>*/?>
</div>


<?php if(strtotime($planData['plan_end'])>time() && $planData['plan']!='standard'){?>
<!-- column right -->
<div class="h-box-100">
    <div class="h-heading">Available Virtual Office Location</div>
    <!-- end pagination -->
    <div class="col-md-12">
        <div id="succA"></div>
        <div id="sadrzajA"></div>
    </div>

    <div class="col-md-12" <?php //echo $dis;?>>  
        <form id="addbkfrm">
            <div id="succ"></div>

            <div class="row">
                <div class="col-md-6"> 
                    <div class="content_left_select">
                        <label>State</label>
                        <select id="state_office" name="state_office" class="form-control" data-selofc="<?php echo $item['office_city'];?>" data-office="<?php echo $planData['office'];?>">
                        <?php echo $eObj->readstate($item['state_code']);?>
                        </select>
                    </div>
                    <div class="content_left_select">
                        <label>Virtual Office City</label>
                        <select id="city_office" name="city_office" class="form-control">
                            <?php echo $eObj->readoffice($item['state_code'],$item['office_city']);?>
                        </select>
                    </div>
                    <div class="content_left_select">
                        <label>Virtual Office</label>
                        <select id="office_name" name="id_office" class="form-control">
                            <?php echo $eObj->readofficename($item['office_city'],$planData['office']);?>
                        </select>
                    </div>

                    <div id="office_thumb" class="thumbnail">
                        <?php if($item['showimg']==0)echo $eObj->readofficeimg(1);?>
                    </div>
                </div><!-- col-md-12 --> 

                <div class="col-md-6"> 

                    <div class="date_addmore">
                        <div class="content_left_select"> 

                            <div class="nopeople"> 
                                <label>No of People</label><br>
                                <input name="people" class="form-control" style="width:100px;" type="text" value="<?php echo $item[people];?>">
                            </div>

                            <div class="seldt">

                                <label>Select Date</label><br>
                                <input name="startDate[]" style="width:100px;" type="text" class="form-control multidate" value="" placeholder="dd-mm-yyyy"/>

                            </div>

                            <div class="schedule">

                                <table class="schtbl">
                                    <tr>
                                        <td class="start_date">
                                            <label>Start Time </label><br>   
                                            <input name="startTime[]" style="width:100px;" type="text" class="form-control timepicker" value="" placeholder="Select Time" />
                                        </td>
                                        
                                        <td class="end_date">
                                            <div class="end_sep">
                                                <label>Duration (Hour)</label>
                                                <br> 
                                                <select name="hour[]"  style="width:100px;" class="form-control">
                                                    <option value="">--select--</option>
                                                    <?php 
                                                                                   echo $planData['ofcUse'];
                                                    for($hr= 1; $hr<=$planData['ofcUse']; $hr++){
                                                        echo '<option value="'.$hr.'">'.$hr.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div id="add_date"></div>

                            <?php //echo readcalendar($_SESSION[id_user]);?>

                            <div class="btnw">
                                <button type="button" class="btn btn-primary btn-lg bkbtn addmore_btn" id="addmore_btn">Add Day</button>&nbsp;
                                <button type="button" class="btn btn-primary btn-lg bkbtn bookLc">Save Booking</button><!-- onclick="book()"-->
                                <input type="hidden" name="func" value="addbook">
                                <input type="hidden" name="SourceForm" value="addbook">
                                <input type="hidden" name="ajax" value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>                
</div><!-- end row --> 
<?php }?> 
            
       
