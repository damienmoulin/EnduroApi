<?php

namespace App\Phinx\Seeds;

use Phinx\Seed\AbstractSeed;

class Auth1 extends AbstractSeed
{
    const WEBAPP_CLIENT_ID = 'dtHUS06IjVQP9iWCPnGA4B==';
    const WEBAPP_CLIENT_REDIRECT_URI = 'http://localhost/authorization';

    CONST BACK_OFFICE_USER_ID = 1;
    CONST BACK_OFFICE_USER_EMAIL = 'dmoulin@sismic.fr';

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
            $this->createOauth2Client();
    }

    private function createOauth2Client()
    {
        $sql = <<<SQL
            INSERT INTO  oauth2_client (
                identifier, 
                secret, 
                redirect_uris, 
                grants, 
                scopes, 
                active, 
                allow_plain_text_pkce
            ) VALUES (
                '%s',	
                NULL,	
                '%s',	
                'authorization_code, refresh_token',	
                NULL,	
                '1',	
                '0'
            )
SQL;
        $this->execute(
            sprintf(
                $sql,
                self::WEBAPP_CLIENT_ID,
                self::WEBAPP_CLIENT_REDIRECT_URI
            )
        );
        $sql = 'INSERT INTO public."user" VALUES (\''.self::BACK_OFFICE_USER_ID.'\', \''.self::BACK_OFFICE_USER_EMAIL.'\', \'{ROLE_SUPER_ADMIN}\', \'$argon2i$v=19$m=16,t=2,p=1$ZGlsaWdlbmNpbw$m7B2pYqnv9zLgDDP/k71Ew\', \'a16b9a36c6fc55124f36336e835d0d16\', \'lastname\', \'firstname\');';
        $this->execute($sql);
    }
}
