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

where
	id = ?

limit 1