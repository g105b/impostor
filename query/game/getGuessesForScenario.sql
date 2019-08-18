select
	scenario_guess.id,
	scenarioId,
	scenario_guess.title,
	scenario_guess.description,
	scenario.guessTerm

from
	scenario_guess

inner join
	scenario
on
	scenario_guess.scenarioId = scenario.id

where
	scenarioId = ?