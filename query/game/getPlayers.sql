select
	userId,
        user.name,
        user.cookie,
        joined

from
	player

inner join
	user
on
	player.userId = user.id

where
	gameId = ?

order by
	joined