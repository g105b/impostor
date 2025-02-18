select
	game_turn.id,
	@turnNum:=@turnNum+1 turnNum,
	game_turn.gameId,
	game_turn.asked,
	game_turn.hash,

	game_turn.playerId as askingPlayerId,
	askingUser.cookie as askingCookie,
	askingUser.name as askingName,
	askingPlayer.joined as askingJoined,

	game_turn.accusedPlayerId,
	accusedUser.cookie as accusedCookie,
	accusedUser.name as accusedName,
	accusedPlayer.joined as accusedJoined,

	response.hash as responseHash,
	response.responded

from
	(SELECT @turnNum:=0) r,
	game_turn

inner join
	player askingPlayer
on
	game_turn.playerId = askingPlayer.id
inner join
	user askingUser
on
	askingPlayer.userId = askingUser.id

inner join
	player accusedPlayer
on
	game_turn.accusedPlayerId = accusedPlayer.id
inner join
	user accusedUser
on
	accusedPlayer.userId = accusedUser.id

left join
	game_turn_response response
on
	game_turn.id = response.turnId

where
	game_turn.gameId = ?

order by
	asked