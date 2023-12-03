<?php

namespace App\Controller;

use App\Entity\League;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    #[Route('/user/dashboard', name: 'app_user_dashboard')]
    public function getDataLeague(): Response
    {
        $league = new League();
        $leagueState = $league->getLeagueStatus();

        return $this->json($leagueState);
    }
}
