<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=optimis7_bbfdccdb2;charset=utf8mb4', 'optimis7_bb', 'P.gf2G36vHL7MEzuJBS66');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "Connection failed : ". $e->getMessage();
}
    /*** Base URL ***/
    $url= "https://www.brightbeginningsfdcc.com.au/portal/";
?>