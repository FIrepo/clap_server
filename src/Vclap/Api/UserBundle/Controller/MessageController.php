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

class MessageController extends FOSRestController {

    public $DB;

    public function __construct() {
        
    }
     public function reportabuseAction(Request $requestdata) {
       
       
        $this->DB = $this->getDoctrine()->getConnection();
        if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        $res=  $this->reportMessage($requestdata->get('messageId'));
       $view1 = $this->view($res, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
    }
      public function messageupdatereadAction(Request $requestdata) {
       
       
        $this->DB = $this->getDoctrine()->getConnection();
        if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        $res=  $this->updateReadAt($requestdata->get('messageId'));
       $view1 = $this->view($res, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
    }
    public function getconversationhistorycountAction(Request $requestdata) {
       
       
        $this->DB = $this->getDoctrine()->getConnection();
        if ($requestdata->get('userId') == NULL) {
           $returndata1 = array('message' => 'no userId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        $res=  $this->getConversationHistoryCount($requestdata->get('userId'));
       $view1 = $this->view($res, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
    }
    public function getconversationhistoryAction(Request $requestdata) {
       
       
        $this->DB = $this->getDoctrine()->getConnection();
        if ($requestdata->get('userId') == NULL) {
           $returndata1 = array('message' => 'no userId param recieved');
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
       $res=  $this->getConversationHistory($requestdata->get('userId'),$requestdata->get('offset'),$requestdata->get('count'));
       $view1 = $this->view($res, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
    }
    public function deletemessageAction(Request $requestdata) {
       
       
        $this->DB = $this->getDoctrine()->getConnection();
        if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
       $res=  $this->deleteMessage($requestdata->get('messageId'));
       $view1 = $this->view($res, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
    }
   public function setmessagedeleteAction(Request $requestdata) {
       
       
        $this->DB = $this->getDoctrine()->getConnection();
        if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        if ($requestdata->get('deleteType') == NULL) {
           $returndata1 = array('message' => 'no deleteType param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        if ($requestdata->get('deleteAt') == NULL) {
           $returndata1 = array('message' => 'no deleteAt param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        if ($requestdata->get('deleteAfterShownFlag') == NULL) {
           $returndata1 = array('message' => 'no deleteAfterShownFlag param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        $messageId=$requestdata->get('messageId');
       $deleteType=$requestdata->get('deleteType');
       $deleteAt=$requestdata->get('deleteAt');
       $deleteAfterShownFlag=$requestdata->get('deleteAfterShownFlag');
       $res=  $this->setMessageDelete($messageId, $deleteType, $deleteAt, $deleteAfterShownFlag);
        $view1 = $this->view($res, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
   }
    public function addnewmessageAction(Request $requestdata) {
        $this->DB = $this->getDoctrine()->getConnection();
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
        if ($content->get('fromuserid') == NULL) {
            $returndata1 = array('message' => 'fromuserid empty');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($content->get('touserid') == NULL) {
            $returndata1 = array('message' => 'touserid empty');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $fromUserId = $content->get('fromuserid');
        $touserid = $content->get('touserid');
        $message = '';
        $messageType = 'text';
        $emoticon_image_url = '';
        $picture_file_id = '';
        $picture_thumb_file_id = '';
        $voice_file_id = '';
        $video_file_id = '';
        $longitude = '0';
        $latitude = '0';
        $to_group_id = '0';
        $from_user_name = '';
        $to_group_name = '';
        $delete_type = '0';
        $delete_at = '0';
        $delete_flagged_at = '0';
        $delete_after_shown = '0';
        $message_target_type = 'user';
        if (!$content->get('body') == NULL) {
            $message = $content->get('body');
        }
        if (!$content->get('message_type') == NULL) {
            $messageType = $content->get('message_type');
        }
        if (!$content->get('emoticon_image_url') == NULL) {
            $emoticon_image_url = $content->get('emoticon_image_url');
        } else {
            $emoticon_image_url = $this->getemoticonbyidentifier($message);
        }

        if (!$content->get('picture_file_id') == NULL) {
            $picture_file_id = $content->get('picture_file_id');
        }
        if (!$content->get('picture_thumb_file_id') == NULL) {
            $picture_thumb_file_id = $content->get('picture_thumb_file_id');
        }
        if (!$content->get('voice_file_id') == NULL) {
            $voice_file_id = $content->get('voice_file_id');
        }
        if (!$content->get('video_file_id') == NULL) {
            $video_file_id = $content->get('video_file_id');
        }
        if (!$content->get('longitude') == NULL) {
            $longitude = $content->get('longitude');
        }
        if (!$content->get('latitude') == NULL) {
            $latitude = $content->get('latitude');
        }
        if (!$content->get('from_user_name') == NULL) {
            $from_user_name = $content->get('from_user_name');
        }
        if (!$content->get('to_group_name') == NULL) {
            $to_group_name = $content->get('to_group_name');
        }
        if (!$content->get('to_group_id') == NULL) {
            $to_group_id = $content->get('to_group_id');
        }
        if (!$content->get('message_target_type') == NULL) {
            $message_target_type = $content->get('message_target_type');
        }
        if (!$content->get('delete_type') == NULL) {
            $delete_type = $content->get('delete_type');
        }
        if (!$content->get('delete_at') == NULL) {
            $delete_at = $content->get('delete_at');
        }
        if (!$content->get('delete_flagged_at') == NULL) {
            $delete_flagged_at = $content->get('delete_flagged_at');
        }
        if (!$content->get('delete_after_shown') == NULL) {
            $delete_after_shown = $content->get('delete_after_shown');
        }
        if ($emoticon_image_url == NULL) {
            $emoticon_image_url = '';
        }
        $messageData = array();
        $messageData['from_user_id'] = $fromUserId;
        $messageData['to_user_id'] = $touserid;
        $messageData['body'] = $message;
        $messageData['valid'] = true;
        $messageData['modified'] = time();
        $messageData['created'] = time();
        $messageData['message_target_type'] = $message_target_type;
        $messageData['message_type'] = $messageType;
        if (!$emoticon_image_url == '') {
            $messageData['message_type'] = 'emoticon';
        }
        $messageData['emoticon_image_url'] = $emoticon_image_url;
        $messageData['picture_file_id'] = $picture_file_id;
        $messageData['picture_thumb_file_id'] = $picture_thumb_file_id;
        $messageData['voice_file_id'] = $voice_file_id;
        $messageData['video_file_id'] = $video_file_id;
        $messageData['longitude'] = $longitude;
        $messageData['latitude'] = $latitude;
        $messageData['to_group_id'] = $to_group_id;
        $messageData['delete_type'] = $delete_type;
        $messageData['from_user_name'] = $from_user_name;
        $messageData['delete_at'] = $delete_at;
        $messageData['delete_flagged_at'] = $delete_flagged_at;
        $messageData['delete_after_shown'] = $delete_after_shown;
        $messageData['to_user_name'] = '';
         $messageData['to_group_name'] = $to_group_name;
        if ($this->DB->insert('message', $messageData)) {
            $returndata1 = array('message' => 'sent success');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        } else {
            $returndata1 = array('message' => 'sent fail');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
    }

    public function getemoticonbyidentifier($identifier) {
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAssoc('select file_id from emoticon where identifier = ?', array($identifier));
        return $result['file_id'];
    }
    public function getusermessagesAction(Request $requestdata) {
       $this->DB = $this->getDoctrine()->getConnection();
       if ($requestdata->get('ownerUserId') == NULL) {
           $returndata1 = array('message' => 'no ownerUserId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        if ($requestdata->get('targetUserId') == NULL) {
           $returndata1 = array('message' => 'no targetUserId param recieved');
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
       if ($requestdata->get('offset') == NULL) {
           $returndata1 = array('message' => 'no offset param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
       $ownerUserId=$requestdata->get('ownerUserId');
       $targetUserId=$requestdata->get('targetUserId');
       $count=$requestdata->get('count');
       $offset=$requestdata->get('offset');
       $result = $this->DB->fetchAll("
            select 
                message._id,
                message.from_user_id,
                message.to_user_id,
                message.to_group_id,
                message.to_group_name,
                message.body,
                message.message_target_type,
                message.message_type,
                message.emoticon_image_url,
                message.picture_file_id,
                message.picture_thumb_file_id,
                message.voice_file_id, 
                message.video_file_id,
                message.longitude,
                message.latitude,
                message.valid,
                message.from_user_name,
                message.to_user_name,
                message.created as created,
                message.modified,
                message.delete_type,
                message.delete_at,
                message.delete_flagged_at,
                message.delete_after_shown,
                message.read_at,
                message.comment_count,
                user.avatar_thumb_file_id as avatar_thumb_file_id
            from message
                left join user on user._id = message.from_user_id
                where 
                    message_target_type = ? 
                    and from_user_id = ?
                    and to_user_id = ?
                
            union
            
            select
                message._id,
                message.from_user_id,
                message.to_user_id,
                message.to_group_id,
                message.to_group_name,
                message.body,
                message.message_target_type,
                message.message_type,
                message.emoticon_image_url,
                message.picture_file_id,
                message.picture_thumb_file_id,
                message.voice_file_id, 
                message.video_file_id,
                message.longitude,
                message.latitude,
                message.valid,
                message.from_user_name,
                message.to_user_name,
                message.created as created,
                message.modified,
                message.delete_type,
                message.delete_at,
                message.delete_flagged_at,
                message.delete_after_shown,
                message.read_at,
                message.comment_count,
                user.avatar_thumb_file_id as avatar_thumb_file_id
            from message 
                left join user on user._id = message.from_user_id
                where 
                    message_target_type = ? 
                    and to_user_id = ?
                    and from_user_id = ?
            order by created desc
            limit {$count}
            offset {$offset}",
            array(
                'user',
                $ownerUserId,
                $targetUserId,
                'user',
                $ownerUserId,
                $targetUserId));
        $formatedMessages = array();
        
        foreach($result as $message){
            $message = $this->reformatMessageData($message);
            $formatedMessages[] = $message;
        }
        
        $res= $this->formatResult($formatedMessages,$offset);
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    
     public function addcommentAction(Request $requestdata) {
         if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        if ($requestdata->get('userId') == NULL) {
           $returndata1 = array('message' => 'no userId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
        if ($requestdata->get('comment') == NULL) {
           $returndata1 = array('message' => 'no comment param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
       $res= $this->addNewComment($requestdata->get('messageId'),$requestdata->get('userId'),$requestdata->get('comment'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function getcommentscountAction(Request $requestdata) {
        if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
       $res= $this->getCommentCount($requestdata->get('messageId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
     public function getcommentsAction(Request $requestdata) {
       
       
        if ($requestdata->get('messageId') == NULL) {
           $returndata1 = array('message' => 'no messageId param recieved');
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
        if ($requestdata->get('offset') == NULL) {
           $returndata1 = array('message' => 'no offset param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
       $res= $this->getComments($requestdata->get('messageId'),$requestdata->get('count'),$requestdata->get('offset'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function getgroupmessagesAction(Request $requestdata) {
       $this->DB = $this->getDoctrine()->getConnection();
       
        if ($requestdata->get('targetGroupId') == NULL) {
           $returndata1 = array('message' => 'no targetGroupId param recieved');
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
       if ($requestdata->get('offset') == NULL) {
           $returndata1 = array('message' => 'no offset param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
     
       $targetGroupId=$requestdata->get('targetGroupId');
       $count=$requestdata->get('count');
       $offset=$requestdata->get('offset');
         $result = $this->DB->fetchAll("
            select 
                message._id,
                message.from_user_id,
                message.to_user_id,
                message.to_group_id,
                message.to_group_name,
                message.body,
                message.message_target_type,
                message.message_type,
                message.emoticon_image_url,
                message.picture_file_id,
                message.picture_thumb_file_id,
                message.voice_file_id, 
                message.video_file_id,
                message.longitude,
                message.latitude,
                message.valid,
                message.from_user_name,
                message.to_user_name,
                message.created as created,
                message.modified,
                message.delete_type,
                message.delete_at,
                message.delete_flagged_at,
                message.delete_after_shown,
                message.read_at,
                message.comment_count,
                user.avatar_thumb_file_id as avatar_thumb_file_id
            from message 
                left join user on user._id = message.from_user_id
                where 
                    message_target_type = ? 
                    and to_group_id = ?
                order by created desc
                limit {$count}
                offset {$offset}
            ",
            array(
                'group',
                $targetGroupId));

        $formatedMessages = array();
        
        foreach($result as $message){
            $message = $this->reformatMessageData($message);
            $formatedMessages[] = $message;
        }

        $res= $this->formatResult($formatedMessages,$offset);
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    
    
     public function formatResult($result,$offset = 0){
    
        $newResultRows = array();
        
        foreach($result as $row){
            
            $newResultRows[] = array(
                'id' => $row['_id'],
                'key' =>  $row['_id'],
                'value' => $row
            );
                
        }
        
        return array(
            'total_rows' => count($result),
            'offset' => $offset,
            'rows'  => $newResultRows
        );
    }
      public function addNewComment($messageId,$userId,$comment){
        $this->DB = $this->getDoctrine()->getConnection();
        $userData=$this->findUserById($userId);
        
        $commentData = array();
        $commentData['message_id'] = $messageId;
        $commentData['user_id'] = $userId;
        $commentData['comment'] = $comment;
        $commentData['user_name'] = $userData['name'];
        $commentData['created'] = time();
        
        if($this->DB->insert('media_comment',$commentData)){
            
            $result = $this->DB->executeupdate(
                'update message set 
                    comment_count = comment_count + 1
                    where _id = ?',
                array(
                    $messageId));
            
            return array(
                'message' => 'comment added',
                
            );
            
        }else{
            return null;
        }
        
        
    }
      public function reformatMessageData($message){

        $message['created'] = intval($message['created']);
        $message['modified'] = intval($message['modified']);
        $message['type'] = 'message';

        return $message;
    }
     public function findUserById($id,$deletePersonalInfo = true)
    {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where _id = ?',array($id));
        $contacts = $this->DB->fetchAll('select contact_user_id from user_contact where user_id = ?',array($id));
        $groups = $this->DB->fetchAll('select group_id from user_group where user_id = ?',array($id));
        
        $contactIds = array();      
        if(is_array($contacts)){
            foreach($contacts as $row){
                $contactIds[] = $row['contact_user_id'];
            }
        }
        
        $groupIds = array();    
        if(is_array($groups)){
            foreach($groups as $row){
                $groupIds[] = $row['group_id'];
            }
        }
                
        $user['contacts'] = $contactIds;
        $user['favorite_groups'] = $groupIds;
        
        $user = $this->reformatUserData($user,$deletePersonalInfo);
                
        return $user;
        
    }
    public function getAvatarFileId($user_id){
        $user = $this->findUserById($user_id);
        if(!isset($user['_id'])){
        return array('rows'=>array(array('key'=>"avatar",'value'=>"")));}
        else{
            return array('rows'=>array(array('key'=>"avatar",'value'=>$user['avatar_file_id']),array('key'=>"avatarthumb",'value'=>$user['avatar_thumb_file_id'])));
        }
    }
     public function getavatarAction(Request $requestdata) {
        if ($requestdata->get('user_id') == NULL) {
           $returndata1 = array('message' => 'no user_id param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
       }
       $res= $this->getAvatarFileId($requestdata->get('user_id'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
        public function getComments($messageId,$count,$offset){
         $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAll("
            select media_comment.*,user.avatar_thumb_file_id from media_comment 
            left join user on user._id = media_comment.user_id
                where 
                    message_id = ? 
                order by created desc
                limit {$count}
                offset {$offset}
            ",
            array($messageId));

        $formatedComments = array();
        
        foreach($result as $comment){
            $comment = $this->reformatCommentData($comment);
            $formatedComments[] = $comment;
        }

        return $this->formatResult($formatedComments,$offset);
        
    }
    public function reformatCommentData($comment){

        $comment['created'] = intval($comment['created']);
        $comment['type'] = 'comment';

        return $comment;
    }
     public function reformatUserData($user,$deletePersonalInfo = true){

        if($deletePersonalInfo){
            unset($user['password']);
            unset($user['email']);
            unset($user['token']);
        }

        if(isset($user['birthday']))
            $user['birthday'] = intval($user['birthday']);

        if(isset($user['last_login']))
            $user['last_login'] = intval($user['last_login']);

        if(isset($user['max_contact_count']))
            $user['max_contact_count'] = intval($user['max_contact_count']);

        if(isset($user['max_favorite_count']))
            $user['max_favorite_count'] = intval($user['max_favorite_count']);

        if(isset($user['created']))
            $user['created'] = intval($user['created']);

        if(isset($user['modified']))
            $user['modified'] = intval($user['modified']);

        $user['type'] = 'user';
        $user['_rev'] = 'tmprev';
        
        return $user;
    }
    public function reformatGroupData($gourp){

        if(isset($gourp['created']))
            $gourp['created'] = intval($gourp['created']);
        
        if(isset($gourp['modified']))
            $gourp['modified'] = intval($gourp['modified']);
        
        $gourp['type'] = 'group';

        return $gourp;
    }
    public function setMessageDelete($messageId,$deleteType,$deleteAt,$deleteAfterShownFlag = 0){
         $this->DB = $this->getDoctrine()->getConnection();
        $now = time();
        
        $result = $this->DB->executeupdate(
                'update message set 
                    delete_at = ?,
                    delete_flagged_at = ?,
                    delete_after_shown = ?,
                    delete_type = ?
                    WHERE _id = ?',
                array(
                    $deleteAt,
                    $now,
                    $deleteAfterShownFlag,
                    $deleteType,
                    $messageId));
        
         return array(
            'message' => 'messsage delete updated'
        );;

    }
    
    public function deleteMessage($messageId){
        $this->DB = $this->getDoctrine()->getConnection();
        $this->DB->delete('message', array('_id' => $messageId));
        
       return array(
            'message' => 'message deleted'
        );

    }
    
     public function getConversationHistory($userId,$offset = 0,$count=10){
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAll("
            select * from message where _id in 
            (
                select max(_id) from message where from_user_id = ? group by to_user_id
                union
                select max(_id) from message where from_user_id = ? group by to_group_id
            )
            order by created desc
            limit {$count}
            offset {$offset}
            ",array($userId,$userId));
            
        return $result;
        
    }
    public function getCommentCount($messageId){
        $this->DB = $this->getDoctrine()->getConnection();
        $count = $this->DB->fetchAssoc('select count(*) as count from media_comment where message_id = ?',array($messageId));
        return array('rows'=>array(array('key'=>"commentscount",'value'=>$count['count'])));
    }
    
        public function getConversationHistoryCount($userId){
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchColumn("
            select count(*) as count from message where _id in 
            (
                select max(_id) from message where from_user_id = ? group by to_user_id
                union
                select max(_id) from message where from_user_id = ? group by to_group_id
            )
            ",array($userId,$userId));
            
        return $result;
        
    }
        
    public function reportMessage($messageId){
         $this->DB = $this->getDoctrine()->getConnection();
    	$result = $this->DB->executeupdate(
    			'update message
                    set report_count = report_count + 1
                    WHERE _id = ?',
    			array($messageId));
         return $result;
    }
        public function updateReadAt($messageId){
         $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->executeupdate(
                'update message set 
                    read_at = ?
                    WHERE _id = ?',
                array(
                    time(),
                    $messageId));
        
        return $result;
        
    }
}
