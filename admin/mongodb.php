<?php
    $URI = '127.0.0.1:27017/';
    $DATABASE_NAME = 'db_spi';
    #$client = new MongoDB\Driver\Manager($URI);
    $client = new Mongo($URI);
    $database = $client->selectDB($DATABASE_NAME);
?>