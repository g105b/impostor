insert into game (
        code,
        created,
        creator,
        scenario,
        type,
        limiter,
        round
)
values (
        :code,
        now(),
        :userCreatorId,
        :scenario,
        :type,
        :limiter,
        :round
)