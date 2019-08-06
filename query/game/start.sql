update
	game

set
	started = now()

where
	game.id = ?

and
        game.userCreatorId = ?

limit 1