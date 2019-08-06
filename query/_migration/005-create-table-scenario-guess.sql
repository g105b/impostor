create table scenario_guess
(
	id int auto_increment,
	scenario int not null,
	title varchar(32) not null,
	description text null,
	constraint scenario_guess_pk
		primary key (id),
	constraint scenario_guess_scenario_id_fk
		foreign key (scenario) references scenario (id)
			on update cascade on delete cascade
);

create unique index scenario_guess_title_uindex
	on scenario_guess (title);