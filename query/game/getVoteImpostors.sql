select
	game_vote_impostor.id,
	playerId,
	votePlayerId,
	cookie,
	joined,
	name,
	count(game_vote_impostor.id) as voteCount

from
	game_vote_impostor

inner join
	player
on
	playerId = player.id

inner join
	user
on
	user.id = player.userId

group by
	game_vote_impostor.id

order by
	voteCount