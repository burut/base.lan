<?php

namespace Burut\BaseBundle\Controller;

use Burut\BaseBundle\Entity\BaseRow;
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
use Doctrine\Common\Collections\ArrayCollection;


class DefaultController extends Controller
{
    public $text;

    public $confirm = 0;

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
        $base = new Base();
        $base->setUserId($user->getid());
        $base->setTitle("");
        $base->setColor("");
        $base->setKeyfieldId("");
        $base->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($base);
        $em->flush();
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
     * @Route("/base_show/{id}", name="_base_show")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function baseShowAction($id, Request $request)
    {
        $user = $this->getUser();

//        // Способ 1 - выбираем только по id базы, а потом уже проверяем юзера на пхп
//        $base = $this->getDoctrine()->getRepository("BurutBaseBundle:Base")->find($id);
//        if (!$base || $base->getUser() != $user) {
//            die("base not found");
//        }

        $base = $this->getDoctrine()->getRepository("BurutBaseBundle:Base")
            ->findOneBy(["id" => $id, "user" => $user]);
        if (!$base) {
            die("base not found");
        }

        $baseFields = $base->getBaseFields();

        $values = [];
        foreach ($base->getBaseRows() as $row) { // получаем массив строк нужной базы
            foreach ($row->getFieldValues() as $fieldValue) {  // получаем значения полей строки
                $values[$row->getId()][$fieldValue->getBaseField()->getId()] = $fieldValue->getValue();
            }
        }

        return ["base" => $base, "fields" => $baseFields, "values" => $values];
    }

    /**
     * @Route("/view_record/{id}", name="_view_record")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function viewRecordAction($id, Request $request)
    {
        $user = $this->getUser();
        $baseRow = $this->getDoctrine()->getRepository("BurutBaseBundle:BaseRow")
            ->findOneBy(["id" => $id]);
        $base = $baseRow->getBase();
        if ($user != $base->getUser()) {
            die("user not found");
        }
        if (!$base) {
            die("base not found");
        }
        $values = [];
        foreach ($baseRow->getFieldValues() as $fieldValue) {  // получаем значения полей строки
            $values[$fieldValue->getBaseField()->getTitle()] = $fieldValue->getValue();
        }
        $baseRowId = $baseRow->getId();

        return ["base" => $base, "values" => $values, "baseRowId" => $baseRowId];
    }


    /**
     * @Route("/record_delete/{id}/{confirm}", name="_record_delete")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */


    public function recordDeleteAction($id, $confirm=0)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $baseRow = $em->getRepository("BurutBaseBundle:BaseRow")->find($id);
        $base = $baseRow->getBase();

        if (!$base || $base->getUser() != $user) {
            die("base not found");
        }

        if ($confirm == 1) {
            $em->remove($baseRow);
            $em->flush();
            return $this->redirectToRoute('_base_show', array('id'=>$base->getId()));
        }

        $values = [];
        foreach ($baseRow->getFieldValues() as $fieldValue) {  // получаем значения полей строки
            $values[$fieldValue->getBaseField()->getTitle()] = $fieldValue->getValue();
        }
        $baseRowId = $baseRow->getId();


        return ["id" => $id, "base" => $base, "values" => $values, "baseRowId" => $baseRowId];
//        $em = $this->getDoctrine()->getEntityManager();
//        $furn = $em->getRepository('Burut\Bundle\MenuBundle\Entity\Furnit')->find($id);
//
//        if (!$furn) {
//            throw $this->createNotFoundException('No furniture found for id '.$id);
//        }
//
//        $em->remove($furn);
//        $em->flush();
//
//        return $this->redirectToRoute('_furn_list');
    }

    /**
     * @Route("/edit_record/{id}", name="_edit_record")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function editRecordAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $baseRow = $em->getRepository("BurutBaseBundle:BaseRow")->find($id);
        $user = $this->getUser();
        $base = $baseRow->getBase();
        if ($user != $base->getUser()) {
            die("user not found");
        }
        if (!$base) {
            die("base not found");
        }

        if ($request->getMethod() == "POST") {
            $fields = $request->request->all();

            foreach ($baseRow->getFieldValues() as $fieldValue) {
                if (isset($fields[$fieldValue->getId()])) {
                    $value = $fields[$fieldValue->getId()];
                    $fieldValue->setValue(trim($value));
                }
            }
            $em->persist($fieldValue);
            $em->flush();
            return $this->redirectToRoute ('_edit_record', array("id" => $baseRow->getId()));
        }

        $editRecordArray = [];
        foreach ($baseRow->getFieldValues() as $fieldValue) {
            $config = str_replace("\r", "", $fieldValue->getBaseField()->getConfig()); // заменить левый перевод строки \r на пустой символ

            $editRecordArray[$fieldValue->getId()] = [
                "field" => $fieldValue->getBaseField()->getTitle(),
                "value" => $fieldValue->getValue(),
                "type" => $fieldValue->getBaseField()->getFieldType()->getCode(),
                "config" => $config ? explode("\n", $config) : null
            ];
        }
        $baseRowId = $baseRow->getId();

        return ["base" => $base, "editRecordArray" => $editRecordArray, "baseRowId" => $baseRowId]; // "values" => $values,
    }
    /**
     * @Route("/create_record", name="_create_record")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function createRecordAction()
    {
//        $em = $this->getDoctrine()->getEntityManager();
//        $baseRow = $em->getRepository("BurutBaseBundle:BaseRow")->find($id);
//        $user = $this->getUser();
//        $base = $baseRow->getBase();

        $baseRow = new BaseRow();
        $baseRow->setBaseId($base->getId());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($baseRow);
        $em->flush();

//        $em = $this->getDoctrine()->getEntityManager();
//        $baseRow = $em->getRepository("BurutBaseBundle:BaseRow")->find($id);
//        $user = $this->getUser();
//        $base = $baseRow->getBase();
//        if ($user != $base->getUser()) {
//            die("user not found");
//        }
//        if (!$base) {
//            die("base not found");
//        }

//        if ($request->getMethod() == "POST") {
//            $fields = $request->request->all();
//
//            foreach ($baseRow->getFieldValues() as $fieldValue) {
//                if (isset($fields[$fieldValue->getId()])) {
//                    $value = $fields[$fieldValue->getId()];
//                    $fieldValue->setValue(trim($value));
//                }
//            }
//            $em->persist($fieldValue);
//            $em->flush();
//            return $this->redirectToRoute ('_edit_record', array("id" => $baseRow->getId()));
//        }

//        $editRecordArray = [];
//        foreach ($baseRow->getFieldValues() as $fieldValue) {
//            $config = str_replace("\r", "", $fieldValue->getBaseField()->getConfig()); // заменить левый перевод строки \r на пустой символ
//
//            $editRecordArray[$fieldValue->getId()] = [
//                "field" => $fieldValue->getBaseField()->getTitle(),
//                "value" => $fieldValue->getValue(),
//                "type" => $fieldValue->getBaseField()->getFieldType()->getCode(),
//                "config" => $config ? explode("\n", $config) : null
//            ];
//        }
//        $baseRowId = $baseRow->getId();

        return $this->redirectToRoute('_edit_record', array('id'=>$baseRow->getId()));    }

}
