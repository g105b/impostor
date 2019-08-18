select
	guessId as id,
	sg.title,
	sg.description,
	scenario.guessTerm,
	correct

from
	game_has_guess

inner join
	scenario_guess sg
on
	game_has_guess.guessId = sg.id

inner join
	scenario
on
	scenario.id = sg.scenarioId

where
	gameId = ?