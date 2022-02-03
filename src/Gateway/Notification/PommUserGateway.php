<?php

declare(strict_types=1);

namespace App\Gateway\Notification;

use App\Domain\Notification\Exception\UserNotFoundException;
use App\Domain\Notification\User;
use App\Domain\Notification\UserGateway;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\SimpleQueryManager;

class PommUserGateway implements UserGateway
{
    private const ROLE_PROSPECT = 'ROLE_PROSPECT';

    private SimpleQueryManager $queryManager;

    public function __construct(Pomm $pomm)
    {
        $this->queryManager = $pomm->getDefaultSession()->getQueryManager();
    }

    public function get(int $id): User
    {
        $sql = <<<'SQL'
SELECT
    user_id,
    email,
    prenom,
    nom,
    password,
    confirmation_token,
    roles
FROM "user"
WHERE user_id = $*
SQL;
        $result = $this->queryManager->query($sql, [$id]);
        if ($result->isEmpty()) {
            throw UserNotFoundException::createFromId($id);
        }
        /** @psalm-var array{user_id: int, email: ?string, prenom: ?string, nom: ?string, password: ?string, confirmation_token: ?string, roles: list<string>} $plainUser */
        $plainUser = $result->current();

        return new User(
            $plainUser['user_id'],
            (string) $plainUser['email'],
            (string) $plainUser['prenom'],
            (string) $plainUser['nom'],
            empty($plainUser['password']) && !empty($plainUser['confirmation_token']) ? $plainUser['confirmation_token'] : null,
            $plainUser['confirmation_token'],
            $this->containsProspectRole($plainUser['roles'])
        );
    }

    /**
     * @param list<string> $roles
     */
    private function containsProspectRole(array $roles): bool
    {
        return \in_array(self::ROLE_PROSPECT, $roles, true);
    }

    public function getAdvisor(int $id): User
    {
        return $this->get($this->getAdvisorId($id));
    }

    private function getAdvisorId(int $userId): int
    {
        $sql = <<<'SQL'
SELECT partenaire_id
FROM "user"
WHERE
    user_id = $*
    AND partenaire_id IS NOT NULL
SQL;
        $result = $this->queryManager->query($sql, [$userId]);

        if ($result->isEmpty()) {
            throw UserNotFoundException::createFromProspectWithoutAdvisor($userId);
        }
        /** @psalm-var array{partenaire_id: int} $row */
        $row = $result->current();

        return $row['partenaire_id'];
    }
}
