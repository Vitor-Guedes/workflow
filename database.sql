create database if not exists workflow;

use workflow;

create table if not exists customers(
	id int primary key auto_increment,
    name varchar (100) not null,
    email varchar (100) unique
);

create table if not exists workflows (
	id int primary key auto_increment,
    name varchar (100),
    status varchar (100),
    subject_class varchar (100),
    subject_id int
);
