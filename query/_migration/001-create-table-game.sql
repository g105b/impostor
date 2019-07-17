create table game(
        id int auto_increment primary key,
        code varchar(8) not null,
        created datetime not null,
        completed datetime,
        creator int not null,
        scenario varchar(32) not null,
        type varchar(32) not null,
        limiter int not null,
        round varchar(32) not null
)