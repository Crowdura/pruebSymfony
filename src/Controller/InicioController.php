<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    /**
     * @Route("/PruebaAjaxInicio", name="PruebaAjaxInicio")
     */
    public function index(ProductoRepository $productRepository)
    {
        return $this->render('inicio/index.html.twig', [
        ]);
    }

    /**
     * @Route( "/PruebaAjax", name="PruebaAjax", options={"expose"=true} )
     */
    public function verificacion(Request $request , ManagerRegistry $Doctrine): Response
    {

        $Manager = $Doctrine->getManager();
        $Productos = $Manager->getRepository(Producto::class)->findAll();

        if($request->isXmlHttpRequest()){

           $jsonData = array();  
           $idx=0;

           foreach( $Productos as $Producto ) {  

            $temp = array(

                'Id' => $Producto->getId(),
                'Codigo' => $Producto->getCode(),
                'name' => $Producto->getName(),  
                'Category' => $Producto->getCategorya()->getName(),
                'Marca' => $Producto->getBrand(),
                'price' =>$Producto->getPrice(),  
                'Creado' => $Producto->getCreatedaAt(),
                'Actualizado'=> $Producto->getUpdateAt(),
            );

            $jsonData[$idx++] = $temp;  
         } 
           return new JsonResponse($jsonData);
        }
        else{
          throw new \Exception('Alerta Inteto malicioso');
        }
    }
}
