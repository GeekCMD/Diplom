-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 5.0.97.1
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 15.03.2019 15:53:19
-- Версия сервера: 5.0.67-community-nt
-- Версия клиента: 4.1

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE price_monitor_db;

--
-- Описание для таблицы parser_rule
--
DROP TABLE IF EXISTS parser_rule;
CREATE TABLE parser_rule (
  id INT(11) NOT NULL AUTO_INCREMENT,
  url VARCHAR(255) DEFAULT NULL,
  selector VARCHAR(255) DEFAULT NULL,
  attribute VARCHAR(255) DEFAULT NULL,
  test_url TEXT DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 6
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы product
--
DROP TABLE IF EXISTS product;
CREATE TABLE product (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы user_type
--
DROP TABLE IF EXISTS user_type;
CREATE TABLE user_type (
  id INT(11) NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы link
--
DROP TABLE IF EXISTS link;
CREATE TABLE link (
  id INT(11) NOT NULL AUTO_INCREMENT,
  id_product INT(11) DEFAULT NULL,
  position INT(11) DEFAULT NULL,
  url TEXT DEFAULT NULL,
  cost DOUBLE DEFAULT NULL,
  last_visit_date DATETIME DEFAULT NULL,
  main_link BIT(1) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_link_product_id FOREIGN KEY (id_product)
    REFERENCES product(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 17
AVG_ROW_LENGTH = 1820
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы parser_error
--
DROP TABLE IF EXISTS parser_error;
CREATE TABLE parser_error (
  id INT(11) NOT NULL AUTO_INCREMENT,
  registration_date DATETIME DEFAULT NULL,
  url TEXT DEFAULT NULL,
  message TEXT DEFAULT NULL,
  id_parser_rule INT(11) DEFAULT NULL,
  loaded_value TEXT DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_parser_error_parser_rule_id FOREIGN KEY (id_parser_rule)
    REFERENCES parser_rule(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 6
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы user
--
DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password_str VARCHAR(255) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  auth_key VARCHAR(32) NOT NULL,
  password_reset_token VARCHAR(255) DEFAULT NULL,
  activation_token VARCHAR(255) DEFAULT NULL,
  email VARCHAR(255) NOT NULL,
  status SMALLINT(6) NOT NULL DEFAULT 10,
  created_at INT(11) NOT NULL,
  updated_at INT(11) NOT NULL,
  nikname VARCHAR(255) DEFAULT NULL,
  id_user_type INT(11) DEFAULT NULL,
  last_name VARCHAR(255) DEFAULT NULL,
  first_name VARCHAR(255) DEFAULT NULL,
  middle_name VARCHAR(255) DEFAULT NULL,
  phone VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX email (email),
  UNIQUE INDEX password_reset_token (password_reset_token),
  UNIQUE INDEX username (username),
  CONSTRAINT FK_user_user_type_id FOREIGN KEY (id_user_type)
    REFERENCES user_type(id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 25
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_unicode_ci;

--
-- Описание для таблицы link_history
--
DROP TABLE IF EXISTS link_history;
CREATE TABLE link_history (
  id INT(11) NOT NULL AUTO_INCREMENT,
  id_link INT(11) DEFAULT NULL,
  registration_date DATETIME DEFAULT NULL,
  cost DOUBLE DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_link_history_link_id FOREIGN KEY (id_link)
    REFERENCES link(id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- 
-- Вывод данных для таблицы parser_rule
--
INSERT INTO parser_rule VALUES 
  (1, 'dastoys.ru', 'div > span.price', '', 'https://dastoys.ru/derevyannye-konstruktory/konstruktory-mechanical-wood/derevyannyy-konstruktor-vintovoy-gruzovik-samosval-194-detali/'),
  (2, 'rc-go.ru', 'div > span.curr-price', '', 'https://rc-go.ru/cat/konstruktor-3d-derevyanniy-vintovoy-m-wood-gruzovik-samosval/?_openstat=bWFya2V0LnlhbmRleC5ydTsyINCa0L7QvdGB0YLRgNGD0LrRgtC-0YAgM0Qg0LTQtdGA0LXQstGP0L3QvdGL0Lkg0LLQuNC90YLQvtCy0L7QuSBNLVdPT0Qg0JPRgNGD0LfQvtCy0LjQui3RgdCw0LzQvtGB0LLQsNC7IC0gTVctMzAwMztWbkR0bnZrZi1qcm9IN0Z3RWdudTdnOw&frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800004'),
  (3, 'toyterra.ru', 'span > span.catalog-detail-item-price-current', '', 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002'),
  (4, 'missmeralda.ru', 'div > div > span.productpriceh4', '', 'https://missmeralda.ru/konstrucktor/derevyannye-konstruktory/konstruktor-3d-derevyannyj-vintovoj-m-wood-gruzovik-samosval'),
  (5, 'www.ozon.ru', 'div.main-price > div > span > span.price-number > span.main', NULL, 'https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004');

-- 
-- Вывод данных для таблицы product
--
INSERT INTO product VALUES 
  (1, 'Деревянный конструктор винтовой "Грузовик-самосвал" 194 детали', 'Деревянный конструктор винтовой "Грузовик-самосвал" 194 детали'),
  (2, 'Шлем рыцаря детский Вацлавка', 'Шлем рыцаря детский Вацлавка');

-- 
-- Вывод данных для таблицы user_type
--
INSERT INTO user_type VALUES 
  (1, 'Администратор'),
  (2, 'Пользователь'),
  (3, 'Обучающийся');

-- 
-- Вывод данных для таблицы link
--
INSERT INTO link VALUES 
  (1, 1, 1, 'https://dastoys.ru/derevyannye-konstruktory/konstruktory-mechanical-wood/derevyannyy-konstruktor-vintovoy-gruzovik-samosval-194-detali/', 620, '2019-03-15 08:38:56', True),
  (2, 1, 2, 'https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004', 621, '2019-03-15 07:58:26', False),
  (3, 1, 3, 'https://rc-go.ru/cat/konstruktor-3d-derevyanniy-vintovoy-m-wood-gruzovik-samosval/?_openstat=bWFya2V0LnlhbmRleC5ydTsyINCa0L7QvdGB0YLRgNGD0LrRgtC-0YAgM0Qg0LTQtdGA0LXQstGP0L3QvdGL0Lkg0LLQuNC90YLQvtCy0L7QuSBNLVdPT0Qg0JPRgNGD0LfQvtCy0LjQui3RgdCw0LzQvtGB0LLQsNC7IC0gTVctMzAwMztWbkR0bnZrZi1qcm9IN0Z3RWdudTdnOw&frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800004', 690, '2019-03-15 08:38:59', False),
  (4, 1, 4, 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002', 690, '2019-03-15 08:39:01', False),
  (5, 1, 5, 'https://missmeralda.ru/konstrucktor/derevyannye-konstruktory/konstruktor-3d-derevyannyj-vintovoj-m-wood-gruzovik-samosval', 690, '2019-03-15 08:39:02', False),
  (10, 2, 2, 'https://dastoys.ru/shlemy/shlem-rytsarya-detskiy-vatslavka/', 1500, '2019-03-15 08:44:11', True),
  (11, 2, 3, 'https://www.ozon.ru/context/detail/id/148660177/', 1650, '2019-03-15 08:48:43', False),
  (15, 2, 4, 'https://www.ozon.ru/context/detail/id/148651187/', 1950, '2019-03-15 08:49:21', False),
  (16, 2, 5, 'https://www.ozon.ru/context/detail/id/148651187/', NULL, NULL, False);

-- 
-- Вывод данных для таблицы parser_error
--
INSERT INTO parser_error VALUES 
  (1, '2019-03-14 14:53:21', 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002', 'Не удалось получить значение цены товара', 3, ''),
  (2, '2019-03-14 14:54:06', 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002', 'Не удалось получить значение цены товара', 3, ''),
  (3, '2019-03-14 15:02:06', 'https://toyterra.ru/catalog/derevyannyie-konstruktoryi-m-wood/konstruktor-3d-derevyannyiy-vintovoy-m-wood-gruzovik-samosval-art-mw-3003/?frommarket=http%3A%2F%2Fmarket.yandex.ru%2Fpartner&ymclid=15486150245883651326800002', 'Не удалось получить значение цены товара', 3, ''),
  (4, '2019-03-15 07:43:51', 'https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004', 'Не удалось получить значение цены товара', 5, NULL),
  (5, '2019-03-15 08:38:56', 'https://www.ozon.ru/context/detail/id/148225773/?utm_campaign=msk_kids_mp&utm_content=id_148225773%7Ccatid_7174&utm_medium=cpc&utm_source=cpc_yandex_market&ymclid=15486149925704563338800004', 'Не удалось получить значение цены товара', 5, NULL);

-- 
-- Вывод данных для таблицы user
--
INSERT INTO user VALUES 
  (1, 'admin', '123123', '$2y$13$3RLXTm8bp5uAjw4.TKueN.QQx4/wQIhD3cZFTI2cUK1eNcflbzhyy', 'uo3oaTjqwMPiAZugOmnx4Z9pvRWxRTbx', NULL, NULL, 'admin@mail.ru', 10, 1446794447, 1525795543, 'admin', 1, 'Зайцев', 'Алексей', 'Петрович', '8-800-578-55-65'),
  (19, 'user', '123123', '$2y$13$gIHiF3A0F85BiZJsUY0ZSuVhaCEuoY9j/9d.1StnElo1BfyygmiyC', 'IiGfMD7sySpVWoJ7k2IOak-bmD1XlrKQ', NULL, 'R6oTdoqwTTGKzVv7PYHYgkd3dJGy1pD5_1450019853', 'user@gmail.ru', 10, 1450019853, 1525795598, 'manager', 2, 'Иванов', 'Павел', 'Владимирович', ''),
  (24, 'student', '123123', '$2y$13$03wB5bsoEAEgIi520YqxMeorI6j7o73HzqAJM67ZLZS/Gi6.Dra7m', 'eONuIY7VoStJiK1EHnARNqlPq1VQx5O8', NULL, 'w_RautGtapFz103qUUS1xxF2jMDvLA4E_1528980418', 'petrova@mail.ru', 10, 1528980418, 1528980418, NULL, 3, 'Петрова', 'Анна', 'Алексеевга', '+7-925-456-40-29');

-- 
-- Вывод данных для таблицы link_history
--
-- Таблица price_monitor_db.link_history не содержит данных

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;