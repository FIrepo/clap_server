<?php

namespace Vclap\Api\UserBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends FOSRestController {

    public $DB;

    public function __construct() {
        
    }
    public function getActivitySummary($user_id)
    {
        $this->DB = $this->getDoctrine()->getConnection();
        $myNotifications = $this->DB->fetchAll('
            select 
                notification.*,
                user.avatar_thumb_file_id,
                user.name
            from notification  
                left join user on notification.from_user_id = user._id
            where user_id = ?
            order by modified desc',array($user_id));
                
        $directMessages = array();
        $groupMessages = array();
        
        foreach($myNotifications as $row){
            
            if($row['target_type'] == ACTIVITY_SUMMARY_DIRECT_MESSAGE)
                $directMessages[] = $row;
            
            if($row['target_type'] == ACTIVITY_SUMMARY_GROUP_MESSAGE)
                $groupMessages[] = $row;
            
            
        }
        
        $responseData = array(
            'total_rows' => count($myNotifications),
            'offset' => 0,
            'rows' => array(
                array(
                    'id' => $user_id,
                    'key' => $user_id,
                    'value' => array(
                        
                        '_id' => $user_id,
                        '_rev'  => 'tmprev',
                        'type'  => 'activity_summary' ,
                        'user_id'  => $user_id
                    )
                )
            )
        );
        
        if(count($directMessages) > 0){
            
            $responseData['rows'][0]['value']['recent_activity'][ACTIVITY_SUMMARY_DIRECT_MESSAGE] = array(
                'name' => 'Chat activity',
                'target_type' => 'user',
                'notifications' => array()
            );
            
            foreach($directMessages as $row){
                
                $responseData['rows'][0]['value']['recent_activity'][ACTIVITY_SUMMARY_DIRECT_MESSAGE]['notifications'][] = array(
                    
                    'target_id' => $row['from_user_id'],
                    'count' => $row['count'],
                    'messages' => array(array(
                        'from_user_id' => $row['from_user_id'],
                        'avatar_thumb_file_id' => $row['avatar_thumb_file_id'],
                        'message' => $row['message'],
                        'user_image_url' => $row['user_image_url'],
                        'modified' => intval($row['modified'])
                    )),
                    'lastupdate' => intval($row['modified'])
                                    
                );
            }
        }
        
        if(count($groupMessages) > 0){
            
            $responseData['rows'][0]['value']['recent_activity'][ACTIVITY_SUMMARY_GROUP_MESSAGE] = array(
                'name' => 'Groups activity',
                'target_type' => 'group',
                'notifications' => array()
            );
            
            foreach($groupMessages as $row){
                
                $responseData['rows'][0]['value']['recent_activity'][ACTIVITY_SUMMARY_GROUP_MESSAGE]['notifications'][] = array(
                    
                    'target_id' => $row['to_group_id'],
                    'count' => $row['count'],
                    'messages' => array(array(
                        'from_user_id' => $row['from_user_id'],
                        'avatar_thumb_file_id' => $row['avatar_thumb_file_id'],
                        'message' => $row['message'],
                        'user_image_url' => $row['user_image_url'],
                        'modified' => intval($row['modified'])
                    )),
                    'lastupdate' => intval($row['modified'])
                                    
                );
            }
        }

        return $responseData;
        
    }

    public function unregistToken($userId){
     $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->executeupdate(
                'update user set 
                    token = \'\',
                    modified = ?
                    WHERE _id = ?', 
                array(
                    time(),
                    $userId));

        return "OK";
        
    }
    public function checkEmailIsUnique($email) {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where email = ?', array($email));
        return $user;
    }

    public function checkUserNameIsUnique($name) {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where name = ?', array($name));
        return $user;
    }

    public function formatResult($result, $offset = 0) {

        $newResultRows = array();

        foreach ($result as $row) {

            $newResultRows[] = array(
                'id' => $row['_id'],
                'key' => $row['_id'],
                'value' => $row
            );
        }

        return array(
            'total_rows' => count($result),
            'offset' => $offset,
            'rows' => $newResultRows
        );
    }

    public function reformatUserData($user, $deletePersonalInfo = true) {

        if ($deletePersonalInfo) {
            unset($user['password']);
            unset($user['email']);
            unset($user['token']);
        }

        if (isset($user['birthday'])) {
            $user['birthday'] = intval($user['birthday']);
        }
        if (isset($user['last_login'])) {
            $user['last_login'] = intval($user['last_login']);
        }
        if (isset($user['max_contact_count'])) {
            $user['max_contact_count'] = intval($user['max_contact_count']);
        }
        if (isset($user['max_favorite_count'])) {
            $user['max_favorite_count'] = intval($user['max_favorite_count']);
        }
        if (isset($user['created'])) {
            $user['created'] = intval($user['created']);
        }
        if (isset($user['modified'])) {
            $user['modified'] = intval($user['modified']);
        }
        $user['type'] = 'user';
        $user['_rev'] = 'tmprev';
        $user['message'] = 'success';
        return $user;
    }
    public function doAuth($email,$password)
    {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where email = ? and password = ?',array($email,$password));
        return $user;

    }
    public function updatetoken($user){
        $this->DB = $this->getDoctrine()->getConnection();
        $token = Utility::randString(40, 40);
        $this->DB->executeupdate('update user set token = ?,token_timestamp = ?,last_login = ? WHERE _id = ?', 
            array($token,time(),time(),$user['_id']));
        $newUser = $this->findUserById($user['_id'],false);
        return $newUser;
    }

    public function searchUser($name,$agefrom,$ageTo,$gender){
    $this->DB = $this->getDoctrine()->getConnection();
        $query = "select * from user where 1 = 1 ";
        $yearIntervalInSec = 60 * 60 * 24 * 365;
        
        //calc birthday range ( can be better )
        $toDate = time() - $yearIntervalInSec * $agefrom;
        
        if(!empty($name)){
            $query .= " and LOWER(name) like :name "; 
        }
        
        if(!empty($gender)){
            $query .= " and gender = :gender "; 
        }
        
        if($agefrom != 0){
            $query .= " and birthday < :birthdayTo "; 
        }
        
        if($ageTo != 0){
            $query .= " and birthday > :birthdayfrom "; 
        }
        
        $stmt = $this->DB->prepare($query);

        if(!empty($name)){
            $name = strtolower($name);
            $stmt->bindValue("name", "%{$name}%");
        }
        
        if(!empty($gender)){
            $stmt->bindValue("gender", $gender);
        }
        
        if($agefrom != 0){
            $toDate = time() - $yearIntervalInSec * $agefrom;
            $stmt->bindValue("birthdayTo", $toDate);
        }
        
        if($ageTo != 0){
            $fromDate = time() - $yearIntervalInSec * $ageTo;
            $stmt->bindValue("birthdayfrom", $fromDate);
        }
        
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        $formatedUsers = array();
        
        foreach($result as $row){
            $formatedUsers[] = $this->reformatUserData($row);
        }
        
        return $formatedUsers;
    }
    public function searchUserByGender($gender) {
         $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAll('select * from user where gender = ?', array($gender));
        return $this->formatResult($result);
    }
 public function findUserByToken($token)
    {
       $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where token = ?',array($token));
        return $user;
    }
    public function searchUserByAge($agefrom, $ageTo) {
    $this->DB = $this->getDoctrine()->getConnection();
        $yearIntervalInSec = 60 * 60 * 24 * 365;

        //calc birthday range ( can be better )
        $fromDate = time() - $yearIntervalInSec * $ageTo;
        $toDate = time() - $yearIntervalInSec * $agefrom;

        $result = $this->DB->fetchAll('select * from user where birthday > ? and birthday < ? ', array($fromDate, $toDate));

        return $this->formatResult($result);
    }

    public function searchUserByName($name) {
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAll('select * from user where name like ?', array("%{$name}%"));
        return $this->formatResult($result);
    }

    public function findUserByEmail($email) {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where email = ?', array($email));
        $user = $this->reformatUserData($user);
        return $user;
    }

    public function findUserByName($name) {
        $this->DB = $this->getDoctrine()->getConnection();
        $user = $this->DB->fetchAssoc('select * from user where LOWER(name) = LOWER(?)', array($name));
        $user = $this->reformatUserData($user);
        return $user;
    }

    public function finduserbyid($id, $del) {
        $deletePersonalInfo = $del;
        $this->DB = $this->getDoctrine()->getConnection();
        $returndata = array('message' => 'Unknown');
        $user = $this->DB->fetchAssoc('select * from user where _id = ?', array($id));
        $contacts = $this->DB->fetchAll('select contact_user_id from user_contact where user_id = ?', array($id));
        $groups = $this->DB->fetchAll('select group_id from user_group where user_id = ?', array($id));

        $contactIds = array();
        if (is_array($contacts)) {
            foreach ($contacts as $row) {
                $contactIds[] = $row['contact_user_id'];
            }
        }

        $groupIds = array();
        if (is_array($groups)) {
            foreach ($groups as $row) {
                $groupIds[] = $row['group_id'];
            }
        }

        $user['contacts'] = $contactIds;
        $user['favorite_groups'] = $groupIds;

        $user = $this->reformatUserData($user, $deletePersonalInfo);
        return $user;
    }
    public function unregistertokenAction(Request $requestdata) {
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
    if ($content->get('userid') == NULL) {
            $returndata = array('message' => 'No userid param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $this->unregistToken($content->get('userid'));
         $returndata = array('message' => 'token unregistered');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
    }
    public function getuseractionsAction(Request $requestdata) {
        $returndata = array('message' => 'Unknown');

    if ($requestdata->get('userid') == NULL) {
            $returndata = array('message' => 'No userid param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $useractions=$this->getActivitySummary($requestdata->get('userid'));
        $view = $this->view($useractions, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
public function loginAction(Request $requestdata) {
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
    if ($content->get('email') == NULL) {
            $returndata = array('message' => 'No email param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        if ($content->get('password') == NULL) {
            $returndata = array('message' => 'No password param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        
        $user=$this->doAuth($content->get('email'), $content->get('password'));
         if (empty($user['_id'])) {
             $returndata = array('message' => 'login failed');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
         }
         $newuser=  $this->updatetoken($user);
         $view = $this->view($newuser, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
}

    public function finduserbyemailAction(Request $requestdata) {
        if ($requestdata->get('email') == NULL) {
            $returndata = array('message' => 'No email param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $user = $this->findUserByEmail($requestdata->get('email'));
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
 public function finduserbytokenAction(Request $requestdata) {
        if ($requestdata->get('token') == NULL) {
            $returndata = array('message' => 'No token param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $user = $this->findUserByToken($requestdata->get('token'));
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function finduserbynameAction(Request $requestdata) {
        if ($requestdata->get('name') == NULL) {
            $returndata = array('message' => 'No name param Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $user = $this->findUserByName($requestdata->get('name'));
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function finduserbyidAction(Request $requestdata) {
        if ($requestdata->get('id') == NULL) {
            $returndata = array('message' => 'no userid param recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $user = $this->finduserbyid($requestdata->get('id'), true);
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function searchuserbynameAction(Request $requestdata) {
        if ($requestdata->get('name') == NULL) {
            $returndata = array('message' => 'no name param recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $user = $this->searchUserByName($requestdata->get('name'));
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    
public function searchuserAction(Request $requestdata) {
    $name = "";
    $agefrom = 0;
    $ageTo = 0;
    $gender = "";
        if (!$requestdata->get('name') == NULL) {
            $name=$requestdata->get('name');
        }
         if (!$requestdata->get('agefrom') == NULL) {
            $agefrom=$requestdata->get('agefrom');
        }
         if (!$requestdata->get('ageto') == NULL) {
            $ageTo=$requestdata->get('ageto');
        }
         if (!$requestdata->get('gender') == NULL) {
            $gender=$requestdata->get('gender');
        }
        $user = $this->searchUser($name,$agefrom,$ageTo,$gender);
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function searchuserbyageAction(Request $requestdata) {
        if ($requestdata->get('agefrom') == NULL) {
            $returndata = array('message' => 'no agefrom param recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
         if ($requestdata->get('ageto') == NULL) {
            $returndata = array('message' => 'no ageto param recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $user = $this->searchUserByAge($requestdata->get('agefrom'),$requestdata->get('ageto'));
        $view = $this->view($user, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
        public function createuserAction(Request $requestdata) {
        $returndata = array('message' => 'Unknown');
        $requestcontent = $requestdata->getContent();
        if (empty($requestcontent)) {
            $returndata = array('message' => 'No params Recieved');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $content = new ArrayCollection(json_decode($requestcontent, true));
        if (is_array($this->checkEmailIsUnique($content->get('email')))) {
            $returndata = array('message' => 'email Already in use');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
        $this->DB = $this->getDoctrine()->getConnection();
        $now = time();
        $valueArray = array();
        $valueArray['name'] = $content->get('userName');
        $valueArray['email'] = $content->get('email');
        $valueArray['password'] = $content->get('password');
        $valueArray['online_status'] = "online";
        $valueArray['max_contact_count'] = 100;
        $valueArray['max_favorite_count'] = 10;
        $valueArray['about'] = "";
        $valueArray['token'] = Utility::randString(40, 40);
        $valueArray['token_timestamp'] = $now;
        $valueArray['last_login'] = $now;
        $valueArray['gender'] = '';
        $valueArray['avatar_file_id'] = '';
        $valueArray['avatar_thumb_file_id'] = '';
        $valueArray['ios_push_token'] = $content->get('userName') . $now;
        $valueArray['android_push_token'] = $content->get('userName') . $now;
        $valueArray['birthday'] = 0;
        $valueArray['created'] = $now;
        $valueArray['modified'] = $now;
        if ($this->DB->insert('user', $valueArray)) {
            $insertid = $this->DB->lastInsertId("_id");
            $returndata = array('message' => 'Success', 'insertid' => $insertid);
        } else {
            $returndata = array('message' => 'Create User Failed');
        }
        $view = $this->view($returndata, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function updateuserAction(Request $requestdata) {
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
        if ($content->get('userid') == NULL) {
            $returndata1 = array('message' => 'userid empty');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $secure = true;
        $originalData = $this->finduserbyid($content->get('userid'), false);
        $now = time();

        if (!isset($decodearray['name'])) {
            $decodearray['name'] = $originalData['name'];
        }
        if (!$secure) {

            if (!isset($decodearray['email'])) {
                $decodearray['email'] = $originalData['email'];
            }
            if (!isset($decodearray['password'])) {
                $decodearray['password'] = $originalData['password'];
            }
        }

        if (!isset($decodearray['about'])) {
            $decodearray['about'] = $originalData['about'];
        }
        if (!isset($decodearray['online_status'])) {
            $decodearray['online_status'] = $originalData['online_status'];
        }
        if (!isset($decodearray['birthday'])) {
            $decodearray['birthday'] = $originalData['birthday'];
        }
        if (!isset($decodearray['gender'])) {
            $decodearray['gender'] = $originalData['gender'];
        }
        if (!isset($decodearray['avatar_file_id'])) {
            $decodearray['avatar_file_id'] = $originalData['avatar_file_id'];
        }
        if (!isset($decodearray['avatar_thumb_file_id'])) {
            $decodearray['avatar_thumb_file_id'] = $originalData['avatar_thumb_file_id'];
        }
        if (!isset($decodearray['ios_push_token'])) {
            $decodearray['ios_push_token'] = $originalData['ios_push_token'];
        }
        if (!isset($decodearray['android_push_token'])) {
            $decodearray['android_push_token'] = $originalData['android_push_token'];
        }
        if (!isset($decodearray['max_contact_count'])) {
            $decodearray['max_contact_count'] = $originalData['max_contact_count'];
        }
        if (!isset($decodearray['max_favorite_count'])) {
            $decodearray['max_favorite_count'] = $originalData['max_favorite_count'];
        }
        if (!isset($decodearray['token'])) {
            $decodearray['token'] = $originalData['token'];
        }
        if ($secure) {

            $result = $this->DB->executeupdate(
                    'update user set 
                    name = ?,
                    about = ?,
                    online_status = ?,
                    birthday = ?,
                    gender = ?,
                    avatar_file_id = ?,
                    avatar_thumb_file_id = ?,
                    ios_push_token = ?,
                    android_push_token = ?,
                    max_contact_count = ?,
                    max_favorite_count = ?,
                    token = ?,
                    modified = ?
                    WHERE _id = ?', array(
                $decodearray['name'],
                $decodearray['about'],
                $decodearray['online_status'],
                $decodearray['birthday'],
                $decodearray['gender'],
                $decodearray['avatar_file_id'],
                $decodearray['avatar_thumb_file_id'],
                $decodearray['ios_push_token'],
                $decodearray['android_push_token'],
                $decodearray['max_contact_count'],
                $decodearray['max_favorite_count'],
                $decodearray['token'],
                $now,
                $content->get('userid')));
        } else {

            $result = $this->DB->executeupdate(
                    'update user set 
                    name = ?,
                    email = ?,
                    password = ?,
                    about = ?,
                    online_status = ?,
                    birthday = ?,
                    gender = ?,
                    avatar_file_id = ?,
                    avatar_thumb_file_id = ?,
                    ios_push_token = ?,
                    android_push_token = ?,
                    max_contact_count = ?,
                    max_favorite_count = ?,
                    token = ?,
                    modified = ?
                    WHERE _id = ?', array(
                $decodearray['name'],
                $decodearray['email'],
                $decodearray['password'],
                $decodearray['about'],
                $decodearray['online_status'],
                $decodearray['birthday'],
                $decodearray['gender'],
                $decodearray['avatar_file_id'],
                $decodearray['avatar_thumb_file_id'],
                $decodearray['ios_push_token'],
                $decodearray['android_push_token'],
                $decodearray['max_contact_count'],
                $decodearray['max_favorite_count'],
                $decodearray['token'],
                $now,
                $content->get('userid')));
        }

        if ($result) {
            $returndata = array('message' => 'update success');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        } else {
            $returndata = array('message' => 'update fail');
            $view = $this->view($returndata, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view);
        }
    }
    
}
