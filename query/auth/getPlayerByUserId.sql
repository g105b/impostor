select
	player.id,
	user.id as userId,
        user.name,
        user.cookie,
        joined,
        scenario_guess_persona.id as personaId,
        scenario_guess_persona.title as personaTitle,
        scenario_guess_persona.description as personaDescription

from
	player

inner join
	user
on
	player.userId = user.id

left join
	player_has_persona
on
	player.id = player_has_persona.playerId

left join
	scenario_guess_persona
on
	player_has_persona.personaId = scenario_guess_persona.id

where
	user.id = ?

limit 1