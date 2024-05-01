DROP TABLE IF EXISTS micro_users;
CREATE TABLE micro_users (
    user_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    password VARCHAR(80) NOT NULL,
    email VARCHAR(200) NOT NULL,
    PRIMARY KEY (user_id)
);

DROP TABLE IF EXISTS micro_airbnbs;
CREATE TABLE micro_airbnbs (
    id VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    host_id VARCHAR(255) NOT NULL,
    host_name VARCHAR(255) NOT NULL,
    neighbourhood_group VARCHAR(255) NOT NULL,
    neighbourhood VARCHAR(255) NOT NULL,
    latitude VARCHAR(255) NOT NULL,
    longitude VARCHAR(255) NOT NULL,
    room_type VARCHAR(255) NOT NULL,
    price VARCHAR(255) NOT NULL,
    minimum_nights VARCHAR(255) NOT NULL,
    number_of_reviews VARCHAR(255) NOT NULL,
    rating VARCHAR(255) NOT NULL,
    rooms VARCHAR(255) NOT NULL,
    beds VARCHAR(255) NOT NULL,
    bathrooms VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS micro_reservas;
CREATE TABLE micro_reservas (
	reservation_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	airbnb_id VARCHAR(255) NOT NULL,
	airbnb_name VARCHAR(255) NOT NULL,
	host_id VARCHAR(255) NOT NULL,
	client_id VARCHAR(255) NOT NULL,
	client_name VARCHAR(255) NOT NULL,
	reservation_date DATETIME NULL
);

INSERT INTO micro_users (user_id, name, role, password, email) VALUES (1000, 'Admin', 'Admin', 'admin', 'admin@admin.com');
INSERT INTO micro_users (user_id, name, role, password, email) VALUES (2000, 'Charly', 'Host', '1234', 'charly@hotmail.com');
INSERT INTO micro_users (user_id, name, role, password, email) VALUES (3000, 'Cerati', 'Cliente', '1234', 'cerati@gmail.com');