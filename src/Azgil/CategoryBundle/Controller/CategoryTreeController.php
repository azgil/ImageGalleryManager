<?php

namespace Azgil\CategoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Azgil\CategoryBundle\Entity\CategoryTree;
use Azgil\CategoryBundle\Form\CategoryTreeType;

/**
 * CategoryTree controller.
 *
 */
class CategoryTreeController extends Controller
{

    /**
     * Lists all CategoryTree entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AzgilCategoryBundle:CategoryTree')->findAll();

        return $this->render('AzgilCategoryBundle:CategoryTree:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CategoryTree entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new CategoryTree();
        $form = $this->createForm(new CategoryTreeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_tree_show', array('id' => $entity->getId())));
        }

        return $this->render('AzgilCategoryBundle:CategoryTree:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new CategoryTree entity.
     *
     */
    public function newAction()
    {
        $entity = new CategoryTree();
        $form   = $this->createForm(new CategoryTreeType(), $entity);

        return $this->render('AzgilCategoryBundle:CategoryTree:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoryTree entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryTree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryTree entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AzgilCategoryBundle:CategoryTree:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CategoryTree entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryTree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryTree entity.');
        }

        $editForm = $this->createForm(new CategoryTreeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AzgilCategoryBundle:CategoryTree:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing CategoryTree entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryTree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryTree entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryTreeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_tree_edit', array('id' => $id)));
        }

        return $this->render('AzgilCategoryBundle:CategoryTree:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoryTree entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AzgilCategoryBundle:CategoryTree')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoryTree entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category_tree'));
    }

    /**
     * Creates a form to delete a CategoryTree entity by id.
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
