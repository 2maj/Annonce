<?php
/**
 * Created by PhpStorm.
 * User: Moussa
 * Date: 13/05/2018
 * Time: 01:17
 */

namespace User\userBundle\Controller;


use MHT\ForumBundle\Entity\produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Connect{
    private $id;
    private $nom;

    /**
     * Connect constructor.
     * @param $id
     * @param $nom
     */
    public function __construct($id=null, $nom="")
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function homeAction(Request $request){
        $form = $this->createFormBuilder()
            ->add('id', IntegerType::class)
            ->add('nom', TextType::class)
            ->add('connexion', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $nom = $form->get('nom')->getData();
            $id = $form->get('id')->getData();
            $user = $this->getDoctrine()->getRepository('\User\userBundle\Entity\User\userBundle')->findBy(
                array('id' => $id, 'nom' => $nom));
            if($user != null) {
                return $this->redirect($this->generateUrl('connect', array('user' => $nom)));
            }
            /*
            else{
                return $this->redirect($this->generateUrl('connect', array('check' => 'ko')));
            }
            */
        }

        $content = $this->render('..\..\..\src\User\userBundle\Resources\views\home.html.twig', array("formulaire" => $form->createView()));
        return new Response($content);
    }
    public function connectAction($user){
        $content = $this->render('..\..\..\src\User\userBundle\Resources\views\connect.html.twig', array("user" => $user));
        return new Response($content);
    }
    public function user_display_allAction(){
        $users = $this->getDoctrine()->getRepository('\User\userBundle\Entity\User\userBundle')->findAll();
        $content = $this->render('..\..\..\src\User\userBundle\Resources\views\user_display_all.html.twig', array("users" => $users));
        return new Response($content);
    }
    public function user_addAction(Request $request){
        $user = new \User\userBundle\Entity\User\userBundle();
        $form = $this->createFormBuilder($user)
            ->add('type_compte', ChoiceType::class, array(
                'choices' => array(
                    '' => '',
                    'Manager' => 'Manager',
                    'Client' => 'Client',
                    'Employee' => 'Employee',
                ),
            ))
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('Creer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $entitymanager=$this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirect($this->generateUrl("begin"));
        }
        $content = $this->render('..\..\..\src\User\userBundle\Resources\views\user_add.html.twig', array("formulaire" => $form->createView()));
        return new Response($content);
    }

}