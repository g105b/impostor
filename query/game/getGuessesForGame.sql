select
	guessId as id,
	sg.title,
	sg.description,
	correct

from
	game_has_guess

inner join
	scenario_guess sg
on
	game_has_guess.guessId = sg.id

where
	gameId = ?