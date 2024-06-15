-- mysql -uroot -p 
create database posts_web_app2;
use posts_web_app2;

create table posts (
   id int auto_increment not null primary key,
   title varchar(100) not null,
   body varchar(512) not null,
   created_at datetime not null,
   updated_at datetime
);
