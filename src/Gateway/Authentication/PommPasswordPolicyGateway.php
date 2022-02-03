<?php

declare(strict_types=1);

namespace App\Gateway\Authentication;

use App\Domain\Authentication\Exception\PasswordPolicyNotFoundException;
use App\Domain\Authentication\PasswordPolicy;
use App\Domain\Authentication\PasswordPolicyGateway;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\SimpleQueryManager;

class PommPasswordPolicyGateway implements PasswordPolicyGateway
{
    private const ACTIVE_POLICY_ID = 1;

    private SimpleQueryManager $queryManager;

    public function __construct(Pomm $pomm)
    {
        $this->queryManager = $pomm->getDefaultSession()->getQueryManager();
    }

    public function getActivePasswordPolicy(): PasswordPolicy
    {
        $sql = <<<'SQL'
SELECT
    longueur,
    minuscules,
    majuscules,
    chiffres,
    nonsemblables,
    speciaux
FROM password_security
WHERE password_security_id = $*
SQL;
        $result = $this->queryManager->query($sql, [self::ACTIVE_POLICY_ID]);
        if ($result->isEmpty()) {
            throw new PasswordPolicyNotFoundException();
        }
        /** @psalm-var array{longueur: int, minuscules: ?bool, majuscules: ?bool, chiffres: ?bool, nonsemblables: ?bool, speciaux: ?bool} $plainPasswordPolicy */
        $plainPasswordPolicy = $result->current();

        return new PasswordPolicy(
            $plainPasswordPolicy['longueur'],
            (bool) $plainPasswordPolicy['minuscules'],
            (bool) $plainPasswordPolicy['majuscules'],
            (bool) $plainPasswordPolicy['chiffres'],
            (bool) $plainPasswordPolicy['nonsemblables'],
            (bool) $plainPasswordPolicy['speciaux']
        );
    }
}
