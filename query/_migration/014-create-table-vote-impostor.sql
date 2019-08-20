create table game_vote_impostor
(
	id int auto_increment,
	playerId int not null,
	votePlayerId int not null,
	constraint game_vote_impostor_pk
		primary key (id),
	constraint game_vote_impostor_player_id_fk
		foreign key (playerId) references player (id)
			on update cascade on delete cascade,
	constraint game_vote_impostor_player_id_fk_2
		foreign key (votePlayerId) references player (id)
)