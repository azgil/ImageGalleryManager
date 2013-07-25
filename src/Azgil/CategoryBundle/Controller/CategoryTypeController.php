<?php

namespace Azgil\CategoryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Azgil\CategoryBundle\Entity\CategoryType;
use Azgil\CategoryBundle\Form\CategoryTypeType;

/**
 * CategoryType controller.
 *
 */
class CategoryTypeController extends Controller
{

    /**
     * Lists all CategoryType entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AzgilCategoryBundle:CategoryType')->findAll();

        return $this->render('AzgilCategoryBundle:CategoryType:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CategoryType entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new CategoryType();
        $form = $this->createForm(new CategoryTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_types_show', array('id' => $entity->getId())));
        }

        return $this->render('AzgilCategoryBundle:CategoryType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new CategoryType entity.
     *
     */
    public function newAction()
    {
        $entity = new CategoryType();
        $form   = $this->createForm(new CategoryTypeType(), $entity);

        return $this->render('AzgilCategoryBundle:CategoryType:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoryType entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AzgilCategoryBundle:CategoryType:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CategoryType entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryType entity.');
        }

        $editForm = $this->createForm(new CategoryTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AzgilCategoryBundle:CategoryType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing CategoryType entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AzgilCategoryBundle:CategoryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('category_types_edit', array('id' => $id)));
        }

        return $this->render('AzgilCategoryBundle:CategoryType:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoryType entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AzgilCategoryBundle:CategoryType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoryType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category_types'));
    }

    /**
     * Creates a form to delete a CategoryType entity by id.
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
