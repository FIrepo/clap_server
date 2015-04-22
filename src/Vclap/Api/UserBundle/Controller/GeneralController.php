<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vclap\Api\UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use \Symfony\Component\HttpFoundation\Request;
use \Doctrine\Common\Collections\ArrayCollection;

class GeneralController extends FOSRestController {

    public $DB;

    public function __construct() {
        
    }
     public function changepasswordAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('userId') == NULL) {
            $returndata1 = array('message' => 'no userId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('newPassword') == NULL) {
            $returndata1 = array('message' => 'no newPassword param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        
        $res = $this->changePassword($requestdata->get('userId'),$requestdata->get('newPassword'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function forgotpasswordAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('email') == NULL) {
            $returndata1 = array('message' => 'no email param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $pass=$this->findUserByEmail($requestdata->get('email'));
        if($pass==NULL){
             $res = array('message' => 'Invalid Registered emailId!');
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view); 
        }
        else{
  $messaggio = \Swift_Message::newInstance()
                ->setSubject('Vclap Password Retrieval')
                ->setFrom('vigneshforegoing@gmail.com')
                ->setTo($requestdata->get('email'))->setContentType("text/html")
                ->setBody($this->renderView('VclapApiUserBundle:Default:indexemail.html.twig',array('password' =>$pass)));
                $this->get('mailer')->send($messaggio);
        $res = array('message' => 'Password sent to registered emailId!');
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
        }
    }
     public function getlastloginuserscountAction(Request $requestdata) {
         $res=  $this->getLastLoginedUsersCount();
         $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
     }
        public function getLastLoginedUsersCount(){
        $this->DB = $this->getDoctrine()->getConnection();
        $timeFrom = time() - 60 * 60 * 24;
        $query = "select count(*) as count from message where created > {$timeFrom}";
        $result = $this->DB->fetchColumn($query);
        return $result;
    }
        public function findUserByEmail($email) {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where email = ?', array($email));
        return $user['password'];
    }
    public function changePassword($userId,$newPassword){
            $this->DB = $this->getDoctrine()->getConnection();
            $this->DB->executeUpdate('update user set password = ?,token=\'\' where _id = ?',
                    array($newPassword,$userId));
                    
            $result = $this->DB->executeUpdate('update password_change_request set valid = 0 where user_id = ?',
                    array($userId));
        return $result;
    }
}