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
use Burut\BaseBundle\Entity\FieldValue;
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
        $base->setUser($user);
        $base->setTitle("");
        $base->setColor("white");
        $base->setKeyfieldId("");
        $base->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($base);
        $em->flush();
        $titleValues = ["title" => "1", "type" => "4", "rank" => "4", "year" => "2", "URL" => "3", "genre" => "4"];
        foreach ($titleValues as $key => $value) {
            var_dump($key, $value);
            $baseField = new BaseField();
            $baseField->setBase($base);
            $baseField->setTitle($key);
            $fieldType = $em->getRepository("BurutBaseBundle:FieldType")->find($value);
            $baseField->setFieldType($fieldType);
            $baseField->setConfig("");
            $isShow = 0;
            if ($key = "title" or "type" or "rank" or "genre"){$isShow = 1;}
            $baseField->setIsShow($isShow);
            $baseField->setIsRequiered("");
            $em->persist($baseField);
            $em->flush();
        }

        var_dump($baseField);
        return $this->redirectToRoute('_base_edit', array('id'=>$base->getId()));
    }

    /**
     * @Route("/base_edit/{id}", name="_base_edit")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     * @Template()
     */
    public function baseEditAction($id, Request $request)
    {
        $colors = ["white","red","green","gray","yellow","blue","pink","oldlace"];
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $base = $em->getRepository("BurutBaseBundle:Base")->find($id);
        if (!$base) {
            die("base not found");
        }
        if ($user != $base->getUser()) {
            die("user not found");
        }
        if ($request->getMethod() == "POST") {
            $form = $request->request->all();
            $base->setTitle($form['title']);
            $base->setColor($form['color']);
            $em->flush();
            return $this->redirectToRoute ('_base_edit', array("id" => $id, "base" => $base));
        }
        return array(
            "base" => $base, "colors" => $colors); // "form" => $form->createView(), "baseField" => $baseField
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
     * @Route("/create_record/{id}", name="_create_record")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function createRecordAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $base = $em->getRepository("BurutBaseBundle:Base")->find($id);
        if (!$base) {
            die("base not found");
        }
        if ($user != $base->getUser()) {
            die("user not found");
        }
        $baseRow = new BaseRow();
        $baseRow->setBase($base);
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($baseRow);
        $baseFields = $base->getBaseFields();
        foreach ($baseFields as $baseField){
            $fieldValue = new FieldValue();
            $fieldValue->setBaseRow($baseRow);
            $fieldValue->setBaseField($baseField);
            $fieldValue->setValue("");
            $em->persist($fieldValue);
        }
        $em->flush();

        return $this->redirectToRoute('_edit_record', array('id'=>$baseRow->getId()));
    }

    /**
     * @Route("/base_edit_fields/{id}", name="_base_edit_fields")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function baseEditFieldsAction($id, Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $base = $em->getRepository("BurutBaseBundle:Base")->find($id);
        if (!$base) {
            die("base not found");
        }
        if ($user != $base->getUser()) {
            die("user not found");
        }
//        if ($request->getMethod() == "POST") {
//            $fields = $request->request->all();
//            foreach ($base->getBaseField() as $fieldValue) {
//                if (isset($fields[$fieldValue->getId()])) {
//                    $value = $fields[$fieldValue->getId()];
//                    $fieldValue->setValue(trim($value));
//                }
//            }
//            $em->persist($fieldValue);
//            $em->flush();
//            return $this->redirectToRoute ('_edit_record', array("id" => $baseRow->getId()));
//        }
//        $editBaseFieldArray = [];
//        foreach ($base->getBaseFields() as $baseField) {
////            $config = str_replace("\r", "", $baseField->getBaseField()->getConfig()); // заменить левый перевод строки \r на пустой символ
//            $editBaseFieldArray[$baseField->getId()] = [
//                "title" => $baseField->getBaseField()->getTitle(),
//                "value" => $baseField->getValue(),
//                "type" => $baseField->getBaseField()->getFieldType()->getCode(),
////                "config" => $config ? explode("\n", $config) : null
//            ];
//        }
////        $baseId = $base->getId();
//        return ["base" => $base, "editRecordArray" => $editRecordArray, "baseRowId" => $baseRowId]; // "values" => $values,

//        $baseRow = new BaseRow();
//        $baseRow->setBase($base);
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->persist($baseRow);
//        $baseFields = $base->getBaseFields();
//        foreach ($baseFields as $baseField){
//            $fieldValue = new FieldValue();
//            $fieldValue->setBaseRow($baseRow);
//            $fieldValue->setBaseField($baseField);
//            $fieldValue->setValue("");
//            $em->persist($fieldValue);
//        }
//        $em->flush();
//
        return array('user'=>$user, "base"=>$base );
    }

    /**
     * @Route("/base_delete/{id}/{confirm}", name="_base_delete")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */

    public function baseDeleteAction($id, $confirm=0)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getEntityManager();
        $base = $em->getRepository("BurutBaseBundle:Base")->find($id);
        if (!$base || $base->getUser() != $user) {
            die("base not found");
        }
        if ($confirm == 1) {
            $em->remove($base);
            $em->flush();
            return $this->redirectToRoute('_home', array('id'=>$base->getId()));
        }
        return ["id" => $id, "base" => $base];
    }
}
