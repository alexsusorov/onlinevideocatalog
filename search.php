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

    
    // ���������� sphinx-api
    require_once ("lib/sphinxapi.php");
    
    // ������� ����������
    $string = $_GET['s'];

echo $string;

    // ������� ������ ������� ��� Sphinx API
    $sphinx = new SphinxClient();
    // �������������� � Sphinx-�������
    $sphinx->SetServer('localhost', 9312);

    $sphinx->GetLastError();
    $sphinx->GetLastWarning();
    
    // ���������� �� ������ �����
    $sphinx->SetMatchMode(SPH_MATCH_ANY);
    
    // ���������� ����������� �� �������������
    $sphinx->SetSortMode(SPH_SORT_RELEVANCE);
    
    // ������ ����� ���� (��� �������� �������������)
    $sphinx->SetFieldWeights(array ('Name' => 20, 'OriginalName' => 15, 'Description' => 10));

    // ��������� �� ������� (* - ������������� ���� ��������)
    $result = $sphinx->Query($string, '*');
    
    // ���� ���� ���������� ������, ��
    if ($result && isset($result['matches']))
    {

        // ����������� � ��
        mysql_connect('localhost', 'online_ro', 'zwdWvxSMZpV6A9YL');
        mysql_select_db('online');

        // ������������� ���������
        mysql_query('SET NAMES cp1251');
        mysql_query('SET CHARACTER SET cp1251');
        
        // �������� ������ ID ������ �����
        $ids = array_keys($result['matches']);

        // ������� ����� ��������������� �� �������������
        $id_list = implode(',', $ids);
        $sql = '
            SELECT `ID`, `Name`, `OriginalName`, `Description`
                FROM `films`
                WHERE `ID` IN ('.$id_list.')
                ORDER BY FIELD(`ID`, '.$id_list.')';

        $resource = mysql_query($sql);

        // ������� ���������� ������
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
