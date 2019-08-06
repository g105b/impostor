insert into game
set
	code = :code,
	userCreatorId = :userId,
	scenarioId = :scenarioId,
	type = :type,
	limiter = :limiter,
	round = :round,
	created = now()