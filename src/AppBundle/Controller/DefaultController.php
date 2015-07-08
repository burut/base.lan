<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/index", name="homepage")
     * @Template("AppBundle:Default:index.html.twig")
     */
    public function loginAction()
    {
        return array('text' => "main page");
    }

    //    создание пустого юзера с редиректом на юзер эдит
    /**
     * @Route("/user_create", name="_user_create")
     */
    public function userCreateAction()
    {
        $user = new User();
        $user->mail("");
        $user->password("");
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('_user_edit', array('id'=>$user->getId()));
    }

    /**
     * @Route("/user/edit/{id}", name="_user_edit")
     * @Template("AppBundle:Default:index.html.twig")
     */
    public function userEditAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $em->getRepository('Burut\Bundle\MenuBundle\Entity\User')->find($id);

        $form = $this->createFormBuilder($user)
            ->add('mail', 'text')
            ->add('password', 'text')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('_client_list');
        }
        return array(
            "user" => $user,
            "form" => $form->createView());
    }
}

