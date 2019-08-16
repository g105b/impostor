insert into game_turn
set
	gameId = :gameId,
	playerId = :playerId,
	accusedPlayerId = :accusedPlayerId,
	asked = now(),
	hash = :hash