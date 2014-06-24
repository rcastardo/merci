<?php

namespace Merci\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('MerciCatalogBundle:Product')
            ->findAll();
        if (empty($products)) {
            throw $this->createNotFoundException('No products avaiable');
        }
        return $this->render('MerciCatalogBundle:Default:index.html.twig',
            array('products' => $products)
        );
    }

    public function productAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('MerciCatalogBundle:Product')
            ->findOneById($id);
        if(!$product) {
            throw $this->createNotFoundException('No product found with id: ' . $id);
        }
        return $this->render('MerciCatalogBundle:Default:product.html.twig',
            array('product' => $product)
        );
    }

    public function searchAction()
    {
        /*
        Sintaxe alternativa com QueryBuilder

        $repository = $this->getDoctrine()
        ->getRepository('MerciCatalogBundle:Product');
        $query = $repository->createQueryBuilder('p')
        ->where('p.name LIKE :find')
        ->setParameter('find', '%'.$find.'%')
        ->getQuery();
        $products = $query->getResult();
        */

        $request = $this->getRequest();
        $find = $request->query->get('find');
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('
            SELECT p FROM MerciCatalogBundle:Product p WHERE p.name LIKE :find
        ')->setParameter('find', '%' . $find . '%');
        $products = $query->getResult();
        if (empty($products)) {
            throw $this->createNotFoundException('No products avaiable');
        }
        return $this->render('MerciCatalogBundle:Default:index.html.twig',
            array('products' => $products, 'find' => $find)
        );
    }

}