<?php

namespace MHTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
/*    public function indexAction($name)
    {

       $content = $this->get('templating')->render('MHTBundle:Default:index.html.twig');
       return new Response($content);

       return $this->render(
           'MHTBundle:Default:index.html.twig',
           array('name' => $name)
       );
	}
	*/
    public function homeAction()
    {
        return $this->render('MHTBundle:Default:home.html.twig');
    }
}
