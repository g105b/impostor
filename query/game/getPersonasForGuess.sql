select
	id,
	guessId,
	title,
	max,
	description

from
	scenario_guess_persona

where
	guessId = ?

order by
	max