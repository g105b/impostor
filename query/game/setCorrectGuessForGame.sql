update
	game_has_guess

set
	correct = true

where
	guess = ?
and
	game = ?

limit 1