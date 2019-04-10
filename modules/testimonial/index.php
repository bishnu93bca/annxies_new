<?php
$tobj       = new ViewTestimonial();
$ExtraQryStr= "status='Y'";
$start	    = 0;
$limit	    = 999;
$addLi	    = 999;
$TestData   = $tobj -> getTestimonial($ExtraQryStr,$start,$limit);
$countRow   = $tobj -> countTestimonial(1);


if($TestData)
{
    include('testimonial.php');
}
else
    echo "No Result Found";

?>
