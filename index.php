<?php

include 'utils.php';

use VisitorApp\App;

$visitor_unique_id = $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_USER_AGENT'];
$visitor_hash = md5($visitor_unique_id);

$connection = mysqli_connect(
    '127.0.0.1',
    'root',
    '',
    'test',
    '3306'
);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$app = new App($connection, $visitor_hash);

$app->setupDatabase();

if ($app->visitorExists()){
    $app->incrementVisitCount();
} else {
    $app->addVisitor();
}

$visitors = $app->getAll();
?>

<?php foreach ($visitors as $visitor): ?>
    <?= 'ID: ' . $visitor['hash']
    . ' Visit time: ' . $visitor['visited_at']
    . ' Visits: ' . $visitor['visits']
    . '<hr>';?>
<?php endforeach; ?>
