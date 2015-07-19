<?php

namespace Burut\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Burut\BaseBundle\Entity\User;
use Burut\BaseBundle\Entity\Base;
use Burut\BaseBundle\Entity\BaseField;



class DefaultController extends Controller
{
    public $text;

    /**
     * @Route("/", name="_home")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        $bases = $user->getBases();

        return array("user" => $user, "bases" => $bases);
    }


    /**
     * @Route("/login", name="_login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // получить ошибки логина, если таковые имеются
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            // имя, введённое пользователем в последний раз
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'text',
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/logout", name="_logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/register", name="_register")
     */
    public function registerAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/user_create", name="_user_create")
     */
    public function userCreateAction()
    {
        $user = new User();
        $user->setEmail("");
        $user->setPassword("");
        $user->setName("");
//        $user->set("");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('_user_edit', array('id'=>$user->getId()));
    }

    /**
     * @Route("/user/edit/{id}", name="_user_edit")
     * @Template()
     */
    public function userEditAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('BurutBaseBundle:User')->find($id);

        $form = $this->createFormBuilder($user)
            ->add('email', 'text')
            ->add('password', 'text')
            ->add('name', 'text')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('_login');
        }
        return array(
            "user" => $user,
            "form" => $form->createView());
    }

    /**
     * @Route("/base_create", name="_base_create")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function baseCreateAction()
    {
        $user = $this->getUser();
        var_dump($user);
        $base = new Base();
        $base->setUserId($user->getid());
        $base->setTitle("");
        $base->setColor("");
        $base->setKeyfieldId("");
        $base->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($base);
        $em->flush();
        var_dump($base);
        return $this->redirectToRoute('_base_edit', array('id'=>$base->getId()));
    }

    /**
     * @Route("/base_create/{id}", name="_base_edit")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     * @Template("BurutBaseBundle:Default:base_create.html.twig")
     */
    public function baseEditAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $base = $em->getRepository('BurutBaseBundle:Base')->find($id);

        $form = $this->createFormBuilder($base)
            ->add('user_id', 'text')
            ->add('title', 'text')
            ->add('color', 'text')
            ->add('keyfield_id', 'text')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($base);
            $em->flush();
            return $this->redirectToRoute('_home');
        }
        return array(
            "base" => $base,
            "form" => $form->createView());
    }

    /**
     * @Route("/film_list/{id}", name="_film_list")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function filmListAction($id, $base, Request $request)
    {
//        $base = $this->getBaseId();

//        var_dump($base);

        $baseField = $this->getDoctrine()
            ->getRepository('BurutBaseBundle:BaseField')
            ->findByBase_id($base->getid());
        var_dump($baseField);

        return array("base" => $base, "basesField" => $baseField);
    }



}
