create table user (
        id int auto_increment primary key,
        cookie varchar(32) unique not null,
        name varchar(32),
        created datetime not null
)