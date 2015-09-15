<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/admin/products", name="product_list")
     */
    public function listAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/products/new", name="product_new")
     * @Method("GET")
     */
    public function newAction()
    {
        sleep(1);

        return $this->render('product/_product_new.html.twig');
    }

    /**
     * @Route("/admin/products/new", name="product_new_handle")
     * @Method("POST")
     */
    public function handleNewAction(Request $request)
    {
        // really quick (but dangerous) way to load my data into a Product

        $product = new Product();
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');

        $product->author = $this->getUser();
        $this->getDoctrine()->getManager()->persist($product);
        $this->getDoctrine()->getManager()->flush();


        $this->addFlash('success', 'Product created FTW!');

        return $this->redirect($this->generateUrl('product_list'));
    }
}