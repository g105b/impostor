insert into `impostor`.`scenario` (`title`) values ('Special occasion');
set @scenarioId = last_insert_id();

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Wedding');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Bride', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Groom', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Best man', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mother of the bride', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Father of the bride', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mother of the groom', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Father of the groom', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Photographer', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Registrar', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Bridesmaid', 3);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Guest', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Birthday');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Birthday boy/girl', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Magician', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Clown', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Cake delivery person', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Piñata stuffer', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Guest', null);


insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Baby shower');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Birth of baby');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Graduation party');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Grand opening');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Christmas Day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'New Year\'s Eve');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Mothers\' Day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Fathers\' Day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Funeral');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Valentine\'s Day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Hallowe\'en');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Solar eclipse');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Office night out');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Hanukkah');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Diwali');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Chinese New Year');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'School sports day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'First day at school');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Retirement party');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);