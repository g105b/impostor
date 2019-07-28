create table player
(
	userId int not null,
	gameId int not null,
	joined datetime null,
	constraint player_pk
		primary key (userId, gameId)
);