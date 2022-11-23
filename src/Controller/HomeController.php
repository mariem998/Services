<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ServiceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $serviceRepository;
    private $categoryRepository;
    private $entityManager;

    public function __construct(
        ServiceRepository $serviceRepository,
        CategoryRepository $categoryRepository,
        ManagerRegistry $doctrine
    ){
        $this->serviceRepository = $serviceRepository;
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $services = $this->serviceRepository->findAll();
        return $this->render('home/index.html.twig', [
            'services' => 'services',
        ]);
    }

//    #[Route('/service/{category}', name: 'service_category')]
//    public function categoryServices(Category $category): Response
//    {
//        $categories= $this->categoryRepository->findAll();
//        return $this->render('home/index.html.twig', [
//            'services' => $category->getProducts(),
//            'categories' =>$categories,
//            'photo_url' => 'http://127.0.0.1:8000/uploads/'
//        ]);
//    }
}
