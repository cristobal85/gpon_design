<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Form\AlertType;
use App\Repository\AlertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityManagerInterface;
use \App\Serializer\CircularSerializer;

/**
 * @Route("/alert")
 */
class AlertController extends AbstractController
{
    /**
     * @Route("/", name="alert_index", methods={"GET"})
     */
    public function index(AlertRepository $alertRepository): Response
    {
        return $this->render('alert/index.html.twig', [
            'alerts' => $alertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alert_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $alert = new Alert();
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $icon = $entityManager->getRepository(\App\Entity\Icon::class)->findOneBy(array(
                'element' => Alert::class
            ));
            $alert->setIcon($icon);
            $entityManager->persist($alert);
            $entityManager->flush();

            return $this->redirectToRoute('alert_index');
        }

        return $this->render('alert/new.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_show", methods={"GET"})
     */
    public function show(
            Alert $alert,
            Request $request,
            CircularSerializer $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($alert, ['alert']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }
        
        return $this->render('alert/show.html.twig', [
            'alert' => $alert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alert_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Alert $alert): Response
    {
        if ($alert->getClosed() && !$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'La nota (' . $alert->getTitle() . ') está cerrada y no se puede editar.');
            return $this->redirectToRoute('alert_index');
        }
        if ($alert->getUser() !== $this->getUser() && !$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'No puede editar notas de otros usuarios sin permiso de administrador.');
            return $this->redirectToRoute('alert_index');
        }
        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alert_index');
        }

        return $this->render('alert/edit.html.twig', [
            'alert' => $alert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alert_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Alert $alert): Response
    {
        if ($alert->getClosed() && !$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'La nota (' . $alert->getTitle() . ') está cerrada y no se puede eliminar.');
            return $this->redirectToRoute('alert_index');
        }
        if ($this->isCsrfTokenValid('delete'.$alert->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alert_index');
    }
    
    /**
     * @Route("/update-position", name="alert_update_position", methods={"POST", "PUT"})
     */
    public function update(
            Request $request,
            AlertRepository $alertRep,
            EntityManagerInterface $em): Response {

        $data = json_decode($request->getContent(), true)['data'];

        $alert = $alertRep->findOneBy(array(
            "id" => $data['id']
        ));
        $alert
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($alert);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Alerta modificada correctamente."
        ]);
    }
}
