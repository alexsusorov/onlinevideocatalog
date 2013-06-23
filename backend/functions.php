<?php

error_reporting(E_ALL);

function &parser_cinemate($filmurl) {

//Данные Cinemate.cc API
$APIURL = "http://cinemate.cc/api/2.0/movie/get/";
$APIKEY = "";

$id = explode("/", $filmurl);
$id = $id[4];

//Получение полной информации от cinemate.cc по ID фильма
$url = $APIURL."?apikey=".$APIKEY."&id=".$id;
$data = file_get_contents($url);
$feed = new SimpleXMLElement($data);


	foreach ($feed->movie[0]->country->name as $c)
        {
          $filmcountry[] = $c;
        }

	foreach ($feed->movie[0]->genre->name as $g)
        {
          $filmgenre[] = $g;
        }

	$filminfo = array(
	    "rusname"     => $feed->movie[0]->title_russian,
	    "origname"    => $feed->movie[0]->title_original,
	    "year"        => $feed->movie[0]->year,
	    "description" => $feed->movie[0]->description,
	    "poster"	  => $feed->movie[0]->poster->big->attributes()->url,
	    "country"	  => $filmcountry,
	    "genre"	  => $filmgenre,
	    "parser"	  => "Cinemate",
	);


return $filminfo;

}


function &parser_kinobaza($filmurl) {

//Данные Kinobaza.TV API
$APIURL = "http://api.kinobaza.tv/";

$id = explode("/", $filmurl);
$id = $id[4];

//Получение полной информации от kinovaza.tv по ID фильма
$url = $APIURL."films/".$id."?fields_mask=19";
$data = file_get_contents($url);
$feed = json_decode($data);


        foreach ($feed->countries as $c)
        {
          $filmcountry[] = $c->name;
        }


//Фильтрация кода HTML-страницы от каких-то невалидных тегов
	$html = file_get_contents('http://kinobaza.tv/film/'.$id.'/');
	$html = preg_replace('@<script[^>]*?>.*?</script>@si', '', $html); 
	$html = preg_replace('@<input[^>]*?>.*?</input>@si', '', $html); 

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);
	$genres = $xpath->query('//a[@class="filter_genres_set_link"]/text()');

	foreach ($genres as $genre) {
		$filmgenre[] =  $genre->nodeValue;
	}


        $filminfo = array(
            "rusname"     => $feed->name,
            "origname"    => $feed->original_name,
            "year"        => $feed->year,
            "description" => $feed->description,
            "poster"      => "http://media.kinobaza.tv/films/".$id."/poster/207.jpg",
            "country"     => $filmcountry,
            "genre"       => $filmgenre,
            "parser"      => "Kinobaza",
        );


return $filminfo;

}


?>
