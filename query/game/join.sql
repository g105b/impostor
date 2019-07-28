replace into player (
        userId,
        gameId,
        joined
)
values (
        :userId,
        :gameId,
        now()
)