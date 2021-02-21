<?php

namespace DB;

class App {
    private $connection;
    const UNIQUE_PRODUCTS=0;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function checkQuery(){
        if (mysqli_errno($this->connection)){
            die('Query failed: ' . mysqli_error($this->connection));
        }
    }

    function createTable($sql){
        mysqli_query($this->connection, $sql);
        $this->checkQuery();
    }

    function setupDatabase(){
        $tables_sql = [
            'create table if not exists products (id INT PRIMARY KEY, name VARCHAR(50)) ENGINE = InnoDB;',
            'create table if not exists clients (id INT PRIMARY KEY, name VARCHAR(50)) ENGINE = InnoDB;',
            'create table if not exists orders (id INT PRIMARY KEY, count INT NOT NULL, product_id INT NOT NULL, client_id INT NOT NULL, FOREIGN KEY (client_id) REFERENCES clients(id), FOREIGN KEY (product_id) REFERENCES products(id)) ENGINE = InnoDB;'
        ];
        foreach ($tables_sql as $table_sql) {
            $this->createTable($table_sql);
        }
    }

    function tableIsEmpty($table_name){
        $sql = "SELECT * FROM $table_name";
        $result = mysqli_query($this->connection, $sql);
        return mysqli_num_rows($result) === 0;
    }

    function createMockData(){
        $products = [
            "(1, 'Onions - Cippolini')",
            "(2, 'Buffalo - Tenderloin')",
            "(3, 'Beef - Top Butt Aaa')",
            "(4, 'Veal - Striploin')",
            "(5, 'Table Cloth 62x120 White')",
            "(6, 'Grapes - Black')",
            "(7, 'Beef - Inside Round')",
            "(8, 'Pork - Butt, Boneless')",
            "(9, 'Mushroom - Lg - Cello')",
            "(10, 'Iced Tea Concentrate')",
        ];
        $clients = [
            "(1, 'Livvyy')",
            "(2, 'Luce')",
            "(3, 'Clevie')",
            "(4, 'Corney')",
            "(5, 'Merwyn')",
            "(6, 'Rand')",
            "(7, 'Hildegarde')",
            "(8, 'Isidore')",
            "(9, 'Iormina')",
            "(10, 'Shay')",
        ];
        $orders = [
            "(1, 5, 7, 10)",
            "(2, 4, 6, 10)",
            "(3, 2, 9, 8)",
            "(4, 4, 8, 5)",
            "(5, 1, 1, 10)",
            "(6, 3, 8, 6)",
            "(7, 4, 9, 2)",
            "(8, 3, 7, 7)",
            "(9, 2, 10, 3)",
            "(10, 2, 9, 3)",
            "(11, 1, 2, 10)",
            "(12, 3, 5, 10)",
            "(13, 2, 4, 10)",
            "(14, 2, 9, 3)",
            "(15, 2, 9, 3)",
            "(16, 2, 3, 3)",
            "(17, 2, 4, 3)",
        ];

        $schema = [
            [
                'name' => 'clients',
                'fields' => [
                    'id',
                    'name'
                ],
                'data' => $clients
            ],
            [
                'name' => 'products',
                'fields' => [
                    'id',
                    'name'
                ],
                'data' => $products
            ],
            [
                'name' => 'orders',
                'fields' => [
                    'id',
                    'count',
                    'product_id',
                    'client_id'
                ],
                'data' => $orders
            ],
        ];

        foreach ($schema as $details){
            $table_name = $details['name'];
            if($this->tableIsEmpty($table_name)){
                $fields = implode(',', $details['fields']);
                $data = implode(',', $details['data']);
                $sql = "INSERT INTO {$table_name}({$fields}) VALUES {$data}";
                mysqli_query($this->connection, $sql);
                $this->checkQuery();
            }
        }
    }

    function getClients($purchase_count_min, $type){
        $products_type = ($type === $this::UNIQUE_PRODUCTS ? 'distinct ' : '') . 'p.name';
        $sql = <<<EOT
select
       c.name client_name,
       count($products_type) product_types_count
from orders o
inner join clients c on o.client_id = c.id
inner join products p on o.product_id = p.id
group by
         c.name
having product_types_count >= $purchase_count_min;
EOT;
        $result = mysqli_query($this->connection, $sql);
        $this->checkQuery();
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}
