<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use App\Repository\StudentRepository;
class StudentController extends AbstractController
{
    #[Route('/student/show', name: 'showStudentRoute')]
    public function show(ManagerRegistry $em): Response
    {
        $repo = $em -> getRepository(Student::class);
        $result = $repo -> findAll();

        return $this->render('student/show.html.twig', [
            'students' => $result,
        ]);
    }


    #[Route('/student/remove/{nsc}', name: 'removeStudentRoute')]
    public function remove($nsc , ManagerRegistry $mr , StudentRepository $repo): Response
    {
        $cl = $repo->find($nsc);
        $em = $mr -> getManager();
        $em ->remove($cl);
        $em ->flush();

        return $this -> redirectToRoute('showStudentRoute');
    }

    #[Route('/student/detail/{nsc}', name: 'detailStudentRoute')]
    public function detail($nsc, StudentRepository $repo): Response
    {
        $result = $repo->find($nsc);
        return $this->render('student/detail.html.twig', [
                    'details' => $result,
                ]);  
        
}
 }