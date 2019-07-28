select
	id,
	cookie,
	name,
	created
from
	user

where
	id = ?

limit 1