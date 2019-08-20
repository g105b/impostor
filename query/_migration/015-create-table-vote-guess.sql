create table game_vote_guess
(
	id int auto_increment,
	playerId int not null,
	guessId int not null,
	constraint game_vote_guess_pk
		primary key (id),
	constraint game_vote_guess_player_id_fk
		foreign key (playerId) references player (id)
			on update cascade on delete cascade,
	constraint game_vote_guess_scenario_guess_id_fk
		foreign key (guessId) references scenario_guess (id)
)