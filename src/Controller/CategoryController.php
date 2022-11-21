<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use App\Entity\Category;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
             'categories' => $categories
         ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);

        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->add($category, true);

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository):Response
    {
        $category = $categoryRepository->findOneByName($categoryName);
        // same as $category = $categoryRepository->find($id);
    
        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune catégorie nommée '.$categoryName

            );
        }


        $programs = $programRepository->findBy(['category'=> $category], ['id' => 'DESC'], 3);

        return $this->render('category/show.html.twig', [
            'category' => $category, 'programs' => $programs
        ]);
    }
}