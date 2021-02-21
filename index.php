<?php
define('UNIQUE_PRODUCTS', 0);

require 'utils.php';

use DB\App;

$visitor_unique_id = $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_USER_AGENT'];
$visitor_hash = md5($visitor_unique_id);

$connection = mysqli_connect(
    '127.0.0.1',
    'root',
    '',
    'testtaskdb',
    '3306'
);

/* check connection */
if (mysqli_connect_errno()) {
    die("Connect failed: %s\n" . mysqli_connect_error());
}

$app = new App($connection);

$app->setupDatabase();
$app->createMockData();
$clients = $app->getClients(3, UNIQUE_PRODUCTS);
?>

<?php foreach ($clients as $client): ?>
    <?= 'Name: ' . $client['client_name']
    . ' Products count: ' . $client['product_types_count']
    . '<hr>';?>
<?php endforeach; ?>
