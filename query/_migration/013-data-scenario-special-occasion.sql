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
values(@guessId, 'Balloon artist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Best friend', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Guest', null);


insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Baby shower');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mother-to-be', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Experienced mother of 8', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Single mother', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Adoptive gay father', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Guest', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Birth of baby');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Midwife', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Husband', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Baby', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Neonatal nurse', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Maternity support worker', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Newborn hearing screener', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Family member', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Graduation party');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'First-class Graduate', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Graduate\'s Mother', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Graduate\'s younger sibling', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Barely-graduated Graduate', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Lecturer', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'University Dean', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Barkeeper', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Second-class Graduate', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Grand opening');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Proprietor', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Town Mayor', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Z-list celebrity', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Newspaper reporter', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Jealous competitor', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Neighbouring business owner', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Guest', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Christmas Day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Excited youngster', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Dad', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mum', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Disenfranchised teenager', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Racist Grandad', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Deaf Grandma', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Weird uncle', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Lonely neighbour', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Distant family member', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'New Year\'s Eve');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Flapper Girl (fancy dress)', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Marilyn Monroe (fancy dress)', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Blue Power Ranger (fancy dress)', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Cinderella (fancy dress)', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Sexy police (fancy dress)', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Donald Trump (fancy dress)', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Awkward teenager', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Extremely drunk person', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Bouncer', 2);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Bartender', 3);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Partygoer', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Fathers\' Day');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Dad', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Mum', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Son', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Daughter', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Visiting family member', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Funeral');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Valentine\'s Day meal');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Besotted lover', 2);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Single waiting staff', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Stood-up guest', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Chef', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Kitchen assistant', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Barkeeper', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Guest', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Hallowe\'en party');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Headless Horseman', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Zombie', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Fallen Angel', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Ghostbuster', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Harley Quinn', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Ghost pirate', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Man-spider', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Undead Mummy', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Scary Mary', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Captain Hook', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Little Red Riding Hood', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Forgot costume', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Office night out');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Drunk boss', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Assistant to the sales manager', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Receptionist', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Photocopier repair engineer', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Health and Safety Officer', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Chief Financial Officer', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Training organiser', 1);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Telesales staff', null);
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, 'Marketing staff', null);

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
values(@scenarioId, 'First day of school');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);

insert into impostor.scenario_guess(scenarioId, title)
values(@scenarioId, 'Retirement party');
set @guessId = last_insert_id();
insert into impostor.scenario_guess_persona(guessId, title, max)
values(@guessId, '???', null);