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

class StoryController extends FOSRestController {

    public $DB;

    public function __construct() {
  
    }
     public function createstoryAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('title') == NULL) {
            $returndata1 = array('message' => 'no title param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('content') == NULL) {
            $returndata1 = array('message' => 'no content param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('user_id') == NULL) {
            $returndata1 = array('message' => 'no user_id param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
           if ($requestdata->get('story_url') == NULL) {
            $returndata1 = array('message' => 'no story_url param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->createStory($requestdata->get('title'),$requestdata->get('content'),$requestdata->get('user_id'),$requestdata->get('story_url'));
        $view = $this->view(array("message"=>"story add success"), 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
     public function getstorycommentcountAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         
        if ($requestdata->get('storyId') == NULL) {
            $returndata1 = array('message' => 'no storyId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        $res = $this->getStoryCommentCount($requestdata->get('storyId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function getstorycountAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         
        
        $res = $this->findStoriesCount();
        $view = $this->view(array("message"=>$res), 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
      public function getstorycommentsAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         
        if ($requestdata->get('storyId') == NULL) {
            $returndata1 = array('message' => 'no storyId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
         if ($requestdata->get('offset') == NULL) {
            $returndata1 = array('message' => 'no offset param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        if ($requestdata->get('count') == NULL) {
            $returndata1 = array('message' => 'no count param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        $res = $this->getCommentsForStory($requestdata->get('storyId'),$requestdata->get('offset'),$requestdata->get('count'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
         public function getallstoriesbykeyAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
      if ($requestdata->get('keyword') == NULL) {
            $returndata1 = array('message' => 'no keyword param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
         if ($requestdata->get('offset') == NULL) {
            $returndata1 = array('message' => 'no offset param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        if ($requestdata->get('count') == NULL) {
            $returndata1 = array('message' => 'no count param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        $res = $this->findNews($requestdata->get('keyword'),$requestdata->get('offset'),$requestdata->get('count'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
     public function getallstoriesAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
      
         if ($requestdata->get('offset') == NULL) {
            $returndata1 = array('message' => 'no offset param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        if ($requestdata->get('count') == NULL) {
            $returndata1 = array('message' => 'no count param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        $res = $this->findAllNews($requestdata->get('offset'),$requestdata->get('count'));
        
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function getCommentsForStory($storyId,$offset = 0,$count=0)
    {
    	$this->DB = $this->getDoctrine()->getConnection();
        
    	$query = "select * from news_comment where story_id =? ";
    	 
    	if($count != 0){
    		$query .= " limit {$count} offset {$offset} ";
    	}
    	 
    	$result = $this->DB->fetchAll($query, array($storyId));
    	 
    	$formatedComments = array();
    	
    	foreach($result as $comment){
    		$comment = $this->reformatCommentData($comment);
    		$formatedComments[] = $comment;
    	}
    
    	return $formatedComments;
    
    }
    
    
    
      public function deletestoryAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         
        if ($requestdata->get('storyId') == NULL) {
            $returndata1 = array('message' => 'no storyId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
          
        $res = $this->deleteStory($requestdata->get('storyId'));
        $view = $this->view(array('message' => 'story deleted'), 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
        public function getStoryCommentCount($storyId){
            $this->DB = $this->getDoctrine()->getConnection();
    	$query = "select count(*) as count from news_comment where story_id = ?";
    	
    	$result = $this->DB->fetchColumn($query, array($storyId));
    	
    	return $result;
    }
      public function addstorycommentAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('comment') == NULL) {
            $returndata1 = array('message' => 'no comment param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('user_id') == NULL) {
            $returndata1 = array('message' => 'no user_id param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('user_name') == NULL) {
            $returndata1 = array('message' => 'no user_name param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
           if ($requestdata->get('story_id') == NULL) {
            $returndata1 = array('message' => 'no story_id param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->addCommentForStory($requestdata->get('comment'),$requestdata->get('user_id'),$requestdata->get('user_name'),$requestdata->get('story_id'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function updatestoryAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('title') == NULL) {
            $returndata1 = array('message' => 'no title param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('content') == NULL) {
            $returndata1 = array('message' => 'no content param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('storyId') == NULL) {
            $returndata1 = array('message' => 'no storyId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
           if ($requestdata->get('story_url') == NULL) {
            $returndata1 = array('message' => 'no story_url param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->updateStory($requestdata->get('storyId'),$requestdata->get('title'),$requestdata->get('content'),$requestdata->get('story_url'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function createStory($title,$content,$user_id,$story_url){
         $this->DB = $this->getDoctrine()->getConnection();
    
    	$newsData = array(
    			'title' => $title,
    			'content' => $content,
    			'story_url' => $story_url,
    			'user_id' => $user_id,
    			'modified' => time(),
    			'created' => time()
    	);
    
    	if($this->DB->insert('`news`',$newsData)){
    		return array(
    				'ok' => 1,
    				'id' => $this->DB->lastInsertId("_id")
    		);
    	}else{
    		return null;
    	}
    
    }
    public function findStoriesCount()
    {
        $this->DB = $this->getDoctrine()->getConnection();
    	$query = "select count(*) as count from `news`";
    
    	$result = $this->DB->fetchColumn($query);
    
    	return $result;
    }
    public function addCommentForStory($comment,$user_id,$user_name,$story_id){
    	$this->DB = $this->getDoctrine()->getConnection();
    	$commentData = array();
    	$commentData['story_id'] = $story_id;
    	$commentData['user_id'] = $user_id;
    	$commentData['comment'] = $comment;
    	$commentData['user_name'] = $user_name;
    	$commentData['created'] = time();
    	
    	if($this->DB->insert('news_comment',$commentData)){
    		return array(
    				'ok' => 1,
    				'id' => $this->DB->lastInsertId("_id")
    		);
    	}else{
    		return null;
    	}
    }
    public function deleteStory($storyId){
    $this->DB = $this->getDoctrine()->getConnection();
    
    	$this->DB->delete('`news`', array('_id' => $storyId));
    
    	return array(
    			'ok' => 1,
    			'id' => $storyId,
    			'rev' => 'tmprev'
    	);
    }
     public function updateStory($storyId,$title,$content,$story_url){
     $this->DB = $this->getDoctrine()->getConnection();
    
    	$now = time();
    
    	$result = $this->DB->executeupdate(
    			'update `news` set
                    title = ?,
                    content = ?,
    				story_url = ?,
    				modified = ?
                    WHERE _id = ?',
    			array(
    					$title,
    					$content,
    					$story_url,
    					time(),
    					$storyId));
    
    	if($result){
    		return array("message"=>"story update success");
    	}else{
    		$arr = array('message' => 'update story error!', 'error' => 'logout');
    		return json_encode($arr);;
    	}
    
    	return null;
    
    }
     public function findAllNews($offset = 0,$count=0)
    {
        
    	   $this->DB = $this->getDoctrine()->getConnection();
    	$query = "select news._id,user_id,title,content,story_url,news.created,news.modified,name,avatar_file_id,avatar_thumb_file_id from news left join user on user._id = news.user_id order by news.created desc  ";
    	
    	if($count != 0){
    		$query .= " limit {$count} offset {$offset} ";
    	}
    	
    	$result = $this->DB->fetchAll($query);
    	
    	$formatedNews = array();
    	foreach($result as $story){
    		$story = $this->reformatStoryData($story);
    		$formatedNews[] = $story;
    	}
    
    	return $formatedNews;
    
    }
     public function findNews($keyword,$offset = 0,$count=0)
    {
    	
    	$query = "select news._id,user_id,title,content,story_url,news.created,news.modified,name,avatar_file_id,avatar_thumb_file_id from news left join user on user._id = news.user_id where title like '%".$keyword."%' order by created desc";
    	
    	if($count != 0){
    		$query .= " limit {$count} offset {$offset} ";
    	}
    	
    	$result = $this->DB->fetchAll($query);
    	
    	$formatedNews = array();
    	foreach($result as $story){
    		$story = $this->reformatStoryData($story);
    		$formatedNews[] = $story;
    	}
    
    	return $formatedNews;
    
    }
    public function reformatStoryData($story){
    
    	$story['created'] = intval($story['created']);
    	$story['modified'] = intval($story['modified']);
        $story['commentscount']=  $this->getStoryCommentCount($story['_id']);
    	return $story;
    }
     public function reformatCommentData($comment){

        $comment['created'] = intval($comment['created']);
        $comment['type'] = 'comment';

        return $comment;
    }
    }