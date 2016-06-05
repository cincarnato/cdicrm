<?php

namespace CdiCrm\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class QcController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function newAction() {
        $id = $this->params("id");

        $buldier = $this->getServiceLocator()->get('cdicommons_form_doctrine_builder');
        $form = $buldier->generateForm('CdiCrm\Entity\QuickContact', $id);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $result = $buldier->saveObject($data);
            if ($result) {
                $this->flashMessenger()->addSuccessMessage('Su consulta fue registrada con exito. La responderé a la brevedad posible.');

                return $this->redirect()->toRoute('cdicrm', array(
                            'controller' => "qc",
                            'action' => "list")
                );
            }
        }

        return array('form' => $form);
    }

    public function listAction() {

        //Redirect para login
//        $routeMatch = $this->getEvent()->getRouteMatch();
//        $redirect = $this->url()->fromRoute($routeMatch);
//        $this->getRequest()->getQuery()->set('redirect', $redirect);
        //Fin Redirect para login

        $id = $this->params("id");


        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $user = $this->zfcUserAuthentication()->getIdentity();
        }

//                if ($new) {
//                    $object->setCreatedBy($user);
//                    $object->setLastUpdatedBy($user);
//                } else {
//                    $object->setLastUpdatedBy($user);
//                }

        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('u')
                ->from('CdiCrm\Entity\QuickContact', 'u')
                ->where("u.createdBy = :user")
                ->setParameter("user", $user);


        $grid = $this->getServiceLocator()->get('cdiGrid');
        $source = new \CdiDataGrid\DataGrid\Source\Doctrine($this->getEntityManager(), 'CdiCrm\Entity\QuickContact', $query);
        $grid->setSource($source);
        $grid->setRecordPerPage(100);
        $grid->datetimeColumn('createdAt', 'Y-m-d H:i:s');
        $grid->datetimeColumn('updatedAt', 'Y-m-d H:i:s');
        $grid->hiddenColumn('createdBy');
        $grid->hiddenColumn('lastUpdatedBy');

        $grid->addNewOption("Add", "btn btn-primary fa fa-plus", " Agregar");
        $grid->addViewOption("View", "left", "btn btn-warning fa fa-list");
        //$grid->addEditOption("Edit", "left", "btn btn-primary fa fa-edit");
        // $grid->addDelOption("Del", "left", "btn btn-danger fa fa-trash");
        $grid->setTableClass("table-condensed customClass");


        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $user = $this->zfcUserAuthentication()->getIdentity();
        }


        $grid->getSource()->getEventManager()->attach('updateRecord_before', function ($e) use($user) {
            $params = $e->getParams();
            $params['record']->setLastUpdatedBy($user);
        });

        $grid->getSource()->getEventManager()->attach('saveRecord_before', function ($e) use($user) {
            $params = $e->getParams();
            $params['record']->setCreatedBy($user);
            $params['record']->setLastUpdatedBy($user);
        });


        $grid->getSource()->getEventManager()->attach('updateRecord_post', function ($e) use($user) {
            return $this->redirect()->refresh();
        });

        $grid->getSource()->getEventManager()->attach('saveRecord_post', function ($e) use($user) {

            // return $this->redirect()->refresh();
            $this->forward()->dispatch('CdiCrm\Controller\Qc', [
                'action' => 'error'
            ]);


//            $params = $e->getParams();
//            $record = $params['record'];
//            $user = $record->getCreatedBy();
//            $mailService = $this->getServiceLocator()->get('acmailer.mailservice.default');
//            $mailService->setSubject("Consulta Rapida: " . $record->getId())
//                    ->setTemplate('application/email/consulta', array(
//                        'object' => $record, 'user' => $user));
//
//            $message = $mailService->getMessage();
//            $message->addTo('cristian.cdi@gmail.com', "Cristian Incarnato");
//            $message->setReplyTo($user->getEmail(), $user->getUsername());
//            $result = $mailService->send();
//            if ($result->isValid()) {
//                $this->flashMessenger()->addSuccessMessage('Su consulta fue registrada con exito. La responderé a la brevedad posible.');
//
//            } else {
//                if ($result->hasException()) {
//                    echo sprintf('An error occurred. Exception: \n %s', $result->getException()->getTraceAsString());
//                } else {
//                    echo sprintf('An error occurred. Message: %s', $result->getMessage());
//                }
//            }
            //redirect
        });
        $grid->prepare();

        if ($this->request->getPost("crudAction") == "edit" || $this->request->getPost("crudAction") == "add") {
            if (!$this->isAllowed('adm', 'show')) {
                $grid->getEntityForm()->remove('response');
            }
        }

        return array('grid' => $grid);
    }

    public function errorAction() {
        
    }

}
