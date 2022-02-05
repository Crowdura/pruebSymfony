<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\CrearCategoriaType;
use App\Form\EditarCategoriaType;
use App\Form\BorrarCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControladorCategoryController extends AbstractController
{
    /**
     * @Route("/Category", name="controlador_category")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('controlador_category/index.html.twig', [
            'Categorias' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/Category/VistaCategoria/{id}", name="VistaCategoria")
    */
    public function Vista(Category $category)
    {
       return $this->render('controlador_category/VistaCategory.html.twig',[
          "contenidoCategoria" => $category,
       ]);
    }

    /**
     * @Route("/Category/Crear", name="CrearCategoria")
    */
    public function Crear(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $category = new Category();

        $Form_Crear = $this->createForm(CrearCategoriaType::class, $category);
        $Form_Crear->handleRequest($request);
        if($Form_Crear->isSubmitted() && $Form_Crear->isValid())
        {
          $entityManagerInterface->persist($category);
          $entityManagerInterface->flush();

          return $this->redirectToRoute('controlador_category');
        }

        return $this->render('controlador_category/Crear.html.twig',[
            'Form_Crear' => $Form_Crear->createView(),
        ]);
    }

    /**
     * @Route("/Category/Edit/{id}", name="EditarCategoria")
    */
    public function Editar(Request $request,Category $category, ManagerRegistry $doctrine)
    {
        $Categoria = $doctrine->getManager()->getRepository(Category::class)->find($category);
       
        $Form_Edit = $this->createForm(EditarCategoriaType::class, $Categoria);
        $Form_Edit->handleRequest($request);
        if($Form_Edit->isSubmitted() && $Form_Edit->isValid())
        {
           $doctrine->getManager()->persist($Categoria); 
           $doctrine->getManager()->flush();

           return $this->redirectToRoute('VistaCategoria',["id"=> $category->getId()]);
        }
        return $this->render("controlador_category/Editar.html.twig",[
            'Form_Edit' => $Form_Edit->createView(),
            'Id_Catalogo' => $category->getId(),
        ]);
    }

    /**
     * @Route("/Category/Eliminar/{id}", name="EliminarCategoria")
    */
    public function Borrar(Request $request,Category $category, EntityManagerInterface $entityManager)
    {
       $Form_Eliminar = $this->createForm(BorrarCategoryType::class, $category);
       $Form_Eliminar->handleRequest($request);
       if($Form_Eliminar->isSubmitted() && $Form_Eliminar->isValid())
       {
         $entityManager->remove($category);
         $entityManager->flush();
        
         return $this->redirectToRoute('controlador_category');
       }
       return $this->render('controlador_category/Eliminar.html.twig',[
          'Form_Eliminar' => $Form_Eliminar->createView(),
          'Id_Catalogo' => $category->getId(),
       ]);
    }
}
