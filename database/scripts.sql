create database if not exists BIG_CART;

use  BIG_CART;


CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullName VARCHAR(255),
  password VARCHAR(255),
  email VARCHAR(255),
  phoneNumber VARCHAR(20),
  birthday DATE,
  
  createAt DATETIME,
  historySearch JSON,
  address VARCHAR(255),
  message TEXT,
  status BOOLEAN
);
ALTER TABLE users
ADD verified BIT DEFAULT 0;
ALTER TABLE users
DROP COLUMN total;

DELETE FROM favorites
WHERE userId IN (SELECT id FROM users WHERE email = 'tuananhwk2k3@gmail.com');

DELETE FROM users
WHERE email = 'tuananhwk2k3@gmail.com';

create table if not exists reset_password (
    id INT PRIMARY KEY AUTO_INCREMENT,
    token VARCHAR(500) NOT NULL,
    createdAt DATETIME NOT NULL DEFAULT NOW(),
    email VARCHAR(500) NOT NULL,
    available BIT DEFAULT 1
);


insert into users (id, fullName, email, password, phoneNumber, birthday) 
values ( id, 'Tuan Anh', 'anhttps24524@gmail.com', 'abcd', '0921011337', '2003-01-05');

-- categories
create table if not exists categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(500) NOT NULL,
    image VARCHAR(5000) NOT NULL,
    bgColor VARCHAR(5000) NOT NULL
);
UPDATE categories
SET image = 'https://firebasestorage.googleapis.com/v0/b/bigcart-49953.appspot.com/o/household.png?alt=media&token=57a1bc85-8075-49ad-a485-6f24926c39ef'
WHERE id = 6;

insert into categories (id, name, image, bgColor) values (1, "Vegetables", "https://firebasestorage.googleapis.com/v0/b/bigcart-d1f2f.appspot.com/o/categories%2Fvegetable.png?alt=media&token=5946d475-e6e0-4890-80c4-5c533d74870e", "#E6F2EA");
insert into categories (id, name, image, bgColor) values (2, "Fruits", "https://firebasestorage.googleapis.com/v0/b/bigcart-d1f2f.appspot.com/o/categories%2Fapple.png?alt=media&token=b6632335-0f8c-4289-92ef-b4cec30c30c3", "#FFE9E5");
insert into categories (id, name, image, bgColor) values (3, "Beverages", "https://firebasestorage.googleapis.com/v0/b/bigcart-d1f2f.appspot.com/o/categories%2Fbeverage.png?alt=media&token=ef80ceea-04c7-4082-bf4f-c6887a10fcd1", "#FFF6E3");
insert into categories (id, name, image, bgColor) values (4, "Grocery", "https://firebasestorage.googleapis.com/v0/b/bigcart-d1f2f.appspot.com/o/categories%2Fgrocery.png?alt=media&token=1862de41-2116-418f-a494-09859fa09c39", "#F3EFFA");
insert into categories (id, name, image, bgColor) values (5, "Edible oil", "https://firebasestorage.googleapis.com/v0/b/bigcart-d1f2f.appspot.com/o/categories%2Foil.png?alt=media&token=01176666-01e8-418a-9cd0-02c6c0ba8b53", "#DCF4F5");
insert into categories (id, name, image, bgColor) values (6, "Household", "https://firebasestorage.googleapis.com/v0/b/bigcart-d1f2f.appspot.com/o/categories%2Fhousehold.png?alt=media&token=29b57f72-14da-42cb-9137-fb8cb829255f", "#FFE8F2");


--  product
create table if not exists products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    statusProduct VARCHAR(100) NOT NULL,
    price DOUBLE NOT NULL,
    weight DOUBLE NOT NULL,
    purchaseQuantity Long,
    image VARCHAR(5000) NOT NULL,
    description VARCHAR(5000) NOT NULL,
    quantity INT NOT NULL,
    -- FK
    categoryId INT NOT NULL,
    FOREIGN KEY (categoryId) REFERENCES categories(id)
);

-- CATEGORY 1 VEGETABLE
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (7, 'Cabbage', "New", 1, 300, 130, "https://www.bordbia.ie/globalassets/bordbia2020/food-and-living/best-in-season-2020/veg/cabbage.png", 
'Cabbage (Brassica oleracea) is a cruciferous vegetable. It is a leafy green or purple biennial plant, grown as an annual vegetable crop for its dense-leaved heads. Very firm, small heads are used for canning. The outer coarse leaves and the core are removed.', 
10,  1);

insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (8, 'Cauliflower ', "New", 1, 300, 130, "https://www.dole.com/-/media/project/dole/produce-images/vegetables/cauliflower_web.png?rev=0e69b74ac3bf4fd1a98a9eee02e52b39&hash=4F03A1648EF3FFC55F983E414F4A89E1", 
'Cauliflowers are annual plants that reach about 0.5 metre (1.5 feet) tall and bear large rounded leaves that resemble collards (Brassica oleracea, variety acephala). As desired for food, the terminal cluster forms a firm, succulent “curd,” or head, that is an immature inflorescence (cluster of flowers).', 
10,  1);

insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (9, 'Lettuce ', "-22%", 1, 300, 130, "https://herbivore.com.ph/cdn/shop/products/CrystalLettuceTemp_grande.png?v=1618294495", 
'lettuce, (Lactuca sativa), annual leaf vegetable of the aster family (Asteraceae). Most lettuce varieties are eaten fresh and are commonly served as the base of green salads. Lettuce is generally a rich source of vitamins K and A, though the nutritional quality varies, depending on the variety.', 
10,  1);

insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (10, 'Broccoli ', "-14%", 1, 300, 130, "https://images.squarespace-cdn.com/content/v1/5a8212f5e9bfdff7bedd9efb/1633565782837-B8847PL2GWSD76LBQY64/broccoli+crowns.png", 
'Fresh broccoli should be dark green in colour, with firm stalks and compact bud clusters. Broccoli is a fast-growing annual plant that grows 60–90 cm (24–35 inches) tall. Upright and branching with leathery leaves, broccoli bears dense green clusters of flower buds at the ends of the central axis and the branches.', 
10,  1);

insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (11, 'Amaranth ', "New", 1, 300, 130, "https://product.hstatic.net/200000240163/product/dentia_702ddfb8256449698d47f5f0ddcd9c93_master.png", 
'Amaranths are branching broad-leaved plants with egg-shaped or rhombic leaves which may be smooth or covered in tiny hairs. The leaves have prominent veins, can be green or red in color and have long petioles. The plants produce single flowers on terminal spikes which typically red to purple in color.', 
10,  1);

insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (12, 'Celery ', "-5%", 1, 300, 130, "https://www.dole.com/-/media/project/dole/produce-images/vegetables/celeryhearts_web.png?rev=85a4a7aad8a3427d8544ca6c064b2fd5&hash=6DF49DD4D84FB2B6C24CB049D520CA15", 
'It has wide parsley-like green leaves and thick, juicy, ribbed stalks that join at a common base above the root. Celery, at its best, has a juicy and crunchy flesh with a mild salty flavor. Although celery is most often used for its stalks, its leaves are edible as well and have a concentrated celery-flavor.', 
10,  1);

-- CATEGORY 2 FRUIT
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (1, 'Peach', "New", 1, 300, 130, "https://billsberryfarm.com/wp-content/uploads/2020/08/peach.png", 
'A peach is a very sweet, juicy fruit with an edible peel and a hard pit in the middle. Peaches vary in color from almost white to yellow and pinkish-red. Peaches grow on trees in temperate climates — they need warm weather, but they also require a hard freeze in the winter to produce fruit.', 
10,  2);
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (2, 'Apple', "-18%", 0.5, 500, 220, "https://www.applesfromny.com/wp-content/uploads/2020/06/SnapdragonNEW.png", 
'The apple is one of the pome (fleshy) fruits. Apples at harvest vary widely in size, shape, colour, and acidity, but most are fairly round and some shade of red or yellow. The thousands of varieties fall into three broad classes: cider, cooking, and dessert varieties.', 
10,  2);
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (3, 'Pineapple', "-5%", 2, 500, 100, 'https://sicarfarms.com/wp-content/uploads/2021/01/Pineapple.png', 
'Pineapples have yellow or white pulp, fleshy, aromatic, juicy and sweet. In the fruit there is a fibrous axis that extends from the crown to the pedicle. Mature pineapples have a very singular fragrance, a beautiful colour and pleasant bittersweet taste.', 
10,  2);
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (4, 'Avocado', "-10%", 2, 500, 120, 'https://readytoeat.eu/images/buy-fresh-ripe-avocados.png', 
'Avocado fruits have greenish or yellowish flesh with a buttery consistency and a rich nutty flavour. They are often eaten in salads, and in many parts of the world they are eaten as a dessert. Mashed avocado is the principal ingredient of guacamole, a characteristic saucelike condiment in Mexican cuisine.', 
10,  2);
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (5, 'Grapes', "New", 2, 500, 150, 'https://tomavo.ca/wp-content/uploads/2020/07/grapes-red-500x500-1.png', 
'A grape is a fruit, botanically a berry, of genus Vitis and family Vitaceae. Grapes grow in clusters of 15–300 in different colors (crimson, black, dark blue, yellow, green, orange, pink, and white) and are specifically a nonclimacteric type and deciduous crop.', 
10,  2);
insert into products (id, name, statusProduct, price, weight, purchaseQuantity, image, description, quantity, categoryId) 
values (6, 'Pomegranates', "-20%", 2, 500, 200, 'https://dtgxwmigmg3gc.cloudfront.net/imagery/assets/derivations/icon/512/512/true/eyJpZCI6IjRkODc5NTdkZmJhOGJjNWUzMTY3MGUyMTM4MTEyZTI1LmpwZyIsInN0b3JhZ2UiOiJwdWJsaWNfc3RvcmUifQ?signature=e616ea4f646279963c22ff8e9e94faa11f922eb7122b3e7f3321806a11661a5b', 
'The fruit is the size of a large orange, obscurely six-sided, with a smooth leathery skin that ranges from brownish yellow to red; within, it is divided into several chambers containing many thin transparent arils of reddish, juicy pulp, each surrounding an angular elongated seed.', 
10,  2);

CREATE TABLE favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT,
    productId INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (productId) REFERENCES products(id)
);

CREATE TABLE carts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userId INT,
    productId INT,
    quantityProduct INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id),
    FOREIGN KEY (productId) REFERENCES products(id)
);
ALTER TABLE carts
ADD total DOUBLE;




create table if not exists comments (
    id INT KEY AUTO_INCREMENT,
    content VARCHAR(500) NOT NULL,
    listImg TEXT[],
    createAt DATETIME DEFAULT NOW(),
    productID INT NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (productID) REFERENCES products(id)
    FOREIGN KEY (userID) REFERENCES users(id)
)

insert into users (id, fullName, email, password) values (2, 'Gilemette', 'ghurll1@virginia.edu', 'jI3!wAW&Ebqwx)P');

insert into users (id, fullName, email, password, phoneNumber, birthday) 
values ( id, 'Berkley', 'bfoort0@google.es', 'gY4+&rBI)zlPyH', '0921011337', '2003-01-05');

insert into users (id, fullName, email, password, phoneNumber, birthday) 
values (2, 'Tuan Anh', 'abc@gmail.com', 'abcd', '0921011337', '2003/01/05');


insert into categories (id, name, image) values (1, 'Điện thoại', 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg');
insert into categories (id, name, image) values (2, 'Laptop', 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg');
insert into categories (id, name, image) values (3, 'Phụ kiện', 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg');

insert into products (id, name, price, image, description, quantity, categoryId) 
values (1, 'Điện thoại 1', 1000, 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg', 'Điện thoại 1', 10,  1);
insert into products (id, name, price, image, description, quantity, categoryId)
values (2, 'Điện thoại 2', 2000, 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg', 'Điện thoại 2', 20,  2);
insert into products (id, name, price, image, description, quantity, categoryId)
values (3, 'Điện thoại 3', 3000, 'https://asianwiki.com/images/d/de/Chi_Pu-p001.jpg', 'Điện thoại 3', 30, 3);