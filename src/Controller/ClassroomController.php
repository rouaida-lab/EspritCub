<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
class ClassroomController extends AbstractController
{
    #[Route('/classroom/show', name: 'showClassroomRoute')]
    public function show(ManagerRegistry $em): Response
    {
        $repo = $em -> getRepository(Classroom::class);
        $result = $repo -> findAll();

        return $this->render('classroom/show.html.twig', [
            'classes' => $result,
        ]);
    }


    #[Route('/classroom/remove/{id}', name: 'removeClassroomRoute')]
    public function remove($id , ManagerRegistry $mr , ClassroomRepository $repo): Response
    {
        $cl = $repo->find($id);
        $em = $mr -> getManager();
        $em ->remove($cl);
        $em ->flush();

        return $this -> redirectToRoute('showClassroomRoute');
    }

    #[Route('/classroom/detail/{id}', name: 'detailClassroomRoute')]
    public function detail($id , ClassroomRepository $repo): Response
    {
        $result = $repo->find($id);
        return $this->render('classroom/detail.html.twig', [
                    'details' => $result,
                ]);  
        }
}
