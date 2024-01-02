<?php

namespace App\Services;

use App\Entity\Game;
use App\Entity\League;
use App\Entity\LeaguePlayer;
use App\Entity\Round;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function Sodium\add;

class ChessRounds
{
    private EntityManagerInterface $em;
    private ManagerRegistry $doctrine;

    public function __construct (EntityManagerInterface $em, ManagerRegistry $doctrine)
    {
        $this->em = $em;
        $this->doctrine = $doctrine;

    }
    public function createRoundsAndGames(League $league): void
    {
        $players_league = $this->doctrine->getRepository(LeaguePlayer::class)->findBy(['id_league_fk' => $league]);
        $players = [];
        foreach ($players_league as $leaguePlayer) {
            $players[] = $leaguePlayer->getIdUserFk();
        }

        $numPlayers = count($players);

        if($numPlayers % 2 != 0) {
            $dummyPlayer = 'empty';
            $players[] = $dummyPlayer;
        }

        $rounds = $this->generateRotationFixture($players, $league);

        foreach ($rounds as $round) {
            $this->em->persist($round);
            foreach ($round->getGames() as $game) {
                $this->em->persist($game);
            }
        }

        $this->em->flush();
    }

    private function generateRotationFixture(array $users, League $league): array
    {
        $numUsers = count($users);
        $rounds = [];

        $league = $this->doctrine->getRepository(League::class)->find($league);

        for ($roundNumber = 1; $roundNumber < $numUsers; $roundNumber++) {
            $round = new Round();
            $round->setRoundNumber($roundNumber);
            $round->setIdLeagueFk($league);

            for ($i = 0; $i < $numUsers / 2; $i++) {
                $game = new Game();
                $game->setIdRoundFk($round);
                $game->setStatus('Pending');
                $game->setWhitePlayerFk($users[$i]);
                $game->setBlackPlayerFk($users[$numUsers - 1 - $i]);
                $round->addGame($game);
            }

            $rounds[] = $round;
            // Rotar los usuarios para la siguiente ronda
            array_push($users, array_shift($users));
        }

        return $rounds;
    }
}
