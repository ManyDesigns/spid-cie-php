-- Create users
CREATE USER 'spiddbuser'@'%' IDENTIFIED BY 'secret';
CREATE USER 'samluser'@'%' IDENTIFIED BY 'secret';

-- Create databases
CREATE DATABASE spiddb;
CREATE DATABASE saml;

-- Grant privileges
GRANT ALL PRIVILEGES ON spiddb.* TO 'spiddbuser'@'%';
GRANT ALL PRIVILEGES ON saml.* TO 'samluser'@'%';

-- Apply changes
FLUSH PRIVILEGES;