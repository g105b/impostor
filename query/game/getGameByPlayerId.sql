select
	game.id,
	code,
	created,
	completed,
	started,
	userCreatorId,
	scenarioId,
	type,
	limiter,
	round

from
	game

inner join
	player
on
	game.id = player.gameId

where
	player.userId = ?
and
	completed is null

limit 1