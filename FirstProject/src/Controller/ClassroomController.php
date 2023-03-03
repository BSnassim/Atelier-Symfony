<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Classroom;
use App\Form\ClassroomType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/classroom/list', name: 'app_classroomList')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Classroom::class);
        $list= $repository->findAll();
        return $this->render('classroom/list.html.twig', [
            'list' => $list
        ]);
    }

    #[Route('/classroom/add', name: 'app_classroomAdd')]
    public function add(Request $request,ManagerRegistry $doctrine) : Response
    {
        $repository=$doctrine->getRepository(Classroom::class);
        $em=$doctrine->getManager();
        $classroom = new Classroom() ;  
        $form = $this->createForm(ClassroomType::class, $classroom) ;
        $form->add('Add', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($classroom) ;
            $em->flush();
            return $this->redirectToRoute('app_classroomList');
        }
        return $this->renderForm('classroom/add.html.twig',array('formA' => $form));
    }

    #[Route('/classroom/remove/{id}', name: 'app_classroomRemove')]
    public function remove(ManagerRegistry $doctrine, $id) : Response {

        $repository=$doctrine->getRepository(Classroom::class);
        $em=$doctrine->getManager();
        $classroom = $repository->find($id);
        $em->remove($classroom) ;
        $em->flush();
        
        return $this->redirectToRoute('app_classroomList');
    }

    #[Route('/classroom/{id}', name: 'app_classroomShow')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(classroom::class);
        $show=  $repository->find($id);

        return $this->render('classroom/show.html.twig', [
            'show' => $show
        ]);
    }

    #[Route('/classroom/{id}/update', name: 'app_classroomUpdate')]
    public function update(Request $request,ManagerRegistry $doctrine, $id, Classroom $classroom) : Response
    {
        $repository=$doctrine->getRepository(Classroom::class);
        $em=$doctrine->getManager(); 
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('Submit', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('app_classroomList');
        }
        return $this->renderForm('classroom/update.html.twig',array('formC' => $form));
    }

}
