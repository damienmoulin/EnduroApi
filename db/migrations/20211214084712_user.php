<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class User extends AbstractMigration
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
CREATE TABLE public.user
(
    user_id             SERIAL primary key,
    email               VARCHAR(32) NOT NULL,
    roles               text[] NOT NULL,
    password            VARCHAR(255) NOT NULL,
    confirmation_token  VARCHAR(255),
    firstname           VARCHAR(255),
    lastname            VARCHAR(255),
    address             VARCHAR(255),
    city                VARCHAR(255),
    zipcode             VARCHAR(255),
    phone               VARCHAR(255)
)
SQL);
    }

    public function down(): void
    {
        $this->execute(<<<'SQL'
            DROP TABLE public.user
        SQL
        );
    }
}
