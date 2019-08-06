create table game_has_guess
(
	id int auto_increment,
	gameId int not null,
	guessId int not null,
	correct bool,
	constraint game_has_guess_pk
		primary key (id),
	constraint game_has_guess_game_id_fk
		foreign key (gameId) references game (id)
			on update cascade on delete cascade,
	constraint game_has_guess_scenario_guess_id_fk
		foreign key (guessId) references scenario_guess (id)
			on update cascade on delete cascade
);