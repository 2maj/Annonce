<?php
/**
 * Created by PhpStorm.
 * User: Moussa
 * Date: 12/05/2018
 * Time: 18:29
 */

namespace annonceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
    public function annonce_listAction(){
        return;
    }

}