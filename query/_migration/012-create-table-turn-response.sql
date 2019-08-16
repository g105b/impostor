create table game_turn_response
(
	id int auto_increment,
	turnId int not null,
	responded datetime not null,
	hash varchar(64) null,
	constraint game_turn_response_pk
		primary key (id),
	constraint game_turn_response_game_turn_id_fk
		foreign key (turnId) references game_turn (id)
			on update cascade on delete cascade
)