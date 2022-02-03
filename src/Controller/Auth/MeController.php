<?php
/**
 * MeController.php.
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Controller\Auth
 *
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class MeController extends AbstractController
{
    public function process(
        Security $security
    ) {
        return new JsonResponse($security->getUser(), Response::HTTP_OK);
    }
}
