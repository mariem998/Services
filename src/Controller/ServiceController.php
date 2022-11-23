<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    private $serviceRepository;
    private $entityManager;

    public function __construct(
        ServiceRepository $serviceRepository,
        ManagerRegistry $doctrine
    ){
        $this->serviceRepository = $serviceRepository;
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        $services = $this->serviceRepository->findAll();
        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/service/store', name: 'service_store')]
    public function store(Request $request): Response
    {
        $service=new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $product=$form->getData();
            if($request->files->get('service')['image']){
                $image = $request->files->get('service')['image'];
                $image_name =time().'_'.$image->getClientOriginalName();
                $image->move($this->getParameter('image_directory'),$image_name);
                $service->setImage($image_name);
            }

            $this->entityManager->persist($service);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'your service was saved'
            );
            return $this->redirectToRoute('app_service');
        }
        return $this->renderForm('service/create.html.twig', [
            'form' => $form,
        ]);
    }
}
