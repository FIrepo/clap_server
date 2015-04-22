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

class GroupController extends FOSRestController {

    public $DB;

    public function __construct() {
        
    }
     public function subscribegroupAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
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
        
        $res = $this->subscribeGroup($requestdata->get('groupId'),$requestdata->get('userId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
         public function unsubscribegroupAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
         if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
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
        
        $res = $this->unSubscribeGroup($requestdata->get('groupId'),$requestdata->get('userId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
     public function getgroupsbyuseridAction(Request $requestdata){
        $this->DB = $this->getDoctrine()->getConnection();
          if ($requestdata->get('userId') == NULL) {
            $returndata1 = array('message' => 'no userId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        
        $res = $this->getGroupsByUserId($requestdata->get('userId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function getalluserscountbygroupidAction(Request $requestdata) {
        if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        
        $res = $this->getAllUsersCountByGroupId($requestdata->get('groupId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function getallusersbygroupidAction(Request $requestdata) {
        if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
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
     
        $res = $this->getAllUsersByGroupId($requestdata->get('groupId'),$requestdata->get('offset'),$requestdata->get('count'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function creategroupcategoryAction(Request $requestdata) {
        if ($requestdata->get('title') == NULL) {
            $returndata1 = array('message' => 'no title param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->createGroupCategory($requestdata->get('title'), '');
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
public function getallgroupcountAction(Request $requestdata) {
     $res = $this->findGroupCount();
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
}

public function getallgroupcategorycountAction(Request $requestdata) {
     $res = $this->findGroupCategoryCount();
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
}
public function getallgroupcategoriesAction(Request $requestdata) {
     $res = $this->findAllGroupCategory();
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
}

public function getallgroupcategoriesbypageAction(Request $requestdata) {
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
     $res = $this->findAllGroupCategoryWithPaging($requestdata->get('offset'),$requestdata->get('offset'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
}
    public function findgroupbyidAction(Request $requestdata) {
        if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->findGroupById($requestdata->get('groupId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
 public function findallgroupsAction(Request $requestdata) {
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
      $res = $this->findAllGroups($requestdata->get('offset'),$requestdata->get('count'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    
        }
    public function findgroupbycategoryidAction(Request $requestdata) {
        if ($requestdata->get('categoryId') == NULL) {
            $returndata1 = array('message' => 'no categoryId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->findGroupByCategoryId($requestdata->get('categoryId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
 public function findcategorybycategoryidAction(Request $requestdata) {
        if ($requestdata->get('categoryId') == NULL) {
            $returndata1 = array('message' => 'no categoryId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->findGroupCategoryById($requestdata->get('categoryId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }
    public function findgroupbynameAction(Request $requestdata) {
        if ($requestdata->get('groupname') == NULL) {
            $returndata1 = array('message' => 'no groupname param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->findGroupByName($requestdata->get('groupname'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function updategroupAction(Request $requestdata) {
        if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('name') == NULL) {
            $returndata1 = array('message' => 'no name param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('ownerId') == NULL) {
            $returndata1 = array('message' => 'no ownerId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('categoryId') == NULL) {
            $returndata1 = array('message' => 'no categoryId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('description') == NULL) {
            $returndata1 = array('message' => 'no description param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('password') == NULL) {
            $returndata1 = array('message' => 'no password param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('avatarURL') == NULL) {
            $returndata1 = array('message' => 'no avatarURL param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('thumbURL') == NULL) {
            $returndata1 = array('message' => 'no thumbURL param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $groupId = $requestdata->get('groupId');
        $name = $requestdata->get('name');
        $ownerId = $requestdata->get('ownerId');
        $categoryId = $requestdata->get('categoryId');
        $description = $requestdata->get('description');
        $password = $requestdata->get('password');
        $avatarURL = $requestdata->get('avatarURL');
        $thumbURL = $requestdata->get('thumbURL');
        $res = $this->updateGroup($groupId, $name, $ownerId, $categoryId, $description, $password, $avatarURL, $thumbURL);
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function creategroupAction(Request $requestdata) {
        if ($requestdata->get('name') == NULL) {
            $returndata1 = array('message' => 'no name param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('ownerId') == NULL) {
            $returndata1 = array('message' => 'no ownerId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('categoryId') == NULL) {
            $returndata1 = array('message' => 'no categoryId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('description') == NULL) {
            $returndata1 = array('message' => 'no description param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('password') == NULL) {
            $returndata1 = array('message' => 'no password param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }


        $name = $requestdata->get('name');
        $ownerId = $requestdata->get('ownerId');
        $categoryId = $requestdata->get('categoryId');
        $description = $requestdata->get('description');
        $password = $requestdata->get('password');
        $avatarURL = '';
        $thumbURL = '';
        $res = $this->createGroup($name, $ownerId, $categoryId, $description, $password, $avatarURL, $thumbURL);
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
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

    public function deletegroupcategoryAction(Request $requestdata) {
        if ($requestdata->get('id') == NULL) {
            $returndata1 = array('message' => 'no id param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->deleteGroupCategory($requestdata->get('id'), '');
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function deletegroupAction(Request $requestdata) {
        if ($requestdata->get('groupId') == NULL) {
            $returndata1 = array('message' => 'no groupId param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->deleteGroup($requestdata->get('groupId'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function updategroupcategoryAction(Request $requestdata) {
        if ($requestdata->get('title') == NULL) {
            $returndata1 = array('message' => 'no title param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('id') == NULL) {
            $returndata1 = array('message' => 'no id param recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        if ($requestdata->get('picture') == NULL) {
            $returndata1 = array('message' => 'no picture recieved');
            $view1 = $this->view($returndata1, 200)
                    ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                    ->setTemplateVar('data');
            return $this->handleView($view1);
        }
        $res = $this->updateGroupCategory($requestdata->get('id'), $requestdata->get('title'), $requestdata->get('picture'));
        $view = $this->view($res, 200)
                ->setTemplate("VclapApiUserBundle:Default:index.html.twig")
                ->setTemplateVar('data');
        return $this->handleView($view);
    }

    public function createGroupCategory($title, $picture) {

        $this->DB = $this->getDoctrine()->getConnection();
        $now = time();
        $valueArray = array();
        $valueArray['title'] = $title;
        $valueArray['avatar_file_id'] = $picture;
        $valueArray['created'] = $now;
        $valueArray['modified'] = $now;

        if ($this->DB->insert('group_category', $valueArray)) {
            return array(
                'message' => 'group category created'
            );
        } else {
            return null;
        }
    }

    public function updateGroupCategory($id, $title, $picture) {
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->executeupdate(
                'update group_category set 
                    title = ?,
                    avatar_file_id = ?,
                    modified = ?
                    WHERE _id = ?', array(
            $title,
            $picture,
            time(),
            $id));
        return array(
            'message' => 'group category updated'
        );
    }
public function findAllGroupCategory(){
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAll('select * from group_category');
        return $this->formatResult($result);

    }
    
    
        public function getAllUsersByGroupId($groupId,$offset = 0,$count = 30){
            $this->DB = $this->getDoctrine()->getConnection();
        $query = "
            select * from user where _id in 
                (select user_id from user_group where group_id = ?) 
                limit {$count} offset {$offset}";

        $users = $this->DB->fetchAll($query,array($groupId));
        
        
                      
        return $users;
    }
    
 public function findAllGroupCategoryWithPaging($offset = 0,$count){
        $this->DB = $this->getDoctrine()->getConnection();
        $query = "select * from group_category order by _id ";
        
        if($count != 0){
            $query .= " limit {$count} offset {$offset} ";
        }
        
        
        $result = $this->DB->fetchAll($query);
        
        return $this->formatResult($result);
        
    }
    public function deleteGroupCategory($id) {
        $this->DB = $this->getDoctrine()->getConnection();
        $this->DB->delete('group_category', array('_id' => $id));

        return array(
            'message' => 'group category deleted'
        );
    }

    public function deleteGroup($groupId) {
        $this->DB = $this->getDoctrine()->getConnection();
        $this->DB->delete('`group`', array('_id' => $groupId));

        return array(
            'message' => 'group deleted'
        );
    }
 public function findGroupCategoryCount()
    {
     $this->DB = $this->getDoctrine()->getConnection();
        $query = "select count(*) as count from group_category";
        $result = $this->DB->fetchColumn($query);
        return $result;
    }
    public function findGroupByName($name) {
        $this->DB = $this->getDoctrine()->getConnection();
        $name = strtolower($name);
        $group = $this->DB->fetchAssoc('select * from `group` where LOWER(name) = ?', array($name));

        if (isset($group['_id']))
            $group = $this->reformatGroupData($group);

        return $this->formatRow($group);
    }

    public function findGroupByCategoryId($categoryId) {
        $this->DB = $this->getDoctrine()->getConnection();
        $result = $this->DB->fetchAll('select * from `group` where category_id = ?', array($categoryId));


        $formatedGroups = array();
        foreach ($result as $group) {
            $group = $this->reformatGroupData($group);
            $formatedGroups[] = $group;
        }

        return $this->formatResult($formatedGroups);
    }

    public function findGroupById($id) {
        $this->DB = $this->getDoctrine()->getConnection();
        $group = $this->DB->fetchAssoc('select * from `group` where _id = ?', array($id));
        $group = $this->reformatGroupData($group);

        // find group cateogory
        $groupCategory = $this->DB->fetchAssoc('select * from group_category where _id = ?', array($group['category_id']));
        $group['category_name'] = $groupCategory['title'];

        return $this->formatRow($group);
    }
 public function findGroupCount()
    {
     $this->DB = $this->getDoctrine()->getConnection();
        
        $query = "select count(*) as count from `group`";
        
        $result = $this->DB->fetchColumn($query);

        return $result;
    }
    public function updateGroup($groupId, $name, $ownerId, $categoryId, $description, $password, $avatarURL, $thumbURL) {
        $this->DB = $this->getDoctrine()->getConnection();
        $now = time();

        $result = $this->DB->executeupdate(
                'update `group` set 
                    name = ?,
                    user_id = ?,
                    description = ?,
                    group_password = ?,
                    category_id = ?,
                    avatar_file_id = ?,
                    avatar_thumb_file_id = ?,
                    modified = ?
                    WHERE _id = ?', array(
            $name,
            $ownerId,
            $description,
            $password,
            $categoryId,
            $avatarURL,
            $thumbURL,
            time(),
            $groupId));

        if ($result) {
            return array(
                'message' => 'group updated'
            );
        } else {
            $arr = array('message' => 'update group error!', 'error' => 'logout');
            return json_encode($arr);
            ;
        }

        return null;
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

        return $user;
    }

    public function reformatMessageData($message) {

        $message['created'] = intval($message['created']);
        $message['modified'] = intval($message['modified']);
        $message['type'] = 'message';

        return $message;
    }

    public function reformatCommentData($comment) {

        $comment['created'] = intval($comment['created']);
        $comment['type'] = 'comment';

        return $comment;
    }

    public function findAllGroups($offset = 0, $count = 0) {
        $this->DB = $this->getDoctrine()->getConnection();

        $result = $this->DB->fetchAll("select * from `group` order by _id limit {$count} offset {$offset}");

        $formatedGroups = array();
        foreach ($result as $group) {
            $group = $this->reformatGroupData($group);
            $formatedGroups[] = $group;
        }

        return $formatedGroups;
    }

    public function reformatGroupData($gourp) {

        if (isset($gourp['created']))
            $gourp['created'] = intval($gourp['created']);

        if (isset($gourp['modified']))
            $gourp['modified'] = intval($gourp['modified']);

        $gourp['type'] = 'group';

        return $gourp;
    }

    public function formatRow($row) {
        $row['_rev'] = "";
        return $row;
    }
     public function getAllUsersCountByGroupId($groupId){
    $this->DB = $this->getDoctrine()->getConnection();
        $query = "
            select count(*) from user where _id in 
                (select user_id from user_group where group_id = ?)";

        $users = $this->DB->fetchColumn($query,array($groupId));

        return $users;
        
    }
   public function findGroupCategoryById($id){
        $this->DB = $this->getDoctrine()->getConnection();
        $groupCategory = $this->DB->fetchAssoc('select * from group_category where _id = ?',array($id));                
        return $groupCategory;
        
    }
      public function getGroupsByUserId($userId){
        $this->DB = $this->getDoctrine()->getConnection();
        $query = "select * from `group` where _id in (select group_id from user_group where user_id = ?)";
        $groups = $this->DB->fetchAll($query,array($userId));
        return $groups;
    }
    public function createGroup($name, $ownerId, $categoryId, $description, $password, $avatarURL, $thumbURL) {

        $this->DB = $this->getDoctrine()->getConnection();
        $groupData = array(
            'name' => $name,
            'group_password' => $password,
            'category_id' => $categoryId,
            'description' => $description,
            'user_id' => $ownerId,
            'avatar_file_id' => $avatarURL,
            'avatar_thumb_file_id' => $thumbURL,
            'created' => time(),
            'modified' => time()
        );

        if ($this->DB->insert('`group`', $groupData)) {
            return array(
                'message' => 'group created'
            );
        } else {
            return null;
        }
    }
    public function subscribeGroup($groupId,$userId){
        
        $valueArray = array();
        $valueArray['user_id'] = $userId;
        $valueArray['group_id'] = $groupId;
        $valueArray['created'] = time();
        
        if($this->DB->insert('user_group',$valueArray)){
            return true;
        }else{
            return false;
        }
                
        return true;

    }
    
    public function unSubscribeGroup($groupId,$userId){

        $contact = $this->DB->fetchAssoc('select _id from user_group where user_id = ? and group_id = ?',
                                        array($userId,$groupId));
        
        $this->DB->delete('user_group', array('_id' => $contact['_id']));

        return true;
        
    }
}
