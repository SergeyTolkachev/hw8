<?php

try {
    $pdo = new PDO(
        'mysql:dbname=hw_8_Tolkachev;host=mysql',
        'root',
        'secret'
    );
} catch (Exception $e) {
    die('Database connection failed');
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'create table if not exists users (
    id int auto_increment,
    email varchar(100),
    tel varchar(50),
    primary key (id)
)';

try {
    $pdo->exec($sql);
} catch (Exception $error) {
    die('Cannot create userTest table. Reason: ' . $error->getMessage());
}



$sql2 = '
    insert into users set
        email = "sergei.tolkachev@ukr.net",
        tel = "380677777777"
';

$sql3 = '
    insert into users set
        email = "egor.petrov@i.ua",
        tel = "380933988888"
';

$sql4 = '
    insert into users set
        email = "emma.wotson@gmail.com",
        tel = "380955555555"
';

try {
    //$pdo->exec($sql);
    $pdo->exec($sql2);
    $pdo->exec($sql3);
    $pdo->exec($sql4);
} catch (Exception $error) {
    die('Cannot create test users. Reason: ' . $error->getMessage());
}

echo 'Migrate success';
