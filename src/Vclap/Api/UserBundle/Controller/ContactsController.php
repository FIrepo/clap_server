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

class ContactsController extends FOSRestController {
    public $DB;

    public function __construct() {
        
    }
    public function getmycontactsAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('userId') == NULL) {
            $returndata1 = array('message' => 'no userId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        
        $res = $this->getContactsByUserId($requestdata->get('userId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
     public function getmycontactedAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('userId') == NULL) {
            $returndata1 = array('message' => 'no userId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        
        $res = $this->getContactedByUserId($requestdata->get('userId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function addcontactAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         $returndata = array('message' => 'Unknown');
        $requestcontent = $requestdata->getContent();
        if (empty($requestcontent)) {
            $returndata = array('message' => 'No params Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $decodearray = json_decode($requestcontent, true);
        $content = new ArrayCollection($decodearray);
    if ($content->get('user_id') == NULL) {
            $returndata = array('message' => 'No user_id param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        if ($content->get('contact_user_id') == NULL) {
            $returndata = array('message' => 'No contact_user_id param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
         $valueArray = array();
        $valueArray['user_id'] = $content->get('user_id');
        $valueArray['contact_user_id'] = $content->get('contact_user_id');
        $valueArray['created'] = time();
        

        if($this->DB->insert('user_contact',$valueArray)){
             $returndata = array('message' => 'contact added');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }else{
             $returndata = array('message' => 'contact add failed');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
    }
    public function removecontactAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         $returndata = array('message' => 'Unknown');
        $requestcontent = $requestdata->getContent();
        if (empty($requestcontent)) {
            $returndata = array('message' => 'No params Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $decodearray = json_decode($requestcontent, true);
        $content = new ArrayCollection($decodearray);
    if ($content->get('user_id') == NULL) {
            $returndata = array('message' => 'No user_id param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        if ($content->get('contact_user_id') == NULL) {
            $returndata = array('message' => 'No contact_user_id param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }      
       $contact = $this->DB->fetchAssoc('select _id from user_contact where user_id = ? and contact_user_id = ?',
                                        array($content->get('user_id'),$content->get('contact_user_id')));       
        $this->DB->delete('user_contact', array('_id' => $contact['_id']));
        $returndata = array('message' => 'contact deleted');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
    }
    
    
     public function getContactsByUserId($userId){
        $query = "select * from user where _id in (select contact_user_id from user_contact where user_id = ?)";
        $users = $this->DB->fetchAll($query,array($userId));
        return $users;
    }
    
    public function getContactedByUserId($userId){
        $query = "select * from user where _id in (select user_id from user_contact where contact_user_id = ?)";
        $users = $this->DB->fetchAll($query,array($userId));
        return $users;
    }
}