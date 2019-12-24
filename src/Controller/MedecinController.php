<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Gestionrv\Matriculegenerator;
use App\Repository\MedecinRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedecinController extends AbstractController
{
   
   
     /**
     * @var MedecinRepository
     */
    /**
     * @var EntityManagerInterface
     */
    public function __construct(MedecinRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }
   
    /**
     * @Route("/medecin", name="medecin_service_show")
     */
    public function Medecinshow(MedecinRepository $repos)
    {
        $medecin=$repos->findAll();
        return $this->render('medecin/index.html.twig', [
            'medecin' =>$medecin,
        ]);
    }


      /**
     * @Route("/medecin/add", name="medecin_service_add")
     */
    public function addMedecin(Request $request )
{
     // just setup a fresh $task object (remove the example data)
        $idMatricule = $this->getLastMedecin() + 1;
     
              $medecin = new Medecin();

    $form = $this->createForm(MedecinType::class, $medecin);
     $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

        $twoFirstLetter =\strtoupper(\substr($medecin->getService()->getLibelle(),0,2));
            $longId = strlen((string)$idMatricule);
            $matricule = \str_pad("M".$twoFirstLetter,8 - $longId, "0").$idMatricule;
            $medecin->setMatricule($matricule);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();
           // $entityManager->addFlash('success', 'Données créés avec succes');
            return $this->redirectToRoute('medecin_service_show');
        }
        
    return $this->render('medecin/form.html.twig', [
        'form' => $form->createView(),
    ]);
}

/**
     * @Route("/medecin/{id}", name="medecin_service_edit",  methods="GET|POST")
     */
    public function editMedecin($id ,Request $request,MedecinRepository $repos ) {
        $medecin=$repos->find($id);       
        $form = $this->createForm(MedecinType::class, $medecin);
           $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
           // $task = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($medecin);
            $entityManager->flush();

            return $this->redirectToRoute('medecin_service_show');
        }
    
        return $this->render('medecin/form.html.twig', [
                'medecin' => $medecin,
                'form' => $form->createView()
                ]);
}

/**
     * @Route("/medecin/{id}", name="medecin_service_delete", methods="DELETE")
     */
    public function deleteMedecin(Medecin $medecin, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $medecin->getId(), $request->get('_token'))){
        $entityManager = $this->getDoctrine()->getManager();
      
             $entityManager->remove($medecin);
             $entityManager->flush();
    
            return $this->redirectToRoute('medecin_service_show');
}
}

public function getLastMedecin()
    {
        $ripo = $this->getDoctrine()->getRepository(Medecin::class);
        $medecinLast = $ripo->findBy([],['id'=>'DESC']);
        if($medecinLast == null)
        {
            return $id = 0;
        }
        else
        {
            return $medecinLast[0]->getId();
        }
    }
    
    }



        
         
        
        
   

