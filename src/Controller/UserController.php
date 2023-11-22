<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;

class UserController extends AbstractController
{/*
    private $em;

    /**
     * @param $em
     *
     */
    //private $doctrine;


    //Creacion de objeto para obtener el encoder de cifrado para las ediciones
   /* private $encoder;
    public function __construct(ManagerRegistry $doctrine) {

        $this->doctrine = $doctrine;
    }*/

    /*public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }*/
/*
    #[Route('/user/{id}', name: 'app_user')]
    public function index($id)
    {
        $user = array();
        $user = $this->doctrine->getRepository(User::class)->findUser($id);
        return $this->json($user);


    }*/
}
