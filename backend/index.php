<html debug="true">

        <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8">
                <script src="./template/skin/js/jquery.js"></script>
                <script src="./template/skin/js/bootstrap.js"></script>
                <link href="./template/skin/css/bootstrap.css" rel="stylesheet">

                <style>
                      body {
                       padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
                      }
                </style>

        </head>

        <body>

<div class="container">

<?php

require_once "./config.php";
require_once "./functions.php";

if (isset($_GET["page"])) {

    if (preg_match("/add|preview|list|edit/",$_GET["page"])) {
        $page = $_GET["page"];

    } else {

        $page = "error";    

    }    

} else {

    $page = "main";

}


switch ($page) {
    case "main":
?>

<h3>Добавление информации о новом фильме...</h3>
<form action="?page=preview" method="post">
  <fieldset>
    <input type="text" id="filmurl" name="filmurl" class="input-block-level" placeholder="Ссылка на страницу cinemate.cc или kinobaza.tv...">
    <button type="submit" class="btn btn-warning pull-right">Вперед!</button>
  </fieldset>
</form>


<?php

break;
case "preview":

if (substr_count($_POST['filmurl'], 'cinemate')) {

	$site = "cinemate.cc";
	$filminfo =& parser_cinemate($_POST["filmurl"]);

} elseif (substr_count($_POST['filmurl'], 'kinobaza')) {

	$site = "kinobaza.tv";
	$filminfo =& parser_kinobaza($_POST["filmurl"]);

} else {

	header('Location: ./index.php');

}


?>


<h3>Полученные от <?php echo $site; ?>  данные...</h3>
<form action="?page=add" method="post" class="form-horizontal">
  <fieldset>

	<div class="control-group">
	    <label class="control-label" for="rusname">Русское название</label>
	    <div class="controls">
	      <input type="text" id="rusname" name="rusname" class="input-block-level" value="<?php echo $filminfo["rusname"]; ?>">
	    </div>
	</div>

        <div class="control-group">
            <label class="control-label" for="origname">Ориг. название</label>
            <div class="controls">
              <input type="text" id="origname" name="origname" class="input-block-level" value="<?php echo $filminfo["origname"]; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="year">Год</label>
            <div class="controls">
              <input type="text" id="year" name="year" class="input-block-level" value="<?php echo $filminfo["year"]; ?>">
            </div>
        </div>

	<div class="control-group">
            <label class="control-label" for="country">Страна</label>
            <div class="controls">
              <?php 

		foreach ($filminfo["country"] as $country) {
			echo "<label class=\"checkbox inline\">";
			echo "<input type=\"checkbox\" name=\"country[]\" value=\"$country\" checked=\"checked\"> $country";
			echo "</label>";
		}

		?>
            </div>
        </div>

<div class="control-group">
            <label class="control-label" for="country">Жанр</label>
            <div class="controls">
              <?php 

                foreach ($filminfo["genre"] as $genre) {
                        echo "<label class=\"checkbox inline\">";
                        echo "<input type=\"checkbox\" name=\"genre[]\" value=\"$genre\" checked=\"checked\"> $genre";
                        echo "</label>";
                }

                ?>
            </div>
        </div>

	<div class="control-group">
            <label class="control-label" for="description">Описание</label>
            <div class="controls">
	      <textarea rows="8" id="description" name="description" class="input-block-level"><?php echo $filminfo["description"]; ?></textarea>
            </div>
        </div>

	<div class="control-group">
            <label class="control-label" for="poster">Ссылка на постер</label>
            <div class="controls">
              <input type="text" id="poster" name="poster" class="input-block-level" value="<?php echo $filminfo["poster"]; ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="dirpath">Путь к файлам</label>
            <div class="controls">
              <input type="text" id="dirpath" name="dirpath" class="input-block-level" value="">
            </div>
        </div>

	<div class="control-group">
            <label class="control-label" for="type">Тип фильма</label>
            <div class="controls">
		<select id="type" name="type" class="input-block-level">
		  <option>Фильмы</option>
		  <option>Сериалы</option>
		  <option>Мультфильмы</option>
		  <option>Мультсериалы</option>
		  <option>Документальные</option>
		</select>
            </div>
        </div>

    <button type="submit" class="btn btn-warning pull-right">Вперед!</button>
  </fieldset>
</form>


<?php

break;
case "add":


#Подключение к MySQL и внесение в нее данных о фильме
$mysql = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
$db = mysql_select_db($mysql_base, $mysql);
mysql_set_charset('utf8');

#Внесение основной записи о фильме
$query = "INSERT INTO films (Name, OriginalName, Description, Year, CreateDate, UpdateDate, TypeOfMovie, Hide) VALUES ('{$_POST['rusname']}', '{$_POST['origname']}', '{$_POST['description']}', '{$_POST['year']}', NOW(), NOW(), '{$_POST['type']}', '1')";
$result = mysql_query($query);
$id = mysql_insert_id();

#Внесение записи о стране-изготовителе фильма
foreach ($_POST["country"] as $country) {
	$query = "INSERT INTO filmcountries SET FilmID='{$id}', CountryID=(SELECT ID FROM countries WHERE Name = '{$country}')";
	$result = mysql_query($query);
}

#Внесение записи о жанрах фильма
foreach ($_POST["genre"] as $genre) {
        $query = "INSERT INTO filmgenres SET FilmID='{$id}', GenreID=(SELECT ID FROM genres WHERE (CinemateGenre = '{$genre}' or KinobazaGenre = '{$genre}'))";
        $result = mysql_query($query);
}

echo mysql_errno() . ": " . mysql_error() . "\n";


#Сохранение изображения постера, создание уменьшеной копии, обновление БД

$poster_url = $_POST['poster'];
$poster_img = file_get_contents($poster_url);
$poster_ext = pathinfo($poster_url,PATHINFO_EXTENSION);

$poster_filename_big   = "posters/big/".$id."_big.".$poster_ext;
$poster_filename_small = "posters/small/".$id."_small.".$poster_ext;

#Сохранение большого изображения постера
$poster_file_big = fopen($poster_filename_big, "w");
fwrite($poster_file_big, $poster_img);
fclose($poster_file_big);

#Сохранение маленького изображения постера
$poster_img_small = new Imagick($poster_filename_big);
$poster_img_small -> thumbnailImage( 130, null );
$poster_file_small = fopen($poster_filename_small, "w");
fwrite($poster_file_small, $poster_img_small);
fclose($poster_file_small);

$query = "UPDATE films SET BigPosters='{$poster_filename_big}', SmallPoster='{$poster_filename_small}' WHERE ID = {$id}";
$result = mysql_query($query);

#Ищем в директории файлы и добавляем их пути в базу
$pattern = $_POST['dirpath']. '*.mp4';
$files = glob( $pattern );

?>

<h3>Фильм успешно добавлен в базу!</h3>

<table class="table table-striped">
<thead>
   <tr>
       <th>Путь к файлу</th>
       <th>Размер</th>
   </tr>
</thead>
<tbody>

<?php

foreach ($files as $file) {

	$filesize = filesize($file);
	$filehash = md5_file($file);
	$filename = pathinfo($file, PATHINFO_BASENAME);

	$query = "INSERT INTO files SET FilmID = '{$id}', Name = '{$filename}', MD5 = '{$filehash}', Path = '{$file}', Size = '{$filesize}'";
	$result = mysql_query($query);


    echo "<tr>";
    echo "<td>$file</td>";
    echo "<td>$filesize</td>";
    echo "</tr>";


}


echo "</tbody>";
echo "</table>";


break;
}

?>

</div>
        </body>

</html>
