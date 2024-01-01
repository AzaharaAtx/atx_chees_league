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

class ChessRounds
{
    private EntityManagerInterface $em;

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
        $numRounds = $numPlayers - 1;

        for ($roundNumber = 1; $roundNumber <= $numRounds; $roundNumber++) {
            $round = new Round();
            $round->setRoundNumber($roundNumber);
            $round->setIdLeagueFk($league);
            $this->em->persist($round);

            $group1 = array_slice($players, 0, $numPlayers / 2);
            $group2 = array_slice($players, $numPlayers / 2);

            for ($matchNumber = 1; $matchNumber <= $numPlayers / 2; $matchNumber++) {
                $player1 = $group1[$matchNumber - 1];
                $player2 = $group2[$matchNumber - 1];
                // Evitar emparejamiento consigo mismo
//                    if ($player1 !== $player2) {
//                        // Verificar si ya existe un juego con estos jugadores
//                        $existingGame = $this->doctrine->getRepository(Game::class)->findOneBy([
//                            'id_round_fk' => $round,
//                            'white_player_fk' => $player1,
//                            'black_player_fk' => $player2,
//                        ]);

//                        if (!$existingGame) {
                            // Crea el nuevo juego solo si no existe ya
                            $match = new Game();
                            $match->setStatus('Pending');
                            $match->setIdRoundFk($round);
                            $match->setWhitePlayerFk($player1);
                            $match->setBlackPlayerFk($player2);
                            $this->em->persist($match);
                            $this->em->flush();
                        //}
                    //}
            }
            $group2[] = array_shift($group1);
            array_unshift($group1, array_pop($group2));
        }
        $this->em->flush();
    }
}
