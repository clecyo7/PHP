<?php
// Configurações de conexão com o banco de dados
$servername = 'localhost';
$username = 'root'; // substitua por seu usuário do banco de dados
$password = 'admin'; // substitua por sua senha do banco de dados
$dbname = 'series_tv';

try {
    // Conexão com o banco de dados
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Selecionar o banco de dados
    $conn->exec("USE $dbname");

   
    $datetime = isset($_GET['datetime']) ? $_GET['datetime'] : '';
    $series = isset($_GET['seriesId']) ? $_GET['seriesId'] : '';

   
    $sql = "SELECT * FROM series_tv";
    $whereClause = '';
    $sql2 = "SELECT * FROM series_tv_intervalos";

    if (!empty($datetime) && empty($series)) {
        $sql = $sql2;
        $whereClause = " INNER JOIN series_tv on series_tv_intervalos.id_serie_tv = series_tv.id
                         ORDER BY ABS(dia_da_semana - DAYOFWEEK('$datetime'))
                         LIMIT 1";
    } elseif (empty($datetime) && !empty($series)) {
        $whereClause = " WHERE series_tv.id = $series";
    } elseif (!empty($datetime) && !empty($series)) {
        $sql = $sql2;
        $whereClause = " INNER JOIN series_tv on series_tv_intervalos.id_serie_tv = series_tv.id
                         ORDER BY ABS(dia_da_semana - DAYOFWEEK('$datetime'))
                         LIMIT 1";
    }

    if (!empty($whereClause)) {
        $sql .= $whereClause;
    }

    // Executar a consulta SQL
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode($result); // Retornar os dados encontrados como JSON
    } else {
        echo json_encode([]); // Retornar um array vazio caso nenhum resultado seja encontrado
    }
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
}
