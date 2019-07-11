<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Service\Validate;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Client;
use FOS\RestBundle\Controller\Annotations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Translation\Translator;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use AppBundle\Entity\DefaultShopValue;
use AppBundle\Form\ClientType;

class ClientController extends FOSRestController implements ClassResourceInterface 

{
    use ApiResponseTrait;
 

    
    /**
     * @Route("/api/clients/{order}",name="list_clients")
     * @Method({"POST"})
     * @Annotations\View(serializerGroups={
     *   "list_client"
     * })
     * 
     */

    public function listClients(Request $request,$order)
    {

        $data=$request->getContent();
        $getJson = json_decode($data);
        $ids=$getJson->ids;
     
        $clients=$this->getDoctrine()->getRepository('AppBundle:Client')->getClientsOrderBy($ids,$order);
        $res['clients'] = $clients;//$pagination->getItems();
         return $res;
     
    }

        /**
     * @Route("/api/clients/{order}",name="get_list_clients")
     * @Method({"Get"})
     * @Annotations\View(serializerGroups={
     *   "list_client"
     * })
     * 
     */

    public function getListClients($order)
    {

     
        $clients=$this->getDoctrine()->getRepository('AppBundle:Client')->getListClientsOrderBy($order);
        $res['clients'] = $clients;//$pagination->getItems();
         return $res;
     
    }
  
  

    /**
     * @param Request $request
     * @Annotations\Post("api/client/add",name="create_client")
     */
    public function addclient(Request $request)
    {
       
         
        $data=$request->getContent();
        $data = json_decode($data);
        $em = $this->getDoctrine()->getManager();
        $client = new Client();
        $form = $this->createForm(ClientType::class,$client);
        $form->submit($request->request->all());

        if ($form->isValid()) {
                $client->setName($data->name);
                $client->setimageH($data->imageH);
                $client->setPlantTo($data->plantTo);
                $client->setClientOrder($data->clientOrder);
                $client->setMaxShops($data->maxShops);
                
                $em->persist($client);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
         
      
   }
       /**
     * @param Request $request
     * @Annotations\Post("api/client/edit/{id}",name="edit_client")
     * @ParamConverter("client", class="AppBundle:Client")
     */
    public function editClient(Request $request,$id)
    {
        $data=$request->getContent();
        $data = json_decode($data);
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        //$header = new header();
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);
        $form = $this->createForm(ClientType::class,$client);
        $form->submit($request->request->all());

        if ($form->isValid()) {
                $client->setName($data->name);
                $client->setimageH($data->imageH);
                $client->setPlantTo($data->plantTo);
                $client->setClientOrder($data->clientOrder);
                $client->setMaxShops($data->maxShops);
                $em->persist($client);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
      
   }

   
    /**
     * @Route("/api/client/delete",name="delete_client")
     * @Annotations\View()
     * @Method({"Post"})
     */

    public function deleteClient(Request $request)
    {
        $data=$request->getContent();
        $data = json_decode($data);
        $ids=$data->id;

        $clients=$this->getDoctrine()->getRepository('AppBundle:Client')->getClientsObjectById($ids);
        foreach ($clients as  $client) 
        {
            $em=$this->getDoctrine()->getManager();
            $client->setFlag(1);
            $em->persist($client);
            $em->flush(); 
        }
        
        return $this->apiResponse(null, 'success', 200);
    }

   


   
}
