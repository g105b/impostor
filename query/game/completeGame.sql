update
	game

set
	completed = now()

where
	game.id = ?

limit 1