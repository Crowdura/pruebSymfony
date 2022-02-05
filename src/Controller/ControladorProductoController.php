<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use App\Form\CreateProyectoType;
use App\Form\EditProductoType;
use App\Form\EliminarProductoType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControladorProductoController extends AbstractController
{
    /**
     * @Route("/", name="controlador_producto")
     */
    public function index(ProductoRepository $productoRepository): Response
    {
        return $this->render('controlador_producto/index.html.twig', [
            'Contenido_Productos' => $productoRepository->findAll()
        ]);
    }

    /**
     * @Route("/(Producto/VistaProducto/{id}", name="VistaProducto")
    */
    public function Vista(Producto $producto)
    {
       return $this->render("controlador_producto/VistaProducto.html.twig",[
          'contenido_Producto' => $producto
       ]);
    }

    /**
     * @Route("/Producto/Crear", name="CrearProducto")
    */
    public function Crear(Request $request, EntityManagerInterface $entityManagerInterface){
       $Producto = new Producto();

       $Form_Crear = $this->createForm(CreateProyectoType::class, $Producto);
       $Form_Crear->handleRequest($request);
       if($Form_Crear->isSubmitted() && $Form_Crear->isValid())
       {
          $entityManagerInterface->persist($Producto);
          $entityManagerInterface->flush();

          return $this->redirectToRoute('controlador_producto');
       }
       return $this->render('controlador_producto/Crear.html.twig',[
          'Form_Crear' => $Form_Crear->createView()
       ]);
    }

    /**
     * @Route("/Producto/Edit/{id}", name="EditProducto")
    */
    public function Edit(Request $request, Producto $producto, ManagerRegistry $Doctrine)
    {
        $Producto = $Doctrine->getManager()->getRepository(Producto::class)->find($producto);

        $Form_Editar = $this->createForm(EditProductoType::class, $Producto);
        $Form_Editar->handleRequest($request);
        if($Form_Editar->isSubmitted() && $Form_Editar->isValid())
        {
           $Doctrine->getManager()->persist($Producto);
           $Doctrine->getManager()->flush();

           return $this->redirectToRoute('VistaProducto',['id' => $producto->getId()]);
        }
        return $this->render('controlador_producto/Editar.html.twig',[
            'Form_Edit' => $Form_Editar->createView()
        ]);
    }

    /**
     * @Route("/Producto/Eliminar/{id}", name="EliminarProducto")
    */
    public function Borrar(Request $request, Producto $producto, EntityManagerInterface $entityManagerInterface)
    {
        $Form_Eliminar = $this->createForm(EliminarProductoType::class, $producto);
        $Form_Eliminar->handleRequest($request);
        if($Form_Eliminar->isSubmitted() && $Form_Eliminar->isValid())
        {
           $entityManagerInterface->remove($producto);
           $entityManagerInterface->flush();

          return $this->redirectToRoute('controlador_producto');
        }

        return $this->render('controlador_producto/Eliminar.html.twig',[
            'Form_Eliminar' => $Form_Eliminar->createView()
        ]);
    }
}
