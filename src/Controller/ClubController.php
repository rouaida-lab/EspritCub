<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Club;
use App\Repository\ClubRepository;
class ClubController extends AbstractController
{
    #[Route('/club/show', name: 'showClubRoute')]
    public function show(ManagerRegistry $em): Response
    {
        $repo = $em -> getRepository(Club::class);
        $result = $repo -> findAll();

        return $this->render('club/show.html.twig', [
            'clubs' => $result,
        ]);
    }


    #[Route('/club/remove/{ref}', name: 'removeClubRoute')]
    public function remove($ref , ManagerRegistry $mr , ClubRepository $repo): Response
    {
        $cl = $repo->find($ref);
        $em = $mr -> getManager();
        $em ->remove($cl);
        $em ->flush();

        return $this -> redirectToRoute('showClubRoute');
    }

    #[Route('/club/detail/{ref}', name: 'detailClubRoute')]
    public function detail($ref , ClubRepository $repo): Response
    {
        $result = $repo->find($ref);
        return $this->render('club/detail.html.twig', [
                    'details' => $result,
                ]);  
        }

    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    #[Route('club/get/{nom}', name: 'getname')]
    public function getName($nom): Response
    {
        return $this->render('club/detail.html.twig', [
            'nom'=>$nom
        ]);
    }
   
   #[Route('club/list', name: 'list')]
    public function list(): Response
    {   
         $formations = array(
        array('ref' => 'form147', 'Titre' => 'Formation Symfony
        4','Description'=>'formation pratique',
        'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
        'nb_participants'=>19) ,
        array('ref'=>'form177','Titre'=>'Formation SOA' ,
        'Description'=>'formation theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
        'nb_participants'=>0),
        array('ref'=>'form178','Titre'=>'Formation Angular' ,
        'Description'=>'formation theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
        'nb_participants'=>12));

        return $this->render('club/list.html.twig', [
            'formations'=>$formations
        ]);
    }
   
}
