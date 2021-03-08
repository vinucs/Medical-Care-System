<?php        
    const URI = '1';
    const DATABASE_NAME = '1234';
    $client = new Mongo(URI);
    $database = $client->selectDB(DATABASE_NAME);
?>