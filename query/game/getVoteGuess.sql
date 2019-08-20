select
	game_vote_guess.id,
	playerId,
	guessId,
	guess.title,
	description,
	guessTerm as term

from
	game_vote_guess

inner join
	scenario_guess guess
on
	guess.id = game_vote_guess.guessId

inner join
	scenario
on
	scenario.id = guess.scenarioId