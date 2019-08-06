update
	game

set
	started = now()

where
	game.id = ?

and
        game.creator = ?

limit 1