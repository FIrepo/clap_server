<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Vclap\Api\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vclap\Api\UserBundle\Entity\Document;
use \Vclap\Api\UserBundle\Entity\Documentem;
use \Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmoticonController extends Controller {

    public $DB;

    public function __construct() {
        
    }

    /**
     * @Route("/addemoticon", name="uploademticon")
     * 
     */
    public function addemoticonAction(Request $request) {
        $this->DB = $this->getDoctrine()->getConnection();
        $document = new Document();
        $form = $this->createFormBuilder($document)
                ->add('name')
                ->add('file')
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $document->upload();
            $returndata = array('data' => $document->getfname());
            $now = time();
            $valueArray = array();
            $valueArray['identifier'] = $document->name;
            $valueArray['file_id'] = $document->getfname();
            $valueArray['created'] = $now;
            $valueArray['modified'] = $now;
            $valueArray1 = array();
            $valueArray1['message'] = 'upload emoticon sucess';
            $returndatato = array('data' => json_encode($valueArray1));
            if ($this->DB->insert('emoticon', $valueArray)) {
                $idinsert = $this->DB->lastInsertId("_id");
                $valueArray1 = array();
                $valueArray1['message'] = 'emoticon added';
                $valueArray1['emoticonid'] = $idinsert;
                $returndatato = array('data' => json_encode($valueArray1));
                return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
            } else {

                $valueArray1 = array();
                $valueArray1['message'] = 'emoticon add failed';
                $returndatato = array('data' => json_encode($valueArray1));
                return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
            }
        }

        return $this->render('VclapApiUserBundle:Default:indexform.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
  /**
     * @Route("/updateemoticon", name="updateemoticon")
     * 
     */
    public function updateemoticonAction(Request $request) {
        $this->DB = $this->getDoctrine()->getConnection();
        $document = new Documentem();
        $form = $this->createFormBuilder($document)
                ->add('name')
                ->add('eid')
                ->add('file')
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $document->upload(); 
            $now = time();

        $result = $this->DB->executeupdate(
                'update emoticon set 
                    identifier = ?,
                    file_id = ?,
                    modified = ?
                    WHERE _id = ?', 
                array(
                    $document->name,
                    $document->getfname(),
                    time(),
                    $document->eid));
           
                
                $valueArray1 = array();
                $valueArray1['message'] = 'emoticon updated';
                $valueArray1['emoticonid'] = $document->eid;
                $returndatato = array('data' => json_encode($valueArray1));
                return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
            
        }

        return $this->render('VclapApiUserBundle:Default:indexform.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/getemoticoncount", name="emoticoncount")
     * 
     */
    public function getemoticoncountAction() {
        $this->DB = $this->getDoctrine()->getConnection();
        $query = "select count(*) as count from emoticon";
        $result = $this->DB->fetchColumn($query);
        $valueArray1 = array();
        $valueArray1['emoticoncount'] = $result;
        $returndatato = array('data' => json_encode($valueArray1));
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
/**
     * @Route("/getallemoticons", name="getallemoticons")
     * 
     */
    public function getallemoticonsAction() {
        $this->DB = $this->getDoctrine()->getConnection();
        $query = "select * from emoticon";
        $result = $this->DB->fetchAll($query);
        $returndatato = array('data' => json_encode($result));
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
    /**
     * @Route("/getemoticonbyid", name="emoticongetbyid")
     * 
     */
    public function getemoticonbyidAction(Request $request) {
        if ($request->get('id') == NULL) {
            $valueArray1 = array();
            $valueArray1['message'] = 'id param not recieved';
            $returndatato = array('data' => json_encode($valueArray1));
            return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
        }
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAssoc('select * from emoticon where _id = ?', array($request->get('id')));
        ;
        $returndatato = array('data' => json_encode($result));
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
        /**
     * @Route("/getallemoticonsbypaging", name="getallemoticonsbypaging")
     * 
     */
    public function getallemoticonsbypagingAction(Request $request) {
        $count=1;
        $offset=0;
        if ($request->get('count') == NULL) {
            $valueArray1 = array();
            $valueArray1['message'] = 'param count not recieved';
            $returndatato = array('data' => json_encode($valueArray1));
            return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
        }
         if (!$request->get('offset') == NULL) {
         $offset=$request->get('offset');
         }
         $count=$request->get('count');
        $this->DB = $this->getDoctrine()->getConnection();
         $query = "select * from emoticon order by _id ";
        
        if($count != 0){
            $query .= " limit {$count} offset {$offset} ";
        }
        
        
        $result = $this->DB->fetchAll($query);
        $returndatato = array('data' => json_encode($result));
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
      /**
     * @Route("/getemoticonimagebyid", name="getemoticonimagebyid")
     * 
     */
    public function getemoticonimagebyidAction(Request $request) {
        if ($request->get('id') == NULL) {
            $valueArray1 = array();
            $valueArray1['message'] = 'id param not recieved';
            $returndatato = array('data' => json_encode($valueArray1));
            return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
        }
         $fileDir = $this->getUploadRootDir();
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAssoc('select * from emoticon where _id = ?', array($request->get('id')));
        ;
        $filePath = $fileDir . $result['file_id'];
        $returndatato = array('data' => $filePath);
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
 /**
     * @Route("/getemoticonbyidentifier", name="getemoticonbyidentifier")
     * 
     */
    public function getemoticonbyidentifierAction(Request $request) {
        if ($request->get('identity') == NULL) {
            $valueArray1 = array();
            $valueArray1['message'] = 'identity param not recieved';
            $returndatato = array('data' => json_encode($valueArray1));
            return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
        }
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAssoc('select * from emoticon where identifier = ?', array($request->get('identity')));
        ;
        $returndatato = array('data' => json_encode($result));
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
    /**
     * @Route("/deleteemoticonbyid", name="emoticondeletebyid")
     * 
     */
    public function deleteemoticonbyidAction(Request $request) {
        if ($request->get('id') == NULL) {
            $valueArray1 = array();
            $valueArray1['message'] = 'id param not recieved';
            $returndatato = array('data' => json_encode($valueArray1));
            return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
        }
        $this->DB = $this->getDoctrine()->getConnection();
        $this->DB->delete('emoticon', array('_id' => $request->get('id')));
        $valueArray1 = array();
        $valueArray1['message'] = 'deleted';
        $returndatato = array('data' => json_encode($valueArray1));
        return $this->render('VclapApiUserBundle:Default:index.html.twig', $returndatato);
    }
  protected function getUploadRootDir()
    {
        
        // the absolute directory path where uploaded
        // documents should be saved
        return dirname(dirname(dirname(dirname(dirname(__DIR__))))).DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents/';
    }
}
