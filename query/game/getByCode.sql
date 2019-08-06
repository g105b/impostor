select
	id,
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

where
	code = ?

limit 1