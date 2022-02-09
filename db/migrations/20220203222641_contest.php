<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Contest extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->execute(<<<'SQL'
CREATE TABLE public.contest
(
    contest_id          SERIAL primary key,
    user_id             uuid references public.user,
    created_at          timestamp without time zone not null default now(),
    updated_at          timestamp without time zone not null default now(),
    deleted_at          timestamp without time zone,
    start               timestamp without time zone,
    end                 timestamp without time zone,
    number_of_places    integer,
    title               VARCHAR(255),
    description         CHAR,
    information         CHAR,
    rules               CHAR,
    location            jsonb,
    pictures            jsonb,
    address             VARCHAR(255),
    zipcode             VARCHAR(55),
    city                VARCHAR(255),
    phone               VARCHAR(255),
    contest_state       VARCHAR(55),
    payment_state       VARCHAR(55),
    contest_progress    VARCHAR(55),
    price               integer,
    number_participant_by_team  integer
)
SQL);

        $this->execute(<<<'SQL'
CREATE TABLE public.payment
(
    payment_id          SERIAL primary key,
    contest_id          uuid references public.contest,
    created_at          timestamp without time zone not null default now(),
    paid_at             timestamp without time zone,
    payment_state       VARCHAR(255),
    payment             jsonb,
    value               integer
)
SQL);

        $this->execute(<<<'SQL'
CREATE TABLE public.place
(
    place_id            SERIAL primary key,
    contest_id          uuid references public.contest,
    created_at          timestamp without time zone not null default now(),
    updated_at          timestamp without time zone not null default now(),
    deleted_at          timestamp without time zone,
    location            jsonb,
    pictures            jsonb,
    title               VARCHAR(255),
    description         CHAR,
    information         CHAR
    )
SQL);

        $this->execute(<<<'SQL'
CREATE TABLE public.team
(
    team_id             SERIAL primary key,
    contest_id          uuid references public.contest,
    place_id            uuid references public.place_id,
    created_at          timestamp without time zone not null default now(),
    updated_at          timestamp without time zone not null default now(),
    deleted_at          timestamp without time zone,
    team_state          VARCHAR(55),
    title               VARCHAR(255),
    description         CHAR
    )
SQL);

        $this->execute(<<<'SQL'
CREATE TABLE public.fish
(
    fish_id             SERIAL primary key,
    team_id             uuid references public.contest,
    catch_at            timestamp without time zone,
    created_at          timestamp without time zone not null default now(),
    deleted_at          timestamp without time zone,
    type                VARCHAR(255),
    weight              integer,
    description         CHAR
    )
SQL);

        $this->execute(<<<'SQL'
CREATE TABLE public.participant
(
    participant_id      SERIAL primary key,
    team_id             uuid references public.contest,
    created_at          timestamp without time zone not null default now(),
    deleted_at          timestamp without time zone,
    leader              boolean
    )
SQL);
    }

    public function down(): void
    {
        $this->execute(<<<'SQL'
            DROP TABLE public.contest
        SQL
        );

        $this->execute(<<<'SQL'
            DROP TABLE public.payment
        SQL
        );

        $this->execute(<<<'SQL'
            DROP TABLE public.place
        SQL
        );

        $this->execute(<<<'SQL'
            DROP TABLE public.team
        SQL
        );

        $this->execute(<<<'SQL'
            DROP TABLE public.fish
        SQL
        );

        $this->execute(<<<'SQL'
            DROP TABLE public.participant
        SQL
        );
    }
}
