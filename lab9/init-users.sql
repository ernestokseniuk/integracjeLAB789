-- Create additional user sakila2 for lab9 exercises
CREATE USER IF NOT EXISTS 'sakila2'@'%' IDENTIFIED BY 'pass';
GRANT ALL PRIVILEGES ON sakila.* TO 'sakila2'@'%';
FLUSH PRIVILEGES;
