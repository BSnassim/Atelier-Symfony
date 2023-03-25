<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{

    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    // #[Route('/club/get/{name}', name: 'app_club_detail')]
    // public function getName($name): Response
    // {
    //     return $this->render('club/detail.html.twig', [
    //         'name' => $name,
    //     ]);
    // }

    // #[Route('/club/list', name: 'app_club_list')]
    // public function list(): Response
    // {
    //     $formations = array(
    //         array(
    //         'ref' => 'form147', 
    //         'Titre' => 'Formation Symfony 4','Description'=>'formation pratique',
    //         'date_debut'=>'12/06/2020', 
    //         'date_fin'=>'19/06/2020',
    //         'nb_participants'=>19) ,
    //         array(
    //         'ref'=>'form177',
    //         'Titre'=>'Formation SOA' ,
    //         'Description'=>'formation theorique',
    //         'date_debut'=>'03/12/2020',
    //         'date_fin'=>'10/12/2020',
    //         'nb_participants'=>0),
    //         array(
    //         'ref'=>'form178',
    //         'Titre'=>'Formation Angular',
    //         'Description'=>'formation theorique',
    //         'date_debut'=>'10/06/2020',
    //         'date_fin'=>'14/06/2020',
    //         'nb_participants'=>12)
    //     );
    //     return $this->render('club/list.html.twig', [
    //         'formations' => $formations,
    //     ]);
    // }

    #[Route('/club/add', name: 'app_clubAdd')]
    public function add(Request $request,ManagerRegistry $doctrine) : Response
    {
        $repository=$doctrine->getRepository(Club::class);
        $em=$doctrine->getManager();
        $club= new Club() ;
        $form = $this->createForm(ClubType::class, $club) ;
        $form->add('Add', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($club) ;
            $em->flush();
            return $this->redirectToRoute('app_clubList');
        }
        return $this->renderForm('club/add.html.twig',array('formA' => $form));
    }

    #[Route('/club/list', name: 'app_clubList')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Club::class);
        $list= $repository->findAll();
        return $this->render('club/list.html.twig', [
            'list' => $list
        ]);
    }

    #[Route('/club/remove/{id}', name: 'app_clubRemove')]
    public function remove(ManagerRegistry $doctrine, $id) : Response {

        $repository=$doctrine->getRepository(Club::class);
        $em=$doctrine->getManager();
        $club = $repository->find($id);
        $em->remove($club) ;
        $em->flush();
        
        return $this->redirectToRoute('app_clubList');
    }

    #[Route('/club/{id}', name: 'app_clubShow')]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(Club::class);
        $show=  $repository->find($id);

        return $this->render('club/detail.html.twig', [
            'show' => $show
        ]);
    }

    #[Route('/club/{id}/update', name: 'app_clubUpdate')]
    public function update(Request $request,ManagerRegistry $doctrine, $id, Club $club) : Response
    {
        $em=$doctrine->getManager(); 
        $form = $this->createForm(ClubType::class, $club);
        $form->add('Submit', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('app_clubList');
        }
        return $this->renderForm('club/update.html.twig',array('formC' => $form));
    }

}
