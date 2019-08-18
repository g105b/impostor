insert into game_turn_response
set
	turnId = :turnId,
	responded = now(),
	hash = :hash