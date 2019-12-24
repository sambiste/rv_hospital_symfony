<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Service;
use App\Form\MedecinType;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_service_show")
     */
    public function Serviceshow(ServiceRepository $repos)
    {
        $sevices=$repos->findAll();
        return $this->render('admin/index.html.twig', [
            'services' =>$sevices,
        ]);
    }
     /**
     * @Route("/admin/add", name="admin_service_add")
     */
    public function addservice(Request $request){
        $service = new Service();



         $form = $this->createForm(ServiceType::class, $service);
    
           $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
           // $task = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($service);
            $entityManager->flush();
    
            return $this->redirectToRoute('admin_service_show');
        }
    
        return $this->render('admin/form.html.twig', [
            'form'=> $form->createView(),
        ]);
}
/**
     * @Route("/admin/edit/{id}", name="admin_service_edit")
     */
    public function editservice($id ,Request $request,ServiceRepository $repos){
        $service=$repos->find($id);

        
        $form = $this->createForm(ServiceType::class, $service);
    
           $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
           // $task = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('admin_service_show');
        }
    
        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
        ]);
}
 /**
     * @Route("/admin/delete/{id}", name="admin_service_delete")
     */
    public function deleteService( $id ,ServiceRepository $repos  )
    {
        $service = $repos->find($id);
        $entityManager = $this->getDoctrine()->getManager();
             $entityManager->remove($service);
             $entityManager->flush();
    
            return $this->redirectToRoute('admin_service_show');
    }
}







    