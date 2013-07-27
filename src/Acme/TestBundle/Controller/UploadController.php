<?php

namespace Acme\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\TestBundle\Dependency\Task;
use Acme\TestBundle\Dependency\Posting;
use PunkAve\FileUploaderBundle\Entity\UploadedTmpFiles;

class UploadController extends Controller {

    public function indexAction() {
        $name = 'omid';
        $message = \Swift_Message::newInstance()
                ->setSubject('swiff maillero ra endakhtam')
                ->setFrom('send@example.com')
                ->setTo('omid.shj@gmail.com')
                ->setBody(
                $this->renderView(
                        'AcmeTestBundle:Default:index.txt.twig', array('name' => $name)
                )
                )
        ;
        $this->get('mailer')->send($message);
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
        }

        $existingFiles = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => 'tmp/' . $editId));

        if ($existingFiles) {

            $em = $this->getDoctrine()->getManager();

            $fileUploader = $this->get('punk_ave.file_uploader');
            $fileUploader->mySyncFiles(
                    array('from_folder' => 'tmp/' . $editId,
                        'to_folder' => 'img',
                        'remove_from_folder' => true,
                        'create_to_folder' => true));
            //commit
            //$em->flush();
            $isNew = FALSE;
        } else {
            $isNew = TRUE;
        }

        $files = $this->get('punk_ave.file_uploader')->getFiles(array('folder' => '../../img'));
        $thumb_files = $this->get('punk_ave.file_uploader')->getThumbFiles(array('folder' => 'img'));

        return $this->render('AcmeTestBundle:Default:edit.html.twig', array('name' => 'shayan karami',
                    'posting' => $posting,
                    'editId' => $editId,
                    'form' => $form->createView(),
                    'isNew' => $isNew,
                    'cancel' => 'http://amoosibiloo.com/app_dev.php/testupload/edit',
                    'existingFiles' => $existingFiles,
                    'files' => $files,
                    'thumb_files' => $thumb_files));
    }

    public function uploadAction() {
        $editId = $this->getRequest()->get('editId');
        if (!preg_match('/^\d+$/', $editId)) {
            throw new Exception("Bad edit id");
        }

        $name = $_FILES['files']['name'][0];
        $type = $_FILES['files']['type'][0];
        $size = $_FILES['files']['size'][0];

        $UploadedTmpFiles = new UploadedTmpFiles();
        $UploadedTmpFiles->setType($type);
        $UploadedTmpFiles->setSize($size);
        $em = $this->getDoctrine()->getManager();
        $em->persist($UploadedTmpFiles);
        $em->flush();

        $explode = explode(".", $name);
        if (count($explode > 1)) {
            $extension = end($explode);
            $new_name = $UploadedTmpFiles->getId() . "." . $extension;
        } else {
            $new_name = $UploadedTmpFiles->getId();
        }
        try {
            $this->get('punk_ave.file_uploader')->handleFileUpload(array('folder' => 'tmp/' . $editId,
                'new_name' => $new_name));
        } catch (Exception $exc) {
            $UploadedTmpFiles->setIsActive(FALSE);
            $em->persist($UploadedTmpFiles);
            $em->flush();
            echo $exc->getTraceAsString();
        }
    }

    public function cancleAction() {
        $editId = $this->getRequest()->get('editId');
        $this->get('punk_ave.file_uploader')->removeFolder(array('folder' => 'tmp/' . $editId));
        return $this->redirect($this->generateUrl('acme_test_upload_edit'));
    }

    public function deleteAction() {
        $files = $this->getRequest()->get('files');
        $this->get('punk_ave.file_uploader')->removeFiles(array('folder' => 'img/thumbnails', 'files' => $files));
        $this->get('punk_ave.file_uploader')->removeFiles(array('folder' => '../../img/originals', 'files' => $files));
        return $this->redirect($this->generateUrl('acme_test_upload_edit'));
    }

}
