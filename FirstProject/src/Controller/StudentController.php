<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/student/add', name: 'app_studentAdd')]
    public function add(Request $request,ManagerRegistry $doctrine) : Response
    {
        $repository=$doctrine->getRepository(Student::class);
        $em=$doctrine->getManager();
        $student= new Student() ;  
        $form = $this->createForm(StudentType::class, $student) ;
        $form->add('Add', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($student) ;
            $em->flush();
            return $this->redirectToRoute('app_studentList');
        }
        return $this->renderForm('student/add.html.twig',array('formA' => $form));
    }

    #[Route('/student/list', name: 'app_studentList')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Student::class);
        $list= $repository->findAll();
        return $this->render('student/list.html.twig', [
            'list' => $list
        ]);
    }

    #[Route('/student/remove/{id}', name: 'app_studentRemove')]
    public function remove(ManagerRegistry $doctrine, $id) : Response {

        $repository=$doctrine->getRepository(student::class);
        $em=$doctrine->getManager();
        $student = $repository->find($id);
        $em->remove($student) ;
        $em->flush();
        
        return $this->redirectToRoute('app_studentList');
    }

    #[Route('/student/{id}', name: 'app_studentShow')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(student::class);
        $show=  $repository->find($id);

        return $this->render('student/show.html.twig', [
            'show' => $show
        ]);
    }

    #[Route('/student/{id}/update', name: 'app_studentUpdate')]
    public function update(Request $request,ManagerRegistry $doctrine, $id, Student $student) : Response
    {
        $repository=$doctrine->getRepository(Student::class);
        $em=$doctrine->getManager(); 
        $form = $this->createForm(StudentType::class, $student);
        $form->add('Submit', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($student);
            $em->flush();
            return $this->redirectToRoute('app_studentList');
        }
        return $this->renderForm('student/update.html.twig',array('formC' => $form));
    }
}
