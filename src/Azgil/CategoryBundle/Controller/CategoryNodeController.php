<?php

namespace Azgil\CategoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Azgil\CategoryBundle\Entity\CategoryNode;
use Azgil\CategoryBundle\Form\CategoryNodeType;

/**
 * CategoryNode controller.
 *
 */
class CategoryNodeController extends Controller
{

    /**
     * Lists all CategoryNode entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AzgilCategoryBundle:CategoryNode')->findAll();

        return $this->render('AzgilCategoryBundle:CategoryNode:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CategoryNode entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new CategoryNode();
        $form = $this->createForm(new CategoryNodeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_nodes_show', array('id' => $entity->getId())));
        }

        return $this->render('AzgilCategoryBundle:CategoryNode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new CategoryNode entity.
     *
     */
    public function newAction()
    {
        $entity = new CategoryNode();
        $form   = $this->createForm(new CategoryNodeType(), $entity);

        return $this->render('AzgilCategoryBundle:CategoryNode:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoryNode entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryNode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AzgilCategoryBundle:CategoryNode:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CategoryNode entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryNode entity.');
        }

        $editForm = $this->createForm(new CategoryNodeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AzgilCategoryBundle:CategoryNode:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing CategoryNode entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryNode entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryNodeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_nodes_edit', array('id' => $id)));
        }

        return $this->render('AzgilCategoryBundle:CategoryNode:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoryNode entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AzgilCategoryBundle:CategoryNode')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoryNode entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category_nodes'));
    }

    /**
     * Creates a form to delete a CategoryNode entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
