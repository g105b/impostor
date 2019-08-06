create table scenario_guess_persona
(
	id int auto_increment,
	guess int not null,
	title varchar(32) not null,
	max int null,
	description text null,
	constraint scenario_guess_persona_pk
		primary key (id),
	constraint scenario_guess_persona_scenario_guess_id_fk
		foreign key (guess) references scenario_guess (id)
			on update cascade on delete cascade
);

create unique index scenario_guess_persona_title_uindex
	on scenario_guess_persona (title);