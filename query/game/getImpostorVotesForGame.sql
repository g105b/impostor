select
	game_vote_impostor.id,
	playerId,
	votePlayerId

from
	game_vote_impostor

inner join
	player
on
	player.id = playerId

where
	player.gameId = ?