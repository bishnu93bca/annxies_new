<?php
if($_POST['ajax']==1){
	include '../../ext_include.php'; 
	$start=$liNo;
	$limit=$addLi;
    $page;
    $tobj      = new ViewTestimonial();
    $TestData  = $tobj -> getTestimonial($ExtraQryStr,$start,$limit); 
}
else
    $page=$testData['permalink'];

for($t=0;$t<sizeof($TestData);$t++)
{
    ?>
   <li class="scroll_effect testim" data-effect="fadeInUp" id="<?php echo $TestData[$t]['permalink'];?>">
      <div class="test_box_row">
           <h3 class="test_title lb">
               <?php echo $TestData[$t]['heading']; 
                if($TestData[$t]['feedback']) echo ' /';
                echo ' <span>'.$TestData[$t]['feedback'].'</span>'?></h3>
           <div class="test_content align_justify">
               <?php echo $TestData[$t]['description']; ?>
           </div>
       </div>
   </li>
    <?php
}
?>