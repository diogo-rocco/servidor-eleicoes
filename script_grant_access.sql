CREATE USER 'app_user' IDENTIFIED BY 'senha_app';
GRANT ALL PRIVILEGES ON base_eleitoral.* TO 'app_user'@'%' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON base_eleitoral.* TO 'app_user'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;