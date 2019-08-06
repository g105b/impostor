create table player_has_persona
(
	id int auto_increment,
	playerId int not null,
	personaId int not null,
	constraint player_has_persona_pk
		primary key (id),
	constraint player_has_persona_player_userId_fk
		foreign key (playerId) references player (id)
			on update cascade on delete cascade,
	constraint player_has_persona_scenario_guess_persona_id_fk
		foreign key (personaId) references scenario_guess_persona (id)
			on update cascade on delete cascade
)