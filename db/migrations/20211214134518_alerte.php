<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Alerte extends AbstractMigration
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
CREATE TABLE public.alerte (
    alerte_id SERIAL primary key,
    code character varying(255),
    nom character varying(255),
    sujet character varying(255),
    message text,
    cc text,
    bcc text,
    actif boolean DEFAULT false
);

SQL);
    }

    public function down(): void
    {
        $this->execute(<<<'SQL'
            DROP TABLE public.alerte
        SQL
        );
    }
}
