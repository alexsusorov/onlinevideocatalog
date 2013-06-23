<html>
<head>
    <meta content="text/html; charset=windows-1251" http-equiv="Content-Type"/>
    <title>Sphinx search for Wordpress</title>
</head>
<body>

<form action="" method="get">
    <input name="s" size="40" value="" />
    <input type="submit" value="Search!" />
</form>

<?php

error_reporting(E_ALL);

echo ($_GET['s']);

    if (isset($_GET['s']) and strlen($_GET['s']) > 2) {

    
    // Подключаем sphinx-api
    require_once ("lib/sphinxapi.php");
    
    // Искомая комбинация
    $string = $_GET['s'];

echo $string;

    // Создаем объект клиента для Sphinx API
    $sphinx = new SphinxClient();
    // Подсоединяемся к Sphinx-серверу
    $sphinx->SetServer('localhost', 9312);

    $sphinx->GetLastError();
    $sphinx->GetLastWarning();
    
    // Совпадение по любому слову
    $sphinx->SetMatchMode(SPH_MATCH_ANY);
    
    // Результаты сортировать по релевантности
    $sphinx->SetSortMode(SPH_SORT_RELEVANCE);
    
    // Задаем полям веса (для подсчета релевантности)
    $sphinx->SetFieldWeights(array ('Name' => 20, 'OriginalName' => 15, 'Description' => 10));

    // Результат по запросу (* - использование всех индексов)
    $result = $sphinx->Query($string, '*');
    
    // Если есть результаты поиска, то
    if ($result && isset($result['matches']))
    {

        // Соединяемся с БД
        mysql_connect('localhost', 'online_ro', 'zwdWvxSMZpV6A9YL');
        mysql_select_db('online');

        // Устанавливаем кодировки
        mysql_query('SET NAMES cp1251');
        mysql_query('SET CHARACTER SET cp1251');
        
        // Получаем массив ID постов блога
        $ids = array_keys($result['matches']);

        // Выводим посты отсортированные по релевантности
        $id_list = implode(',', $ids);
        $sql = '
            SELECT `ID`, `Name`, `OriginalName`, `Description`
                FROM `films`
                WHERE `ID` IN ('.$id_list.')
                ORDER BY FIELD(`ID`, '.$id_list.')';

        $resource = mysql_query($sql);

        // Выводим результаты поиска
        echo '<ol>';
        while ($result = mysql_fetch_assoc($resource)) {
            echo '<li><span><a href="?page=video&id='.$result['ID'].'">'.$result['Name'].'</a></span><div>'.mb_substr(htmlspecialchars($result['Description']), 0, 400).'</div>';
        }
        echo '</ol>';
    }
}
?>
</body>
</html>
