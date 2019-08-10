alter table game
	add constraint game_scenario_id_fk
		foreign key (scenarioId) references scenario (id)
			on update cascade on delete cascade;

alter table game
	add constraint game_user_id_fk
		foreign key (userCreatorId) references user (id)
			on update cascade on delete cascade;