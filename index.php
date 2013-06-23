<?php
//error_reporting(E_ALL);
//Подключение конфигов
require_once 'config/mysql.php';

//Подключение шаблонизатора
require_once('lib/Smarty/Smarty.class.php');
require_once('functions.php');

$smarty = new Smarty();

$smarty->setTemplateDir('template/skin/');
$smarty->setCompileDir('template/compiled/');
$smarty->setCacheDir('template/cache/');

//Подключение к MySQL
$mysqli = new mysqli($dbhost, $dbuser, $dbpasswd, $db);
$mysqli->set_charset("cp1251");


//Выбор типа отображаемой страницы

if (isset($_GET["page"])) {

    if (preg_match("/video|list|search/",$_GET["page"])) {
	$page = $_GET["page"];

    } else {

        $page = "error";    

    }    

} else {

    $page = "main";

}


switch ($page) {
    case "main":
	
	$result = $mysqli->query("SELECT ID FROM films WHERE Hide=0;");	

	$totalfilms = $result->num_rows;
	$numpages = ceil($totalfilms/$filmsperpage);	
	$currentpage = (!empty($_GET['p']))? intval($_GET['p']): 1;

	$start_row = $currentpage * $filmsperpage - $filmsperpage;
	$result = $mysqli->query("SELECT ID, Name, OriginalName, Description, Year, SmallPoster FROM films WHERE Hide=0 ORDER BY CreateDate DESC LIMIT $start_row,$filmsperpage;");

	while ($row = $result->fetch_assoc()) {
	    $row["Name"] = iconv("CP1251","UTF-8",$row["Name"]);
	    $row["Description"] = iconv("CP1251","UTF-8",$row["Description"]);
	    $films[] = $row;
	}
	
	$smarty->assign('pageurl', '/?p=');	
	$smarty->assign('endpage', $numpages);
	$smarty->assign('currentpage', $currentpage);
	$smarty->assign('pages', pagination($numpages,$currentpage));

	$smarty->assign('sitetitle', $sitetitle);
	$smarty->assign('pagetitle', 'Р“Р»Р°РІРЅР°СЏ');
	$smarty->display('header.tpl');
        $smarty->assign('films', $films);
	$smarty->assign('sidebar', '1');
	$smarty->display('page.list.tpl');
    break;
    case "error":
	
	$smarty->assign('sitetitle', $sitetitle);
	$smarty->assign('pagetitle', 'РћС€РёР±РєР°');
	$smarty->display('header.tpl');    
	$smarty->display('page.error.tpl');

    break;
    case "list":                                      


# Описание SQL-условий для выборки с параметрами.

	if (isset($_GET["type"])) {
	    $type = filter_var($_GET["type"], FILTER_SANITIZE_NUMBER_INT);
	    $typenumber = $type;

	    switch ($type) {
	    case "1":
		$type = "Фильмы";
	    break;
	    case "2":
		$type = "Сериалы";
	    break;
	    case "3":
		$type = "Мультфильмы";
	    break;
	    case "4":
		$type = "Мультсериалы";
	    break;
	    case "5":
		$type = "Документальные";
	    break;
	    
    	    }	
	    
	    $type_sql = "AND films.TypeOfMovie='$type' ";	
	}


	if (isset($_GET["national"])) {
	    $national = filter_var($_GET["national"], FILTER_SANITIZE_NUMBER_INT);
	    
	    switch ($national) {
	    case "0":
		    $national_sql = "AND filmcountries.CountryID != 4 AND filmcountries.CountryID != 7 ";
	    break;
	    case "1":		    
		    $national_sql = "AND (filmcountries.CountryID = 4 OR filmcountries.CountryID = 7) ";
	    break;

	    }

	    
	}

	if (isset($_GET["set"])) {
	    $set = filter_var($_GET["set"], FILTER_SANITIZE_NUMBER_INT);
	    $set_sql = "AND filmsets.SetID = $set ";	
	}


/*
	if (isset($national)) {
                switch ($national) {
            	    case "0":
			$result = $mysqli->query("SELECT DISTINCT ID FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID WHERE films.TypeOfMovie='$type' AND filmcountries.CountryID != 4 AND filmcountries.CountryID != 7 AND films.Hide = 0;");
			$totalfilms = $result->num_rows;
			$numpages = ceil($totalfilms/$filmsperpage);	
			$currentpage = (!empty($_GET['p']))? intval($_GET['p']): 1;
			$start_row = $currentpage * $filmsperpage - $filmsperpage;
			$result = $mysqli->query("SELECT DISTINCT ID, Name, OriginalName, Description, Year, SmallPoster FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID WHERE films.TypeOfMovie='$type' AND filmcountries.CountryID != 4 AND filmcountries.CountryID != 7 AND films.Hide = 0 ORDER BY CreateDate DESC LIMIT $start_row,$filmsperpage;");
	    	    break;
	    	    case "1":
	    	    	$result = $mysqli->query("SELECT DISTINCT ID FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID WHERE films.TypeOfMovie='$type'  AND films.Hide = 0;");	
			$totalfilms = $result->num_rows;
			$numpages = ceil($totalfilms/$filmsperpage);	
			$currentpage = (!empty($_GET['p']))? intval($_GET['p']): 1;
			$start_row = $currentpage * $filmsperpage - $filmsperpage;
			
			$result = $mysqli->query("SELECT DISTINCT ID, Name, OriginalName, Description, Year, SmallPoster FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID WHERE films.TypeOfMovie='$type' AND (filmcountries.CountryID = 4 OR filmcountries.CountryID = 7) AND films.Hide = 0 ORDER BY CreateDate DESC LIMIT $start_row,$filmsperpage;");
	    	    break;
	    	    }
	    	    
		while ($row = $result->fetch_assoc()) {
		    $row["Name"] = iconv("CP1251","UTF-8",$row["Name"]);
		    $row["Description"] = iconv("CP1251","UTF-8",$row["Description"]);
		    $films[] = $row;
		}

		//Making page title
		$pageurl = "?page=list&type=".$_GET['type']."&national=".$national."&p="; 

	} else {
*/	

#Конструируем строку запроса, вклеивая в нее нужные параметры

//		$query = "SELECT DISTINCT ID FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID JOIN filmsets ON films.ID = filmsets.FilmID WHERE Hide=0 ";
		
		if (isset($type_sql)) {
		    $query = $type_sql;
		}

		if (isset($national_sql)) {
		    $query = $query . $national_sql;
		}

		if (isset($set_sql)) {
		    $query = $query . $set_sql;
		}
		
//		$query = $query . ";";



		$result = $mysqli->query("SELECT DISTINCT ID FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID LEFT JOIN filmsets ON films.ID = filmsets.FilmID WHERE Hide=0 ".$query .";");	
//		echo("SELECT DISTINCT ID FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID JOIN filmsets ON films.ID = filmsets.FilmID WHERE Hide=0 ".$query ."");	

		
//		echo('SELECT DISTINCT ID FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID JOIN filmsets ON films.ID = filmsets.FilmID WHERE Hide=0 '. if (isset($type_sql)) { echo $type_sql; }; .''. if (isset($national_sql)) { echo $national_sql; };.';');	

		$totalfilms = $result->num_rows;
		$numpages = ceil($totalfilms/$filmsperpage);	
		$currentpage = (!empty($_GET['p']))? intval($_GET['p']): 1;
		$start_row = $currentpage * $filmsperpage - $filmsperpage;
		
		$result = $mysqli->query("SELECT DISTINCT ID, Name, OriginalName, Description, Year, SmallPoster FROM films JOIN filmcountries ON films.ID = filmcountries.FilmID LEFT JOIN filmsets ON films.ID = filmsets.FilmID WHERE Hide=0 ".$query." ORDER BY CreateDate DESC LIMIT $start_row,$filmsperpage;");
	
		while ($row = $result->fetch_assoc()) {
		    $row["Name"] = iconv("CP1251","UTF-8",$row["Name"]);
		    $row["Description"] = iconv("CP1251","UTF-8",$row["Description"]);
		    $films[] = $row;
		}

		//Making page title


		$pageurl = "?page=list"; 
//		$pageurl = "?page=list&type=".$_GET['type']."&p="; 


		if (isset($type_sql)) {
		    $pageurl = $pageurl . "&type=$typenumber";
		}

		if (isset($national_sql)) {
		    $pageurl = $pageurl . "&national=$national";
		}

		if (isset($set_sql)) {
		    $pageurl = $pageurl . "&set=$set";
		}

		$pageurl = $pageurl . "&p=";


//        }

        

		
	$smarty->assign('pageurl', $pageurl);	
	$smarty->assign('endpage', $numpages);
	$smarty->assign('currentpage', $currentpage);
	$smarty->assign('pages', pagination($numpages,$currentpage));
	
	$type = iconv("CP1251","UTF-8",$type);
	$smarty->assign('sitetitle',$sitetitle);
	$smarty->assign('pagetitle',$type);

        $smarty->display('header.tpl');
        $smarty->assign('films', $films);
	$smarty->assign('sidebar', '1');
	$smarty->display('page.list.tpl');

    break;
    case "video":
	
	$filmid = intval($_GET["id"]);    
	$filminfo = $mysqli->query("SELECT ID, Name, OriginalName, Description, Year, SmallPoster FROM films WHERE ID=".$filmid." AND Hide=0");
	$filmfiles = $mysqli->query("SELECT Name, Path, Size FROM files WHERE FilmID=".$filmid." AND Name LIKE 'sd-%' ORDER BY Name");

//Cheking for HD files 
	$hdfiles = $mysqli->query("SELECT Name, Path, Size FROM files WHERE FilmID=".$filmid." AND Name LIKE 'hd-%' ORDER BY Name");    
	$hdfiles = $hdfiles->num_rows;
	
	if ($hdfiles != 0) {
	    $hdmode = 1;
	} else {
	    $hdmode = 0;
	}
		
	while ($row = $filmfiles->fetch_assoc()) {
	    $row["Name"] = iconv("CP1251","UTF-8",$row["Name"]);
	    $row["Path"] = iconv("CP1251","UTF-8",$row["Path"]);
	    $files[] = $row;
	}

	    $row = $filminfo->fetch_assoc(); 
	    $name = iconv("CP1251","UTF-8",$row["Name"]);            
	    $description = iconv("CP1251","UTF-8",$row["Description"]);            
	
	if (count($files) == 1) {
	    $sidebar = 0;
	} else {
	    $sidebar = 1;
	}
	
	$smarty->assign('sitetitle',$sitetitle);
	$smarty->assign('pagetitle', $name);
	$smarty->assign('sidebar', $sidebar);	
        $smarty->assign('episodes', $files);
        $smarty->assign('name', $name);
        $smarty->assign('description', $description);
        $smarty->assign('hdmode', $hdmode);

	$smarty->display('header.tpl');                                                                                        
	$smarty->display('page.video.tpl');
	
    break;
        case "search":

	if (isset($_GET['s']) and strlen($_GET['s']) > 2) {
    	    require_once ("lib/sphinxapi.php");
	    $utf8string = $_GET['s'];
            $string = iconv("UTF-8","CP1251",$_GET['s']);
            $sphinx = new SphinxClient();
            $sphinx->SetServer('localhost', 9312);
            $sphinx->SetMatchMode(SPH_MATCH_ANY);
            $sphinx->SetSortMode(SPH_SORT_RELEVANCE);
            $sphinx->SetFieldWeights(array ('Name' => 20, 'OriginalName' => 15, 'Description' => 10));
            $result = $sphinx->Query( $string, '*');
    
            if ($result && isset($result['matches'])) {
    
                // Получаем массив ID постов блога
		$ids = array_keys($result['matches']);

                // Выводим посты отсортированные по релевантности
                $id_list = implode(',', $ids);

		$mysqli = new mysqli($dbhost, $dbuser, $dbpasswd, $db);
		$mysqli->set_charset("cp1251");
    	        $request = $mysqli->query("SELECT ID, Name, OriginalName, Description, SmallPoster, Year FROM films WHERE ID IN (".$id_list.") ORDER BY FIELD(ID, ".$id_list.")");
		
            	while ($row = $request->fetch_assoc()) {
		    $row["Name"] = iconv("CP1251","UTF-8",$row["Name"]);
		    $row["Description"] = iconv("CP1251","UTF-8",$row["Description"]);
		    $cleanresult[] = $row;
		}

    	    } else {
    		$error_msg = "РџРѕ РІР°С€РµРјСѓ Р·Р°РїСЂРѕСЃСѓ РЅРёС‡РµРіРѕ РЅРµ РЅР°Р№РґРµРЅРѕ.";
    	    }

	} else {

	    $error_msg = "РџРѕРёСЃРєРѕРІС‹Р№ Р·Р°РїСЂРѕСЃ РґРѕР»Р¶РµРЅ СЃРѕСЃС‚РѕСЏС‚СЊ РјРёРЅРёРјСѓРј РёР· 2 СЃРёРјРІРѕР»РѕРІ.";
	}
	
#	echo $result['total_found'];
		
	$smarty->assign('sitetitle',$sitetitle);
        $smarty->assign('pagetitle',$utf8string);

	if (isset($error_msg)) { 
		    $smarty->assign('error_message', $error_msg); 
	    }

        $smarty->assign('searchrequest', $request);
        $smarty->assign('searchresult', $cleanresult);
	$smarty->assign('searchcount', $result['total_found']);        
	$smarty->assign('sidebar', '1');
    	$smarty->display('header.tpl');                                                                                        
	$smarty->display('page.search.tpl');


    break;    
    
}    



$smarty->display('sidebar.tpl');
$smarty->display('footer.tpl');


?>              
