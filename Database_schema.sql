create database IF NOT EXISTS `online_games` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `online_games`;

CREATE TABLE Product (
    Product_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(255) NOT NULL,
    pro_name VARCHAR(255),
    price DECIMAL(19 , 4 )
);

INSERT into Product values(1000,'console','Xbox 360',350.00);
INSERT into Product values(NULL,'console','PlayStation',150.00);
select * from Product;

INSERT into Product values(NULL,'console','PlayStation 3',250.00);
INSERT into Product values(NULL,'console','PlayStation 4',400.00);
INSERT into Product values(NULL,'games','Grand Theft Auto',400.00);
INSERT into Product values(NULL,'games','Grand Theft Auto',400.00);
INSERT into Product values(NULL,'games','Call duty Ghosts',900.00);
INSERT into Product values(NULL,'games','FarCry Primal',1400.00);
INSERT into Product values(NULL,'games','Division',2000.00);
INSERT into Product values(NULL,'games','Dirt Rally',1400.00);
INSERT into Product values(NULL,'games','Counter Strike',437.00);
INSERT into Product values(NULL,'games','Mario',400.00);
INSERT into Product values(NULL,'games','Battlefield',400.00);
INSERT into Product values(NULL,'accessories','Xbox one battery',400.00);
INSERT into Product values(NULL,'accessories','Xbox one battery',400.00);
INSERT into Product values(NULL,'accessories','Xbox one charger',300.00);
INSERT into Product values(NULL,'accessories','Xbox one controller',200.00);
INSERT into Product values(NULL,'accessories','PS4 battery',500.00);
INSERT into Product values(NULL,'accessories','PS4 battery',500.00);
INSERT into Product values(NULL,'accessories','PS4 charger',300.00);
INSERT into Product values(NULL,'accessories','PS4 controller',600.00);
INSERT into Product values(NULL,'accessories','Wii battery',400.00);
INSERT into Product values(NULL,'accessories','Wii battery',400.00);
INSERT into Product values(NULL,'accessories','Wii charger',300.00);
INSERT into Product values(NULL,'accessories','Wii controller',200.00);
INSERT into Product values(NULL,'accessories','Wii headset',200.00);

INSERT into Product values(NULL,'games','FarCry Primal',1390.00);
INSERT into Product values(NULL,'games','Division',2000.00);
INSERT into Product values(NULL,'games','Dirt Rally',1400.00);
INSERT into Product values(NULL,'games','Counter Strike',437.00);
INSERT into Product values(NULL,'games','Mario',400.00);
INSERT into Product values(NULL,'games','Battlefield',400.00);

INSERT into Product values(NULL,'accessories','PS3 battery,charger & controller set',700.00);
INSERT into Product values(NULL,'accessories','PS2 battery, charger & controller set',650.00);
INSERT into Product values(NULL,'accessories','PS2 battery, charger & controller set',650.00);



SELECT * FROM Product;
CREATE TABLE consoles
(
console_id Integer PRIMARY KEY,
drive_type varchar(255),
size Integer,
details varchar(255),
FOREIGN KEY (console_id)
    REFERENCES Product (product_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE accessories
(
accessory_id Integer PRIMARY KEY,
accessory_name varchar(255),
details varchar(255),
FOREIGN KEY (accessory_id)
    REFERENCES Product (product_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT into consoles values(1000, 'XBox 360',20,'popular video game');
INSERT into consoles values(1001, 'Playstation',20,'version 1. Size user upgradable.');
INSERT into consoles values(1002, 'Playstation 3',20,'version 3. Size user upgradable to 500GB.');
INSERT into consoles values(1003, 'Playstation 4',500,'version 4. Size user upgradable to 1TB.');
select * from consoles;

CREATE TABLE Games
(
Games_id Integer PRIMARY KEY,
games_name varchar(255),
min_memory_size Integer,
max_no_players Integer,
details varchar(255),
console_fk INTEGER,

FOREIGN KEY (Games_id)
    REFERENCES Product (product_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (console_fk)
    REFERENCES consoles (console_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT into Games values(1004, 'Grand Theft Auto',16,32,'version 5',1000);
INSERT into Games values(1005, 'Grand Theft Auto',8,16,'version 3',1001);
INSERT into Games values(1006, 'Call duty ghosts',3,12,'version 2',1003);
INSERT into Games values(1007, 'FarCry Primal',8,15,'version 3',1000);
INSERT into Games values(1008, 'Division',35,100,'version 3',1002);
INSERT into Games values(1009, 'Dirt Rally',18,15,'version 3',1000);
INSERT into Games values(1010, 'Counter Strike',8,8,'latest version 11',1000);
INSERT into Games values(1011, 'Mario',8,15,'version 5',1002);
INSERT into Games values(1012, 'Battlefield',8,15,'version 15',1003);

INSERT into Games values(1026, 'FarCry Primal',8,15,'version 4',1003);
INSERT into Games values(1027, 'Division',35,100,'version 3',1000);
INSERT into Games values(1028, 'Dirt Rally',18,15,'version 3',1003);
INSERT into Games values(1029, 'Counter Strike',8,8,'latest version 11',1003);
INSERT into Games values(1030, 'Mario',8,15,'version 5',1000);
INSERT into Games values(1031, 'Battlefield',8,15,'version 16',1000);


SELECT * FROM Games;

INSERT into accessories values(1013, 'Xbox one battery','varied sizes available. Great reviews.');
INSERT into accessories values(1014, 'Xbox one battery','largest size available. Great reviews.');
INSERT into accessories values(1015, 'Xbox one charger','In stock');
INSERT into accessories values(1016, 'Xbox one controller','black and metallic colors');
INSERT into accessories values(1017, 'PS4 battery','all sizes');
INSERT into accessories values(1018, 'PS4 battery','largest size');
INSERT into accessories values(1019, 'PS4 charger','extendible cord');
INSERT into accessories values(1020, 'PS4 controller','colors: black, red, gray, blue, white');
INSERT into accessories values(1021, 'Wii headset','Striker P1 Black');
INSERT into accessories values(1022, 'Wii battery','NS-GWII1106');
INSERT into accessories values(1023, 'Wii battery','NS-GWII1108');
INSERT into accessories values(1024, 'Wii charger','NS-GWII1106');
INSERT into accessories values(1025, 'Wii controller','WII U - GA');
INSERT into accessories values(1032,'PS3 battery,charger & controller set','All sizes & colors in stock.');
INSERT into accessories values(1033,'PS2 battery,charger & controller set','All sizes & colors in stock.');


CREATE TABLE customer
(
customer_id Integer PRIMARY KEY AUTO_INCREMENT,
customer_name varchar(255),
customer_phone varchar(10),
address varchar(255)
);

CREATE TABLE customer_orders
(
order_id Integer PRIMARY KEY AUTO_INCREMENT,
date_order date,
product Integer,
product_count Integer,
customer Integer,
order_status varchar(255),
FOREIGN KEY (customer)
    REFERENCES customer (customer_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (product)
    REFERENCES Product (product_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

insert into customer values(100,'Mona','3124578125',"7634 Calvert Road, College Park- 20743");
insert into customer values(NULL,'Shell','2404576559',"6354 42nd Ave, College Park- 20787, Maryland");
insert into customer values(NULL,'Lisa','4504576559',"3154 43rd Ave, Boston- 42687, Massachussets");
insert into customer values(NULL,'Mishika','7694578125',"6528 New York Ave, DC- 52483");
insert into customer values(NULL,'Stella','7204576559',"7251 Austria Street,Texas");
insert into customer values(NULL,'Lisa','4504576559',"5491 3rd street, Alexandria, Virginia");
insert into customer values(NULL,'Sam','7255781252',"Calvert Road, Blacksburg- 82074, Virginia");
insert into customer values(NULL,'Arthur','2404576559',"6154 48th Ave, Syracuse, New York");
insert into customer values(NULL,'Coleman','8234576559',"3154 46th Ave, Boston- 42679, Massachussets");
insert into customer values(NULL,'Pujita','3012409921',"8125 48th Ave, College Park- 20740, Maryland");
insert into customer values(NULL,'Colin','4054576559',"7554 84th Ave, New Carrolton, Maryland");
insert into customer values(NULL,'Glowman','5634576559',"3154 46th Ave, Boston- 42679, Massachussets");
insert into customer values(NULL,'Bradley','2407629921',"8125 48th Ave, College Park- 20740, Maryland");
insert into customer values(NULL,'Kunal','2407629929',"3154 46th Ave, Bethesda- 29831, Maryland");
insert into customer values(NULL,'Hugh Jackman','2439627921',"8128 48th Ave, Landmark Ave- 20740, Maryland");
 
insert into customer_orders values(200,'2015-09-29',1024,1,105,"delivered");
insert into customer_orders values(NULL,'2016-02-25',1006,2,104,"aborted");
insert into customer_orders values(NULL,'2016-03-02',1002,1,107,"delivered");
insert into customer_orders values(NULL,'2016-04-23',1010,2,100,"delivered");
insert into customer_orders values(NULL,'2016-05-23',1017,3,104,"ordered");
insert into customer_orders values(NULL,'2016-05-22',1011,1,103,"ordered");
insert into customer_orders values(NULL,'2016-05-19',1011,2,101,"delivered");
insert into customer_orders values(NULL,'2016-05-14',1021,4,103,"delivered");
insert into customer_orders values(NULL,'2016-05-23',1017,1,102,"ordered");
insert into customer_orders values(NULL,'2016-05-21',1016,1,103,"ordered");
insert into customer_orders values(NULL,'2016-04-27',1011,1,101,"delivered");
insert into customer_orders values(NULL,'2016-05-14',1023,1,103,"delivered");
insert into customer_orders values(NULL,'2016-03-23',1017,1,102,"delivered");
insert into customer_orders values(NULL,'2016-05-22',1015,1,103,"ordered");
insert into customer_orders values(NULL,'2016-05-09',1013,2,101,"delivered");
insert into customer_orders values(NULL,'2016-05-04',1021,1,107,"delivered");


insert into customer_orders values(NULL,'2016-06-25',1023,1,109,"delivered");
insert into customer_orders values(NULL,'2016-06-02',1028,2,108,"delivered");
insert into customer_orders values(NULL,'2016-05-22',1011,2,110,"delivered");

insert into customer_orders values(NULL,'2016-05-23',1019,1,114,"delivered");
insert into customer_orders values(NULL,'2016-05-22',1013,1,108,"ordered");
insert into customer_orders values(NULL,'2016-05-29',1021,2,111,"delivered");
insert into customer_orders values(NULL,'2016-05-14',1021,1,103,"delivered");
insert into customer_orders values(NULL,'2016-05-23',1017,1,109,"ordered");
insert into customer_orders values(NULL,'2016-06-21',1026,2,102,"ordered");
insert into customer_orders values(NULL,'2016-05-27',1031,1,111,"delivered");
insert into customer_orders values(NULL,'2016-05-14',1021,2,113,"delivered");
insert into customer_orders values(NULL,'2016-03-23',1019,1,106,"delivered");
insert into customer_orders values(NULL,'2016-05-22',1018,1,108,"ordered");
insert into customer_orders values(NULL,'2016-05-19',1014,1,101,"delivered");
insert into customer_orders values(NULL,'2016-05-21',1019,1,107,"delivered");

SELECT * FROM customer_orders;

CREATE TABLE Product_inventory (
Product_id INTEGER PRIMARY KEY,
product_count INTEGER,
FOREIGN KEY (Product_id)
    REFERENCES Product (product_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE Product_inventory
ADD constraint CHECK(product_count>0) ;

insert into Product_inventory values(1000, 25);
insert into Product_inventory values(1001, 25);
insert into Product_inventory values(1002, 25);
insert into Product_inventory values(1003, 25);
insert into Product_inventory values(1004, 25);
insert into Product_inventory values(1005, 25);
insert into Product_inventory values(1006, 25);
insert into Product_inventory values(1007, 25);
insert into Product_inventory values(1008, 25);
insert into Product_inventory values(1009, 25);
insert into Product_inventory values(1010, 25);
insert into Product_inventory values(1011, 25);
insert into Product_inventory values(1012, 25);
insert into Product_inventory values(1013, 25);
insert into Product_inventory values(1014, 25);
insert into Product_inventory values(1015, 25);
insert into Product_inventory values(1016, 25);
insert into Product_inventory values(1017, 25);
insert into Product_inventory values(1018, 25);
insert into Product_inventory values(1019, 25);
insert into Product_inventory values(1020, 25);
insert into Product_inventory values(1021, 25);
insert into Product_inventory values(1022, 25);
insert into Product_inventory values(1023, 25);
insert into Product_inventory values(1024, 25);
insert into Product_inventory values(1025, 25);
insert into Product_inventory values(1026, 25);
insert into Product_inventory values(1027, 25);
insert into Product_inventory values(1028, 25);
insert into Product_inventory values(1029, 25);
insert into Product_inventory values(1030, 25);
insert into Product_inventory values(1031, 25);
insert into Product_inventory values(1032, 25);
insert into Product_inventory values(1033, 25);

insert into Product_inventory values(1034, 25);
select * from Product_inventory;

/*WRITE TRIGGERS FOR INSERT/ UPDATE INTO CUSTOMER ORDERS, WHEN STATUS = ORDERED SO 
THAT IT DECREMENTS COUNT FROM PRODUCT_INVENTORY FOR THAT PRODUCT
WITH THE CONDITION THAT IF STATUS IS UPDATED TO ABORT, IT SHOULD INCREMENT THE COUNT BACK
AS THE PLACED ORDER IS NOW ABORTED,
NO CHANGES TO BE MADE IF STATUS = */
/*Also if the count of order made is less than available, transaction shouldn't get through*/
DROP TRIGGER prod_order_insert;
DROP TRIGGER prod_order_update;


/* No trigger for aborted during insertion bcz new order with aborted status simply means no change to database  */
delimiter |
CREATE TRIGGER prod_order_insert BEFORE INSERT ON customer_orders
FOR EACH ROW
BEGIN
	
	UPDATE Product_inventory set product_count = product_count - new.product_count where  Product_inventory.Product_id = New.product AND New.order_status ='ordered';
	UPDATE Product_inventory set product_count = product_count - new.product_count where  Product_inventory.Product_id = New.product AND New.order_status ='delivered';
END;
|
delimiter ;

/* 
 update when there is change of product count  or when there is an order status change. I am assuming that changes should be made only when \
order status will be changed from ordered to aborted, or from aborted to ordered or delivered. No one will make a change from delivered to ordered/aborted    */
delimiter |
CREATE TRIGGER prod_order_update BEFORE UPDATE  ON customer_orders
FOR EACH ROW
BEGIN
if OLD.product_count <> new.product_count  Then
	UPDATE Product_inventory set product_count = product_count - new.product_count + OLD.product_count where  Product_inventory.Product_id = New.product;

elseif OLD.order_status <> new.order_status Then
	if OLD.order_status = 'ordered' Then
		UPDATE Product_inventory set product_count = product_count + new.product_count  where  Product_inventory.Product_id = New.product AND New.order_status ='aborted';

    elseif OLD.order_status = 'aborted'  Then
		UPDATE Product_inventory set product_count = product_count - new.product_count where  Product_inventory.Product_id = New.product AND New.order_status ='delivered';
        UPDATE Product_inventory set product_count = product_count - new.product_count where  Product_inventory.Product_id = New.product AND New.order_status ='ordered';
    end if;

	
end if;

END;
|
delimiter ;

