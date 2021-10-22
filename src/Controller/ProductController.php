<?php

namespace App\Controller;

use App\Form\productType;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\core\Type\FormType;
use Symfony\Component\Form\Extension\core\Type\SubmitType;
use Symfony\Component\Form\Extension\core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;



class ProductController extends AbstractController
{
    #[Route('/product', name: 'product')]
    public function show(Request $request, EntityManagerInterface $entitymanager)
    {
        $product = new Product();
        $form = $this->createForm(productType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return new Response('submited successfully');
        }
        return $this->render('product/index.html.twig', [
            'submit_form' => $form->createView(),
        ]);
    }
}
