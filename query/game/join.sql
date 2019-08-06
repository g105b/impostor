insert into player
set
	userId = :userId,
	gameId = :gameId,
	joined = now()