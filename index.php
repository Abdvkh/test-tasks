<?php
require 'utils.php';

use DB\App;

define('UNIQUE_PRODUCTS', 0);
$config = include('config.php');

$connection = mysqli_connect(
    $config['HOST'],
    $config['USER'],
    $config['PASSWORD'],
    $config['DATABASE'],
    $config['PORT']
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
