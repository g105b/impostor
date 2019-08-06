update
	game_has_guess

set
	correct = true

where
	guessId = ?
and
	gameId = ?

limit 1