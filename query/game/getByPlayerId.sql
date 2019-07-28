select
	id,
	code,
	created,
	completed,
	started,
	creator,
	scenario,
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

limit 1