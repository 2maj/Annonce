<?php

namespace MHT\ForumBundle\Controller;

use MHT\ForumBundle\Entity\produit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        //return $this->render('MHTForumBundle:Default:index.html.twig');
        $content = $this->get('templating')->render('MHTForumBundle:index.html.twig');
        return new Response($content);
		//return array("name" => $name);
	}
    /**
     * @Route("/sum/{a}/{b}")
     * @Template()
     */
	public function sumAction($a, $b){
	    $s=$a+$b;
        return array("name" => $s);
    }
    /**
     * @Route("/addproduit/{n}/{prix}")
     * @Template()
     */
    public function addproduitAction($n, $prix){
        $p= new produit();
        $p->setNom($n);
        $p->setPrix($prix);
        $entitymanager= $this->getDoctrine()->getManager(); //Pour accéder à la bdd
        $entitymanager->persist($p); //enregistrer dans la bdd
        $entitymanager->flush(); //envoi de l'enregistrement
        return array("produit" => $p);
    }
    /**
     * @Route("/listproduit", name="listproduit")
     * @Template()
     */
    public function listproduitAction(){
        $produits=$this->getDoctrine()->getRepository("MHTForumBundle:produit")->findAll();
        return array("produits" => $produits);
    }
    /**
     * @Route("/data/{id}/{nom}", name="data")
     * @Template()
     */
    public function dataAction($nom, $id)
    {
        return array("nom" => $nom, "id" => $id);
    }
    /**
     * @Route("/scanproduct/")
     * @Template()
     */
    public function scanproductAction(Request $request){
        $p= new produit();
        $form=$this->createFormBuilder($p)
            ->add('nom', TextType::class)
            ->add('prix', TextType::class)
            ->add('Add', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            /*
             * Pour récuper les données du formulaire
            $nom = $form->get('nom')->getData();
            $id = $form->get('prix')->getData();
            return  $this->redirect($this->generateUrl('data', array("id" => $id, "nom" => $nom)));
            */
            $entitymanager=$this->getDoctrine()->getManager();
            $entitymanager->persist($p);
            $entitymanager->flush();
            return $this->redirect($this->generateUrl("listproduit"));
        }
        return array("formulaire" => $form->createView());
    }
}
