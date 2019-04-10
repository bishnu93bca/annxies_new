<?php

class Pager 

  { 
  /*********************************************************************************** 
   * int findStart (int limit) 
   * Returns the start offset based on $_GET['page'] and $limit 
   ***********************************************************************************/ 
   function findStart($limit) 
    { 
     if ((!isset($_GET['page'])) || ($_GET['page'] == "1")) 
      { 
       $start = 0; 
       $_GET['page'] = 1; 
      } 
     else 
      { 
       $start = ($_GET['page']-1) * $limit; 
      } 

     return $start; 
    } 
  /*********************************************************************************** 
   * int findPages (int count, int limit) 
   * Returns the number of pages needed based on a count and a limit 
   ***********************************************************************************/ 
   function findPages($count, $limit) 
    { 
     $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1; 

     return $pages; 
    } 
  /*********************************************************************************** 
   * string pageList (int curpage, int pages) 
   * Returns a list of pages in the format of "« < [pages] > »" 
   ***********************************************************************************/ 
   function pageList($curpage, $pages, $pageType, $dtls=NULL) 
    { 

     $page_list  = ""; 

     /* Print the first and previous page links if necessary */ 
     if (($curpage != 1) && ($curpage)) 
      { 
       $page_list .= "<a href=\"?pageType=".$pageType."&page=1\" title=\"First\" class=\"pagelnk\"><<</a>&nbsp;&nbsp;"; 
      } 

     if (($curpage-1) > 0) 
      { 
       $page_list .= "<a href=\"?pageType=".$pageType."&page=".($curpage-1)."\" title=\"Prev\" class=\"pagelnk\">Prev</a>&nbsp;"; 
      } 

     /* Print the numeric page list; make the current page unlinked and bold */ 
     $setlr   = 3; 
 	 $st_code = ''; 
	 if (($start = $curpage - $setlr) <= 1) { 
        $start = 1; $st_code = ''; 
     } else { 
     $st_code = ''; 
     } 
     if (($end   = $curpage + $setlr) >= $pages) $end = $pages; 
        $page_list .= $st_code; 
        for ($i = $start; $i <= $end; $i++) { 
           if ($i == $curpage) { 
              $page_list .= "&nbsp;<font style=\"color: #ff0000;\"><strong>".$i."</strong></font>"; 
           } else { 
           $page_list .= "&nbsp;<a href=\"?pageType=".$pageType."&page=".$i."\" title=\"Page ".$i."\" class=\"pagelnk\">".$i."</a>"; 
           } 
        $page_list .= "\n"; 
        } 
     if ($curpage + $setlr < $pages) { 
        $page_list .= ''; 
     }
     


     /* Print the Next and Last page links if necessary */ 
     if (($curpage+1) <= $pages) 
      { 
       $page_list .= "&nbsp;<a href=\"?pageType=".$pageType."&page=".($curpage+1)."\" title=\"Next\" class=\"pagelnk\">Next</a>"; 
      } 

     if (($curpage != $pages) && ($pages != 0)) 
      { 
       $page_list .= "&nbsp;&nbsp;<a href=\"?pageType=".$pageType."&page=".$pages."\" title=\"Last\" class=\"pagelnk\">>></a>";
      } 
     $page_list .= "\n"; 

     return $page_list; 
    } 
	
	/*------------------------Index Page---------------------------*/
	
	function pageListIndex($curpage, $pages, $pageType, $dtls=NULL) 
    { 

     $page_list  = ""; 

     /* Print the first and previous page links if necessary */ 
     if (($curpage != 1) && ($curpage)) 
      { 
       $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=1\" title=\"First\" class=\"pagelnk\">First</a>"; 
      } 

     if (($curpage-1) > 0) 
      { 
       $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=".($curpage-1)."\" title=\"Prev\" class=\"pagelnk\"><</a>"; 
      } 

     /* Print the numeric page list; make the current page unlinked and bold */ 
     $setlr   = 3; 
 	 $st_code = ''; 
	 if (($start = $curpage - $setlr) <= 1) { 
        $start = 1; $st_code = ''; 
     } else { 
     $st_code = ''; 
     } 
     if (($end   = $curpage + $setlr) >= $pages) $end = $pages; 
        $page_list .= $st_code; 
        for ($i = $start; $i <= $end; $i++) { 
           if ($i == $curpage) { 
              $page_list .= "<strong>".$i."</strong>"; 
           } else { 
           $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=".$i."\" title=\"Page ".$i."\" class=\"pagelnk\">".$i."</a> "; 
           } 
        $page_list .= "\n"; 
        } 
     if ($curpage + $setlr < $pages) { 
        $page_list .= ''; 
     }
     


     /* Print the Next and Last page links if necessary */ 
     if (($curpage+1) <= $pages) 
      { 
       $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=".($curpage+1)."\" title=\"Next\" class=\"pagelnk\">></a>"; 
      } 

     if (($curpage != $pages) && ($pages != 0)) 
      { 
       $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=".$pages."\" title=\"Last\" class=\"pagelnk\">Last</a>";
      } 
     $page_list .= "\n"; 

     return $page_list; 
    } 
  /*********************************************************************************** 
   * string nextPrev (int curpage, int pages) 
   * Returns "Previous | Next" string for individual pagination (it's a word!) 
   ***********************************************************************************/ 
   function nextPrev($curpage, $pages, $pageType, $dtls=NULL) 
    { 
     $next_prev  = ""; 

     if (($curpage-1) <= 0) 
      { 
       $next_prev .= "Prev"; 
      } 
     else 
      { 
       $next_prev .= "<a class=\"pagelnk\" href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=".($curpage-1)."\">Prev</a>"; 
      } 

     $next_prev .= " | "; 

     if (($curpage+1) > $pages) 
      { 
       $next_prev .= "Next"; 
      } 
     else 
      { 
       $next_prev .= "<a class=\"pagelnk\" href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&dtls=".$dtls."&page=".($curpage+1)."\">Next</a>"; 
      } 

     return $next_prev; 
    } 
  } 
?>