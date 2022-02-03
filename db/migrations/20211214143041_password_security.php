<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PasswordSecurity extends AbstractMigration
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
        CREATE TABLE password_security (
            password_security_id SERIAL primary key,
            longueur integer NOT NULL,
            minuscules boolean,
            majuscules boolean,
            chiffres boolean,
            nonsemblables boolean,
            speciaux boolean
        )
        SQL);

    }

    public function down(): void
    {
        $this->execute(<<<'SQL'
            DROP TABLE public.password_security
        SQL
        );
    }
}
