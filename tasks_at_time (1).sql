drop database tasks_at_time;
create database tasks_at_time;
use tasks_at_time;

create table usuarios (
id integer auto_increment not null primary key
, nombre varchar(50) not null
, apellidos varchar(50) not null
, contrasenia varchar(50) not null
, email varchar(50) not null
, telefono varchar(9)
);

create table tareas (
id integer auto_increment not null primary key
, nombre varchar(50) not null
, descripcion varchar(100) not null
, fecha_inicio varchar(50) null
, fecha_fin datetime not null
, usuario_id int not null
,foreign key (usuario_id) references usuarios(id)
);

insert into usuarios
(nombre, apellidos, contrasenia, email, telefono)
values
("Miriam", "Ruiz", 1234, "miriam@gmail.com", 915555555)
;

insert into tareas
(nombre, descripcion, fecha_fin, usuario_id)
values
("Tarea 1", "Lalalaalallallaalalalal", "2014-11-18", 1)
;