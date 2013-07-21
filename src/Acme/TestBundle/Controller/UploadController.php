<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\TestBundle\Dependency\Task;
use Acme\TestBundle\Dependency\Posting;

class UploadController extends Controller {

    public function indexAction() {
        return $this->render('AcmeTestBundle:Default:upload.html.twig', array('name' => '$name'));
    }

    public function editAction() {
        $posting = new Posting();
        $task = new Task();
        $task->setDueDate(new \DateTime('tomorrow'));
        $form = $this->createFormBuilder($task)->getForm();
                //->add('task', 'text')
                //->add('dueDate', 'date')
        
        $request = $this->getRequest();

        $editId = $request->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            $editId = sprintf('%09d', mt_rand(0, 1999999999));
            if ($posting->getId()) {
                $this->get('punk_ave.file_uploader')->syncFiles(
                        array('from_folder' => 'attachments/' . $posting->getId(),
                            'to_folder' => 'tmp/attachments/' . $editId,
                            'create_to_folder' => true));
            }
        }

        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/attachments/' . $editId));
        

        $fileUploader = $this->get('punk_ave.file_uploader');
        $fileUploader->syncFiles(
                array('from_folder' => '/tmp/attachments/' . $editId,
                    'to_folder' => '/attachments/' . $posting->getId(),
                    'remove_from_folder' => true,
                    'create_to_folder' => true));
        
        $files = $fileUploader->getFiles(array('folder' => 'attachments/' . $posting->getId()));
        
        return $this->render('AcmeTestBundle:Default:edit.html.twig', array('name' => 'shayan karami',
                    'posting' => $posting,
                    'editId' => $editId,
                    'form' => $form->createView(),
                    'isNew' => TRUE,
                    'cancel' => 'http://amoosibiloo.com/app_dev.php/testupload/edit',
                    'existingFiles' => $existingFiles,
                    'files' => $files));
        
    }

    public function uploadAction() {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new Exception("Bad edit id");
        }

        $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/attachments/' . $editId));
    }
    
    public function deleteAction(){
        $id = $this->getRequest()->get('id');
        $this->get('punk_ave.file_uploader')->removeFiles(array('folder' => 'attachments/' . $id));
    }

}
