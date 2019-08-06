insert into `impostor`.`scenario` (`title`) values ('At work');
set @scenarioId = last_insert_id();

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Space station');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Command Pilot', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mission Specialist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Docking Module Pilot', 2);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Flight Engineer', 4);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Science Officer', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Brothel');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Receptionist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Deep cleaning specialist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Laundry attendant', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Pimp', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Sex worker', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Bank');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Head Teller', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Vault Security Guard', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Auditor', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Loan Advisor', 2);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Financial Analyst', 3);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Teller', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Circus tent');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Knife Handler', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Animal Handler', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mime', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Unicyclist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Clown', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Juggler', null);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Acrobatist', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Hospital');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Surgeon', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Neurosurgeon', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Pharmacy Technician', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Radiologist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Anesthetist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Physician', null);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Therapist', null);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Medical Assistant', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Hotel');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Casino');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Massage Spa');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Chemistry lab');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Area 51');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Police Station');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Supermarket');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'School');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Gastro Pub');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Passenger Train');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Theme park');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Opera house');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Cruise ship');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Festival');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Animal testing lab');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Airport');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Courthouse');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Church');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Goldmine');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Cotton field');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Racetrack');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Refuse centre');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '?????', null);