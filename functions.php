<?php

function pagination($numpages, $currentpage){
    //Получаем общее число страниц


#    $totalfilms = 1500;
#    $filmsonpage = 15; 
#    $currentpage = 100;


//Setting up pagination mode! 
    if ($currentpage < 10) {
	$paginatormode = "first";
    } elseif  ($currentpage == $numpages) {
	$paginatormode = "last";
    } else {
	$paginatormode = "normal";
    }  

//Check for max pages in paginator
    if ($numpages <= 10) {
	$pcount = $numpages;
    } else {
	$pcount = 10;
    }

//Working in selected mode!
    switch ($paginatormode) {

	case "first":
	    $i = 1;
	    while ($i <= $pcount) {
	    $pages[] = $i;
	    $i++;
	    }
	    break;

	case "normal":
            $i = $currentpage - 8;
	    $s = $currentpage + 1;
#$i = 10;
#$s = 24;	
	    while ($i <= $s ) {
		$pages[] = $i;
		$i++;
	    }
	    break;

	case "last":
            $i = $currentpage - 9;
	    while ($i <= $currentpage ) {
		$pages[] = $i;
		$i++;
	    }	
	    break;
    }

return $pages;

}

?>