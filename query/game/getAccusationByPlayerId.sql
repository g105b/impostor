select
	id,
	playerId,
	votePlayerId

from
	game_vote_impostor

where
	playerId = ?