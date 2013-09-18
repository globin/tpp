<?php

namespace Mayflower\TPPBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Mayflower\TPPBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * returns Project entities by week
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $projects = $em->getRepository('MayflowerTPPBundle:Project')->findAll();

        $project_arr = [];
        foreach ($projects as $project) {
            $project_arr[] = $project->toArray();
        }

        return new JsonResponse($project_arr);
    }

    /**
     * Creates a new Project entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $project = new Project();

        $data = json_decode($request->getContent(), true);
        $project->setName($data['name']);
        $project->setColor($data['color']);

        $begin = new \DateTime($data['begin']);
        $project->setBegin($begin);

        $end = new \DateTime($data['end']);
        $project->setEnd($end);

        $em->persist($project);
        $em->flush();

        return new JsonResponse($project->toArray());
    }

    /**
     * Updates a Task entity.
     *
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $project = $em->find('MayflowerTPPBundle:Project', $id);

        $data = json_decode($request->getContent(), true);
        $project->setName($data['name']);
        $project->setColor($data['color']);

        $begin = new \DateTime($data['begin']);
        $project->setBegin($begin);

        $end = new \DateTime($data['end']);
        $project->setEnd($end);

        $em->persist($project);
        $em->flush();

        return new JsonResponse($project->toArray());
    }


    /**
     * Deletes a Task entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MayflowerTPPBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $em->remove($entity);
        $em->flush();

        $response = new Response('', 204);
        return $response;
    }
}