<?php
/**
 * Created by PhpStorm.
 * User: Moussa
 * Date: 12/05/2018
 * Time: 18:29
 */

namespace annonceBundle\Controller;
use annonceBundle\Entity\annonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnnonceController extends Controller
{
    public function beginAction(){
        //$content = $this->render('..\..\..\src\annonceBundle\Resources\views\Annonce\layout.html.twig', array('name' => "moussa"));
        return $this->forward('UserBundle:User:user_display_all');
    }
    /*
    public function userAction(){
        $response = $this->forward('MHTForumBundle:Default:scanproduct');
        return $response;
    }
    */
    public function annonce_addAction(Request $request){
        $annonce = new annonce();
        $form = $this->createFormBuilder($annonce)
            ->add('titre', TextType::class)
            ->add('destinataire', ChoiceType::class, array('choices' => array(
                '' => '',
                'Manager' => 'Manager',
                'Client' => 'Client',
                'Employee' => 'Employee'),))
            ->add('date_debut', DateType::class)
            ->add('date_fin', DateType::class)
            ->add('contenu', TextareaType::class)
            ->add('Creer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $entitymanager=$this->getDoctrine()->getManager();
            $entitymanager->persist($annonce);
            $entitymanager->flush();
            return $this->redirect($this->generateUrl("annonce_list"));
        }
        $content = $this->render('..\..\..\src\annonceBundle\Resources\views\Annonce\annonce_add.html.twig', array("formulaire" => $form->createView()));
        return new Response($content);
    }
    public function annonce_listAction(){
        $annonce = $this->getDoctrine()->getRepository('\annonceBundle\Entity\annonce')->findAll();
        $content = $this->render('..\..\..\src\annonceBundle\Resources\views\Annonce\annonce_list.html.twig', array("annonces" => $annonce));
        return new Response($content);
    }

}