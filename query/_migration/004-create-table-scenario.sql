create table scenario
(
	id int auto_increment,
	title varchar(32) not null,
	constraint scenario_pk
		primary key (id)
);

create unique index scenario_title_uindex
	on scenario (title);