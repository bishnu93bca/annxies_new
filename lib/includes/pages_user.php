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
	function pageList($curpage, $RequestURI, $pages) 
	{ 
		/* Print the first and previous page links if necessary */ 
		/*if (($curpage != 1) && ($curpage)) 
		{ 	
			$page_list .= "<li><a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."\" title=\"First\" class=\"previous_pagi\"></a></li>";
		} */
		if (($curpage-1) > 0) 
		{ 
			if($curpage==2)
				$page_list = "<a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."\" title=\"Prev\" class=\"previous_pagi\">Prev</a>"; 
			else
				$page_list = "<a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."?page=".($curpage-1)."\" title=\"Prev\" class=\"previous_pagi\">Prev</a>"; 
		}
		if ($curpage==1) 		
		{ 		
			$page_list .= "<a href=\"javascript:void(0)\" title=\"Prev\" class=\"previous_pagi\">Prev</a>"; 		
		}  
		$page_list  .= "<ul>"; 
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
			if ($i == $curpage)
				$page_list .= "<li>".$i."</li>"; 		
			else 
			{ 
				if($i==1)
					$page_list .= "<li><a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."\" title=\"Page ".$i."\" class=\"pagelnk\">".$i."</a></li>"; 	
				else		
					$page_list .= "<li><a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."?page=".$i."\" title=\"Page ".$i."\" class=\"pagelnk\">".$i."</a></li>"; 	
			} 		
			$page_list .= "\n"; 		
		} 
		if ($curpage + $setlr < $pages)
			$page_list .= ''; 		
     	/* Print the Next and Last page links if necessary */ 
		$page_list .= "</ul>";	
		if (($curpage+1) <= $pages) 				
			$page_list .= "<a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."?page=".($curpage+1)."\" title=\"Next\" class=\"next_pagi\">Next</a>"; 				
		
		if ($curpage== $pages) 				
			$page_list .= "<a href=\"javascript:void(0)\" title=\"Next\" class=\"next_pagi\">Next</a>"; 					
		return $page_list; 
    } 
	/*********************************************************************************** 
	* string nextPrev (int curpage, int pages) 
	* Returns "Previous | Next" string for individual pagination (it's a word!) 
	***********************************************************************************/ 
	/*********************************************************************************** 	
	* string pageList (int curpage, int pages) 	
	* Returns a list of pages in the format of "« < [pages] > »" 	
	***********************************************************************************/ 
	function samplepageList($curpage, $RequestURI, $pages) 
	{ 
		/* Print the first and previous page links if necessary */ 
		/*if (($curpage != 1) && ($curpage)) 
		{ 	
			$page_list .= "<li><a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."\" title=\"First\" class=\"previous_pagi\"></a></li>";
		} */
		if (($curpage-1) > 0) 
		{ 
			if($curpage==2)
				$page_list = "<a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."\" title=\"Prev\" class=\"previous_pagi\">Prev</a>"; 
			else
				$page_list = "<a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."&page=".($curpage-1)."\" title=\"Prev\" class=\"previous_pagi\">Prev</a>"; 
		}
		if ($curpage==1) 		
		{ 		
			$page_list .= "<a href=\"javascript:void(0)\" title=\"Prev\" class=\"previous_pagi\">Prev</a>"; 		
		}  
		$page_list  .= "<ul>"; 
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
			if ($i == $curpage)
				$page_list .= "<li>".$i."</li>"; 		
			else 
			{ 
				if($i==1)
					$page_list .= "<li><a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."\" title=\"Page ".$i."\" class=\"pagelnk\">".$i."</a></li>"; 	
				else		
					$page_list .= "<li><a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."&page=".$i."\" title=\"Page ".$i."\" class=\"pagelnk\">".$i."</a></li>"; 	
			} 		
			$page_list .= "\n"; 		
		} 
		if ($curpage + $setlr < $pages)
			$page_list .= ''; 		
     	/* Print the Next and Last page links if necessary */ 
		$page_list .= "</ul>";	
		if (($curpage+1) <= $pages) 				
			$page_list .= "<a href=\"http://".$_SERVER['HTTP_HOST']."".$RequestURI."&page=".($curpage+1)."\" title=\"Next\" class=\"next_pagi\">Next</a>"; 				
		
		if ($curpage== $pages) 				
			$page_list .= "<a href=\"javascript:void(0)\" title=\"Next\" class=\"next_pagi\">Next</a>"; 					
		return $page_list; 
    } 
	/*********************************************************************************** 
	* string nextPrev (int curpage, int pages) 
	* Returns "Previous | Next" string for individual pagination (it's a word!) 
	***********************************************************************************/ 
	function nextPrev($curpage, $pages, $pageType, $id) 
	{ 
		$next_prev  = ""; 
		if (($curpage-1) <= 0) 
			$next_prev .= "Prev"; 
		else 
			$next_prev .= "<a class=\"pagelnk\" href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&id=".$id."&page=".($curpage-1)."\">Prev</a>"; 
		$next_prev .= " | "; 
		if (($curpage+1) > $pages) 
			$next_prev .= "Next"; 
		else 
			$next_prev .= "<a class=\"pagelnk\" href=\"".$_SERVER['PHP_SELF']."?pageType=".$pageType."&id=".$id."&page=".($curpage+1)."\">Next</a>"; 
		return $next_prev; 
	} 
} 
?>