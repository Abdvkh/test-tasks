# Test task
CREATE DATABASE IF NOT EXISTS `testtaskdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `testtaskdb`;

## products
create table products (
                          id INT PRIMARY KEY,
                          name VARCHAR(50)
);
insert into products (id, name) values (1, 'Onions - Cippolini');
insert into products (id, name) values (2, 'Buffalo - Tenderloin');
insert into products (id, name) values (3, 'Beef - Top Butt Aaa');
insert into products (id, name) values (4, 'Veal - Striploin');
insert into products (id, name) values (5, 'Table Cloth 62x120 White');
insert into products (id, name) values (6, 'Grapes - Black');
insert into products (id, name) values (7, 'Beef - Inside Round');
insert into products (id, name) values (8, 'Pork - Butt, Boneless');
insert into products (id, name) values (9, 'Mushroom - Lg - Cello');
insert into products (id, name) values (10, 'Iced Tea Concentrate');

## clients
create table clients (
                         id INT PRIMARY KEY,
                         name VARCHAR(50)
);
insert into clients (id, name) values (1, 'Livvyy');
insert into clients (id, name) values (2, 'Luce');
insert into clients (id, name) values (3, 'Clevie');
insert into clients (id, name) values (4, 'Corney');
insert into clients (id, name) values (5, 'Merwyn');
insert into clients (id, name) values (6, 'Rand');
insert into clients (id, name) values (7, 'Hildegarde');
insert into clients (id, name) values (8, 'Isidore');
insert into clients (id, name) values (9, 'Iormina');
insert into clients (id, name) values (10, 'Shay');

## orders
create table orders (
                        id INT PRIMARY KEY,
                        count INT NOT NULL,
                        product_id INT NOT NULL,
                        client_id INT NOT NULL,
                        FOREIGN KEY (client_id) REFERENCES clients(id),
                        FOREIGN KEY (product_id) REFERENCES products(id)
);
insert into orders (id, count, product_id, client_id) values (1, 5, 7, 10);
insert into orders (id, count, product_id, client_id) values (2, 4, 6, 10);
insert into orders (id, count, product_id, client_id) values (3, 2, 9, 8);
insert into orders (id, count, product_id, client_id) values (4, 4, 8, 5);
insert into orders (id, count, product_id, client_id) values (5, 1, 1, 10);
insert into orders (id, count, product_id, client_id) values (6, 3, 8, 6);
insert into orders (id, count, product_id, client_id) values (7, 4, 9, 2);
insert into orders (id, count, product_id, client_id) values (8, 3, 7, 7);
insert into orders (id, count, product_id, client_id) values (9, 2, 10, 3);
insert into orders (id, count, product_id, client_id) values (10, 2, 9, 3);
insert into orders (id, count, product_id, client_id) values (11, 1, 2, 10);
insert into orders (id, count, product_id, client_id) values (12, 3, 5, 10);
insert into orders (id, count, product_id, client_id) values (13, 2, 4, 10);
insert into orders (id, count, product_id, client_id) values (14, 2, 9, 3);
insert into orders (id, count, product_id, client_id) values (15, 2, 9, 3);
insert into orders (id, count, product_id, client_id) values (16, 2, 3, 3);
insert into orders (id, count, product_id, client_id) values (17, 2, 4, 3);

# retrieve solely those clients who has ordered more than 3 unique products
select
    c.name client_name,
    count(distinct p.name) product_types_count
from orders o
         inner join clients c on o.client_id = c.id
         inner join products p on o.product_id = p.id
group by
    c.name
having product_types_count >= 3;