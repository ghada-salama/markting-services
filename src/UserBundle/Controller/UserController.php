<?php

namespace UserBundle\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Session\Session;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;
    use AppBundle\Entity\User;
    use AppBundle\Entity\Group;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use FOS\RestBundle\Controller\Annotations;
    use FOS\RestBundle\Controller\Annotations\RouteResource;
    use AppBundle\Controller\ApiResponseTrait;
    /**
     * @Route("api/")
     */
    class UserController extends Controller 
    {

        use ApiResponseTrait;

        /**
         * @Route("user/list", name="user_list" )
         * @Method({"GET"})
         * @Annotations\View(serializerGroups={
         *   "list_users"
         * })
         */
        public function userlist(Request $request) 
        {
            $query = $this->getDoctrine()->getRepository('AppBundle:User')->allUsers();
            // $paginator = $this->get('knp_paginator');
            // $pagination = $paginator->paginate(
            //         $query,1,10
            // );
            $data['data'] = $query->getResult();
            //$data['pagination'] = $pagination->getPaginationData();
            return $data;
        }


        /**
         * @Route("user/show/{id}", name="show_user" )
         * @Method({"GET"})
         * @ParamConverter("User", class="AppBundle:User")
         * @Annotations\View(serializerGroups={
         *   "show_users"
         * })
         */
        public function showUser(Request $request,$id) 
        {
            $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
            if(!$user)
            {
                return $this->apiResponse(null, 'error', 400,"user not found"); 
            }
            $data['data'] = $user;
            return $data;
        }

        /**
         * @Route("user/delete", name="user_delete", options={"expose"=true})
         * @Method({"Post"})
         */
        public function deleteuserAction(Request $request)
        {
                $data=json_decode($request->getContent());
                //$data=($data);
                $id=$data->id[0];
                $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
                if($user)
                {
                    $userManager = $this->get('fos_user.user_manager');
                    $entityManager = $this->get('doctrine')->getManager();
                    $user->setEnabled(false);
                    $userManager->updateUser($user);
                    return $this->apiResponse(null, 'success', 200);
                }
                return $this->apiResponse(null, 'error', 400,"user not found");
            
        }



        /**
         * @Route("user/add", name="user_add")
         */
        public function addAction(Request $request) {
            //die("sdsd");
            $data=$request->getContent();
            $data=json_decode($data);
            $userManager = $this->get('fos_user.user_manager');
            $entityManager = $this->get('doctrine')->getManager();

            //unique mail amd username 
            $exist_email=$this->getDoctrine()->getRepository('AppBundle:User')->findByEmail($data->email);
            if($exist_email)
            {
               // die("sdsd");
                return $this->apiResponse("exist email", 'error', 400);   
            }

            $exist_username=$this->getDoctrine()->getRepository('AppBundle:User')->findByUserName($data->username);
            if($exist_username)
            {
                return $this->apiResponse("exist userName", 'error', 400);   
            }
            $user = $userManager->createUser();
            $user->setUsername($data->username);
            if(isset($data->langid)){
                $getLang=$this->getDoctrine()->getRepository('AppBundle:Lang')->findById($data->langid);
                $user->setLang($getLang);
            }
            $user->setEmail($data->email);
           // $str=$data->email.date("Y-m-d H:i:s");
            $str='soa_'.$data->username;
            $password=md5($str);
            $user->setPlainPassword($password);
            $user->setEnabled(true);
            //add  first name and last name
            $user->setFirstName($data->firstName);
            $user->setLastName($data->lastName);
            
            
            $user->setHousehold($data->Household);
            $user->setHealthcare($data->Healthcare);
            //set lang
            $lang = $this->getDoctrine()->getRepository('AppBundle:Lang')->find($data->lang_id->id);
            $user->setLangId($lang);

            if(isset($data->groups)){

                foreach ($data->groups as $groupItm){
                   
                    $getgroup=$this->getDoctrine()->getRepository('AppBundle:Group')->findById($groupItm->id);
                    //dump($getgroup);die;    
                    $user->addGroup($getgroup);
                }


            }
            $userManager->updateUser($user);

            return $this->apiResponse(null, 'success', 200);
        }

        /**
         * @Route("group/add", name="group_add"), options={"expose"=true}
         * @Method({"POST"})
         */
        // public function addGroupAction(Request $request) {

        //     $data=$request->getContent();
        //     $data=json_decode($data);
          
        //          //unique  group name 
        //          $exist_des=$this->getDoctrine()->getRepository('AppBundle:Group')->findByName($data->name);
        //          if($exist_des)
        //          {
                   
        //              return $this->apiResponse("exist group name", 'error', 400);   
        //          }

        //     $em = $this->getDoctrine()->getManager();

        //    // $group=new Group($data->name,[],$data->observaciones);
        //    $groupManager = $this->get('fos_user.group_manager');

        //     $group= $groupManager->createGroup($data->name);
        //     $group->setName($data->name);
        //     $group->setObservaciones($data->observaciones);
        //     $em->persist($group);
        //     $em->flush();
        //     return $this->apiResponse(null, 'success', 200);
        // }


        /**
         * @Route("user/{User}/edit", name="user_edit", options={"expose"=true})
         * @ParamConverter("User", class="AppBundle:User")
         * @Method({"POST"})
         */
        public function edituserAction($User, Request $request)
        {

                $userManager = $this->get('fos_user.user_manager');
                $entityManager = $this->get('doctrine')->getManager();
                $data=$request->getContent();
                $data=json_decode($data);



    if(isset($data->groups)){
            foreach ($data->groups as $groupItm){
               // dump($groupItm->id);die();
                $getgroup=$this->getDoctrine()->getRepository('AppBundle:Group')->findById($groupItm->id);
                $User->addGroup($getgroup);
            }
        }

    if(isset($data->lang_id)){

        //dump lang
       // dump($data->lang_id->id);die;



            $getLang=$this->getDoctrine()->getRepository('AppBundle:Lang')->findOneById($data->lang_id->id);
            $User->setLangId($getLang);
        }
            $User->setUsername($data->username);
            $User->setEmail($data->email);
            $User->setEnabled(true);
            //add  first name and last name
            $User->setFirstName($data->firstName);
            $User->setLastName($data->lastName);
            
                  $User->setHousehold($data->Household);
            $User->setHealthcare($data->Healthcare);
            
            $userManager->updateUser($User);
            return $this->apiResponse(null, 'success', 200);
        }

        /**
         * @Route("group/add/xx", name="user_group_add")
         * @Method({"POST"})
         * @Annotations\View()
         */
        // public function addGroupAction(Request $request) {
        //     $data=$request->getContent();
        //     $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        //     $group=$serializer->deserialize($data,'AppBundle\Entity\Group','json');
        //     $em = $this->getDoctrine()->getManager();
        //         $em->persist($group);
        //         $em->flush();
        //         return true;
        //  }




        /**
         * @Route("group/{Group}/edit", name="user_group_edit")
         * @ParamConverter("Group", class="AppBundle:Group")
         * @Method({"POST"})
         * @Annotations\View()
         */
        public function editGroupAction(Request $request,$Group) {

            $data=$request->getContent();
            $getJson = json_decode($data);
            $Group->setRoles(array());
            if(isset($getJson->name)){
                $Group->setName($getJson->name);
            }
            if(isset($getJson->roles)){
                foreach ($getJson->roles as $role){
                $Group->addRole($role);
                }
            }
            $em = $this->getDoctrine()->getManager();
                $em->persist($Group);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
            }

        /**
         * @Route("group/list", name="user_groups_list")
         * @Method({"GET"})
         * @Annotations\View(serializerGroups={
         *  "show_group"
         * })
         */
        public function listByGroupsAction(Request $request) {

            $groups=$this->getDoctrine()->getRepository('AppBundle:Group')->getAllGroups();
            $data['data'] = $groups->getResult();
            return $data;
        }

        /**
         * @Route("group/show/{id}", name="show_group" )
         * @Method({"GET"})
         * @ParamConverter("Group", class="AppBundle:Group")
         * @Annotations\View(serializerGroups={
         *  "show_user_group"
         * })
         */
        public function showGroup(Request $request,$id) 
        {
            $group = $this->getDoctrine()->getRepository('AppBundle:Group')->find($id);
            $data['data'] = $group;
            return $data;
        }


        /**
         * @Route("group/delete", name="user_groups_delete")
         * @Method({"Post"})
         * @Annotations\View()
         */
        // public function deleteGroupsAction(Request $request) 
        // {
            
        //     $data=json_decode($request->getContent());
        //     $id=$data->id;
        //     $group = $this->getDoctrine()->getRepository('AppBundle:Group')->find($id);

            
        //         if($group)
        //         {
        //             //system group user can,t delete 
        //             if(in_array($group->getId(),[1,2,3]))
        //             {
        //                 return $this->apiResponse(null, 'error', 400,"can't delete this group");
        //             }
        //             $em = $this->getDoctrine()->getEntityManager();
        //             $group->setFlag(1);
        //             $em->persist($group);
        //             $em->flush();
        //             return $this->apiResponse(null, 'success', 200);
        //         }
        //     return $this->apiResponse(null, 'error', 400,"group not found");
        // }

    }
