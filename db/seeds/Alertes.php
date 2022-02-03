<?php

namespace App\Phinx\Seeds;

use Phinx\Seed\AbstractSeed;

class Alertes extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $this->execute(<<<'SQL'
INSERT INTO alerte ("code", "nom", "sujet", "message", "actif")
VALUES ('ask_password', 'Mot de passe oublié', 'Mot de passe oublié',
        '<p>Bonjour,</p><br /><p>Cliquez sur ce <a href="[resetPasswordLink]">lien</a> pour choisir votre nouveau mot de passe</p><br/><p>Cordialement.</p>', TRUE)
SQL
        );
    }

    public function down(): void
    {
        $this->execute(<<<'SQL'
DELETE FROM alerte
WHERE code = 'ask_password'
SQL
        );
    }
}
