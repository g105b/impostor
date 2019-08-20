select
	game_vote_guess.id,
	playerId,
	guessId

from
	game_vote_guess

inner join
	player
on
	player.id = playerId

where
	gameId = ?