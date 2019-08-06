update
	player

set
	impostor = true

where
	player.userId = ?

and
	player.gameId = ?

limit 1