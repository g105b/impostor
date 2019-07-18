select
        id,
	cookie,
	name,
	created
from
        user

where
	cookie = ?

limit 1