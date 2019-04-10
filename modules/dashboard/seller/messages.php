<?php
$SId = $_SESSION['FUSERID'];
$messages = $eObj->getMessages($SId);

?>


<div class="h-box-100" id="showmail">
    <div class="h-heading">Messages</div>
     <div class="mail-box">
                  <aside class="lg-side">
                      <div class="inbox-body">
                         <div class="mail-option">
                          <table class="table table-inbox table-hover">
                            <tbody>
                            	<?php
                                foreach($messages as $msz){
                           
                           if($msz['subject'] == "Product Enquiry") {
                           	?>
                             <!-- //<a class="viewmsz" data-page="viewmsz" data-id="<?php //echo $msz['contactID']?>" style="cursor:pointer"> -->
                            <tr class="viewmsz" data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message dont-show"><?php echo $msz['name'];?><span class="label label-success pull-right">Post Requirement</span></td>
                                  <td class="view-message view-message"><?php echo $msz['contactComments'];?></td>
                                  <td class="view-message inbox-small-cells"></td>
                                  <td class="view-message text-right"><?php echo $msz['contactEntrydate'];?></td>
                                  <!-- <td style="min-width: 60px;"> <a class="viewmsz" data-page="viewmsz" data-id="<?php //echo $msz['contactID']?>" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Message"></span></a></td>
                               -->
                               <!-- </a> -->
                              </tr>
                             <?php } 
                              elseif($msz['subject'] == "Sample Request") {
                             ?>
                              
                              <tr class="viewmsz" data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                                  <td class="view-message dont-show"><?php echo $msz['name'];?><span class="label label-danger pull-right">Samples</span></td>
                                  <td class="view-message">S<?php echo $msz['contactComments'];?></td>
                                  <td class="view-message inbox-small-cells"></td>
                                  <td class="view-message text-right"><?php echo $msz['contactEntrydate'];?></td>
                                 <!--  <td style="min-width: 60px;"> <a class="viewmsz" data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Message"></span></a></td>
                               -->
                              </tr>
                             <?php
                         }
                          elseif($msz['subject'] == "Contact Information") {


                             ?>
                              
                             
                              <tr class="viewmsz" data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message dont-show"><?php echo $msz['name'];?><span class="label label-info pull-right">Urgent</span></td>
                                  <td class="view-message view-message"><?php echo $msz['contactComments'];?></td>
                                  <td class="view-message inbox-small-cells"></td>
                                  <td class="view-message text-right"><?php echo $msz['contactEntrydate'];?></td>
                                  <!-- <td style="min-width: 60px;"> <a class="viewmsz" data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Message"></span></a></td>
                               -->
                              </tr>
                         
                            <?php
                            }
                            else{
                            ?>
                                <tr class="viewmsz" data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
                                  <td class="inbox-small-cells">
                                      <input type="checkbox" class="mail-checkbox">
                                  </td>
                                  <td class="inbox-small-cells"><i class="fa fa-star"></i></td>
                                  <td class="view-message dont-show"><?php echo $msz['name'];?></td>
                                  <td class="view-message view-message"><?php echo $msz['contactComments'];?></td>
                                  <td class="view-message inbox-small-cells"></td>
                                  <td class="view-message text-right"><?php echo $msz['contactEntrydate'];?></td>
                                 <!--  <td style="min-width: 60px;"> <a class="viewmsz" data-page="viewmsz" data-id="'.$msz['contactID'].'" style="cursor:pointer"><span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="View Message"></span></a></td>
                              --> 
                            </tr>
                              <?php 
                              }
                          }
                              ?>
                            
                          </tbody>
                          </table>
                      </div>
                  </div>
                  </aside>
              </div>
          </div>
</div>
<div class="clear"></div>
<div id="sadrzaj"></div>

<!-------------modal------------------------>
<div class="modal fade" id="myMszModal" role="dialog">
    <div class="modal-dialog" style="width:50%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Preview</h4>
         
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  