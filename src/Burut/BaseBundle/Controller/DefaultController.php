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
        $userName = $this->getDoctrine()
            ->getRepository('BurutBaseBundle:User')
            ->findAll();
        if (!count($userName)) {
            foreach ($this->userName as $row) {
                $userName = new userName();

                $userName->setUserID($row["id"]);
                $userName->setUserName($row["name"]);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();
                $userName[] = $user;
            }
        }
//////////////////////
        $bases = $this->getDoctrine()
            ->getRepository('BurutBaseBundle:Base')
            ->findAll();
        if (!count($bases))
        {
            foreach ($this->bases as $row)
            {
                $base = new Base();

                $base->setUserId($row["user_id"]);
                $base->setTitle($row["title"]);
                $base->setColor($row["color"]);
                $base->setKeyFieldId($row["keyField_id"]);
//                $base->setCreatedAt($row["created_at"]);

                $em = $this->getDoctrine()->getEntityManager();
                if ($userName->$id = $base->$UserId ) {
                $em->persist($base);
                $em->flush();
                $bases[] = $base;

            }}
        }

        var_dump($user);
        var_dump($bases);

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
}
