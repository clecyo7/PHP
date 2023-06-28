<?php
// Configurações de conexão com o banco de dados
$servername = 'localhost';
$username = 'root'; // substitua por seu user do banco de dados 
$password = 'admin'; // substitua por sua senha do banco de dados
$dbname = 'series_tv';

try {
    //Conexão com o banco de dados
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("USE $dbname");

    // Verificar se as tabelas já existem
    $tablesExist = $conn->query("SHOW TABLES LIKE 'series_tv'")->rowCount() > 0 &&
        $conn->query("SHOW TABLES LIKE 'series_tv_intervalos'")->rowCount() > 0;

    if (!$tablesExist) {
      
        $conn->exec("CREATE TABLE series_tv (
            id INT PRIMARY KEY AUTO_INCREMENT,
            titulo VARCHAR(255) NOT NULL,
            canal VARCHAR(255) NOT NULL,
            genero VARCHAR(255) NOT NULL
        )");

        $conn->exec("CREATE TABLE series_tv_intervalos (
            id_serie_tv INT,
            dia_da_semana INT NOT NULL,
            horario TIME NOT NULL,
            FOREIGN KEY (id_serie_tv) REFERENCES series_tv(id)
        )");

        echo "Tabelas criadas com sucesso!\n";
    }
        $conn->exec("INSERT INTO series_tv (titulo, canal, genero) VALUES
        ('Chicago Med', 'Fox', 'Drama'),
        ('Prison Break', 'HBO', 'Acao'),
        ('A Escuta', 'Globo Play', 'Drama')");

        $conn->exec("INSERT INTO series_tv_intervalos (id_serie_tv, dia_da_semana, horario) VALUES
        (1, 1, '20:00:00'),
        (2, 2, '19:30:00'),
        (3, 3, '21:00:00')");
        echo 'Dados inseridos com sucesso!';
    
} catch (PDOException $e) {
    echo 'Erro ao criar o banco de dados e as tabelas: ' . $e->getMessage();
}
