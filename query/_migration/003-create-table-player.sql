create table player
(
	id int auto_increment,
	userId int not null,
	gameId int not null,
	joined datetime null,
	constraint player_pk
		primary key (id),
	constraint player_game_id_fk
		foreign key (gameId) references game (id)
			on update cascade on delete cascade,
	constraint player_user_id_fk
		foreign key (userId) references user (id)
			on update cascade on delete cascade
)