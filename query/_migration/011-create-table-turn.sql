create table game_turn
(
	id int auto_increment,
	gameId int not null,
	playerId int not null,
	accusedPlayerId int not null,
	asked datetime not null,
	hash varchar(64) null,
	constraint game_turn_pk
		primary key (id),
	constraint game_turn_game_id_fk
		foreign key (gameId) references game (id)
			on update cascade on delete cascade,
	constraint game_turn_player_id_fk
		foreign key (playerId) references player (id)
			on update cascade on delete cascade,
	constraint game_turn_player_id_fk_2
		foreign key (accusedPlayerId) references player (id)
			on update cascade on delete cascade
);

create unique index game_turn_hash_uindex
	on game_turn (hash);

