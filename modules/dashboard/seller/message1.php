<?php
$SId = $_SESSION['FUSERID'];
$messages = $eObj->getMessages($SId);

?>

<div class="h-box-100">
    <div class="h-heading">Messages</div>

<div class="container ">
<div class="msg_section">

<div class="row">
        <div class="box">
            <!--mail inbox start-->
            <div class="mail-box">
                
                <aside class="lg-side ">
                
                <div class="inbox-body">
                <div class="mail-option">
                   <!--  <div class="chk-all">
                        <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                            <a class="all" href="#"  >
                                Select All
                                
                            </a>
                    </div> -->
                    <div class="btn-group">
                        <a class="btn mini tooltips" href="" data-toggle="dropdown" >
                            <i class=" fa fa-refresh refresh"></i>
                        </a>
                    </div>
					
					
                    <!-- <div class="input-group pull-right"> <input class="form-control" placeholder="Search for..."> 
					<span class="input-group-btn"> 
					<!-- <button class="btn btn-default" type="button"><i class=" fa fa-caret-down"></i></button>  -->
					<!-- </span> 
					</div> --> 
                   
                </div>
				          <?php
                                foreach($messages as $msz){
                           
                           if($msz['subject'] == "Product Enquiry") {
                           	?>

               <table class="messag">
                  <tbody>
                  <tr class="sec-1"> 
	<td class="circle">
		<i class="fa fa-circle"></i></td>
		<td class="inbox-small-cells">
        <input type="checkbox" class="mail-checkbox">
         </td>
			<td>
				<!-- <i class="fa fa-reply"></i> -->
			</td>
			<!-- <td><i class="fa fa-star"></i></td> -->
		</tr>
		<tr class="msg-detail viewmsz"  data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
			<td class="title"> <?php echo $msz['name'];?></td>
			<td class="purpose"><?php echo $msz['subject'];?></td>
			<td class="msg">
				
					<p ><i class="fa fa-clock"></i><?php echo substr($msz['contactComments'], 0,30);?></p>
				</td>
			
		</tr>
		<tr class="date">
		<td>
			<!-- <i class="fa fa-paperclip"> --><?php echo date("d-M-Y H:i:s A", strtotime($msz['contactEntrydate']));?>
		</td>
		</tr>

		<tr class="star">
		<td class="btn-group ">
			
			<!-- <button class="btn" data-rel="tooltip">
				<i class="ace-icon fa fa-star"></i>
			</button> -->
			
			<button data-toggle="dropdown" class="btn">
				<span class="ace-icon fa fa-caret-down icon-only"></span>
			</button>
			<ul class="dropdown-menu ">
					<li><a href="#" class="mark">Mark as read</a></li>
					
					<!-- <li><a href="#" class="add-to"> Add to...</a></li> -->
					<li class="deleteMsz" data-mszid="<?php echo $msz['contactID'];?>"><a href="#" class="delete"> Delete</a></li>
				
			</ul>
	</td>
	</tr>
	

	</tbody>
	</table>
	<?php }

       elseif($msz['subject'] == "Sample Request") {
                          ?>

     <table class="messag">
                  <tbody>
                  <tr class="sec-1"> 
	<td class="circle"><i class="fa fa-circle"></i></td>
		<td class="inbox-small-cells">
                        <input type="checkbox" class="mail-checkbox">
         </td>
			<td>
				<!-- <i class="fa fa-reply"></i> -->
			</td>
			<td><!-- <i class="fa fa-star"> --></i></td>
		</tr>
		<tr class="msg-detail viewmsz"  data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
			<td class="title"> <?php echo $msz['name'];?> </td>
			<td class="purpose"><?php echo $msz['subject'];?></td>
			<td class="msg" >
				
					<p><i class="fa fa-clock"></i><?php echo substr($msz['contactComments'], 0,30);?></p>
				</td>
			
		</tr>
		<tr class="date">
		<td>
			<!-- <i class="fa fa-paperclip"> --><?php echo date("d-M-Y H:i:s A", strtotime($msz['contactEntrydate']));?>
		</td>
		</tr>

		<tr class="star">
		<td class="btn-group ">
			<!-- 
			<button class="btn " data-rel="tooltip">
				<i class="ace-icon fa fa-star"></i>
			</button> -->
			
			<button data-toggle="dropdown" class="btn">
				<span class="ace-icon fa fa-caret-down icon-only"></span>
			</button>
			<ul class="dropdown-menu ">
					<li><a href="#" class="mark">Mark as read</a></li>
					
					<!-- <li><a href="#" class="add-to"> Add to...</a></li> -->
					<li class="deleteMsz" data-mszid="<?php echo $msz['contactID'];?>"><a href="#" class="delete"> Delete</a></li>
				
			</ul>
	</td>
	</tr>
	

	</tbody>
	</table>
	<?php  }
       elseif($msz['subject'] == "Contact Information") {
       ?>
	  <table class="messag">
                  <tbody>
                  <tr class="sec-1"> 
	<td class="circle"><i class="fa fa-circle"></i></td>
		<td class="inbox-small-cells">
                        <input type="checkbox" class="mail-checkbox">
         </td>
			<td>
				<!-- <i class="fa fa-reply"></i> -->
			</td>
			<td><!-- <i class="fa fa-star"></i> --></td>
		</tr>
		<tr class="msg-detail viewmsz"  data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
			<td class="title">  <?php echo $msz['name'];?></td>
			<td class="purpose"><?php echo $msz['subject'];?></td>
			<td class="msg" >
				
					<p ><i class="fa fa-clock"></i><?php echo substr($msz['contactComments'], 0,30);?></p>
				</td>
			
		</tr>
		<tr class="date">
		<td>
			<!-- <i class="fa fa-paperclip"> --><?php echo date("d-M-Y H:i:s A", strtotime($msz['contactEntrydate']));?>
		</td>
		</tr>

		<tr class="star">
		<td class="btn-group ">
			
		<!-- 	<button class="btn " data-rel="tooltip">
				<i class="ace-icon fa fa-star"></i>
			</button>
			 -->
			<button data-toggle="dropdown" class="btn">
				<span class="ace-icon fa fa-caret-down icon-only"></span>
			</button>
			<ul class="dropdown-menu ">
					<li><a href="#" class="mark">Mark as read</a></li>
					
					<!-- <li><a href="#" class="add-to"> Add to...</a></li> -->
					<li class="deleteMsz" data-mszid="<?php echo $msz['contactID'];?>"><a href="#" class="delete"> Delete</a></li>
				
			</ul>
	</td>
	</tr>
	

	</tbody>
	</table>
	<?php 
         }
	else{ 
		?>
<table class="messag" >
                  <tbody>
                  <tr class="sec-1"> 
	<td class="circle"><i class="fa fa-circle"></i></td>
		<td class="inbox-small-cells">
                        <input type="checkbox" class="mail-checkbox">
         </td>
			<td>
				<!-- <i class="fa fa-reply"></i> -->
			</td>
			<td><!-- <i class="fa fa-star"></i> --></td>
		</tr>
		<tr class="msg-detail viewmsz"  data-page="viewmsz" data-id="<?php echo $msz['contactID']?>" style="cursor:pointer">
			<td class="title">  <?php echo $msz['name'];?></td>
			<td class="purpose"><?php echo $msz['subject'];?></td>
			<td class="msg" >
				
					<p ><i class="fa fa-clock"></i><?php echo substr($msz['contactComments'], 0,30);?></p>
				</td>
			
		</tr>
		<tr class="date">
		<td>
			<!-- <i class="fa fa-paperclip"> --><?php echo date("d-M-Y H:i:s A", strtotime($msz['contactEntrydate']));?>
		</td>
		</tr>

		<tr class="star">
		<td class="btn-group ">
			
			<!-- <button class="btn " data-rel="tooltip">
				<i class="ace-icon fa fa-star"></i>
			</button>
			 -->
			<button data-toggle="dropdown" class="btn">
				<span class="ace-icon fa fa-caret-down icon-only"></span>
			</button>
			<ul class="dropdown-menu ">
					<li><a href="#" class="mark">Mark as read</a></li>
					
				<!-- 	<li><a href="#" class="add-to"> Add to...</a></li> -->
					<li class="deleteMsz" data-mszid="<?php echo $msz['contactID'];?>"><a href="#" class="delete"> Delete</a></li>
				
			</ul>
	</td>
	</tr>
	

	</tbody>
	</table>
	<?php
   }

   }
   ?>

  
				<!-- <ul class="pagination pull-right"> 
				<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li> 
				<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li> 
				<li><a href="#">2</a></li> <li><a href="#">3</a></li> <li><a href="#">4</a></li>
				<li><a href="#">5</a></li> <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li> 
				</ul>  -->
                </div>
                </aside>
</div>
</div>
</div>
</div>
</div>


<div class="container">
<div class="full_msg">
<div class="mail-option">
                   <!--  <div class="chk-all">
                        <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                            <a class="all" href="#"  >
                                Select All
                                
                            </a>
                    </div> -->
                    <!-- <div class="btn-group">
                        <a class="btn mini tooltips" href="#" data-toggle="dropdown" >
                            <i class=" fa fa-refresh refresh"></i>
                        </a>
                    </div> -->
					<!-- <div class="btn-group">
                        <a class="btn mini tooltips" href="#" data-toggle="dropdown" >
                            <i class="fa fa-reply"></i>
                        </a>
                    </div> -->
					<!-- <div class="btn-group">
                        <a class="btn mini tooltips" href="#" data-toggle="dropdown" >
                            <i class="fa fa-trash"></i>
                        </a>
                    </div> -->
								
                   
                </div>
   <!--  <button type="button" class="slide-left">Slide Left</button>
    <button type="button" class="slide-right">Slide Right</button> -->
    <hr>
    <div class="msg_box">
      
    </div>


</div>
</div>

</div>
 <div class="clear"></div>
 <div id="errMsg"></div>

 
<!-------------modal------------------------>
<div class="modal fade" id="myMszModal" role="dialog">
    <div class="modal-dialog" style="width:50%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reply</h4>
          </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> 
    </div>
  </div>
  

</div>

