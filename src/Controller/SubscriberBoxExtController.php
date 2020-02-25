<?php

namespace App\Controller;

use App\Entity\SubscriberBoxExt;
use App\Form\SubscriberBoxExtType;
use App\Repository\SubscriberBoxExtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\CircularSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/subscriber-box-ext")
 */
class SubscriberBoxExtController extends AbstractController
{
    /**
     * @Route("/", name="subscriber_box_ext_index", methods={"GET"})
     */
    public function index(SubscriberBoxExtRepository $subscriberBoxExtRepository): Response
    {
        return $this->render('subscriber_box_ext/index.html.twig', [
            'subscriber_box_exts' => $subscriberBoxExtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="subscriber_box_ext_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $subscriberBoxExt = new SubscriberBoxExt();
        $form = $this->createForm(SubscriberBoxExtType::class, $subscriberBoxExt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscriberBoxExt);
            $entityManager->flush();

            return $this->redirectToRoute('subscriber_box_ext_index');
        }

        return $this->render('subscriber_box_ext/new.html.twig', [
            'subscriber_box_ext' => $subscriberBoxExt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_box_ext_show", methods={"GET"})
     */
    public function show(
            SubscriberBoxExt $subscriberBoxExt,
            Request $request,
            CircularSerializer $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($subscriberBoxExt, ['subscriber-box-ext']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }
        return $this->render('subscriber_box_ext/show.html.twig', [
            'subscriber_box_ext' => $subscriberBoxExt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscriber_box_ext_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, SubscriberBoxExt $subscriberBoxExt): Response
    {
        $form = $this->createForm(SubscriberBoxExtType::class, $subscriberBoxExt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscriber_box_ext_index', [
                'id' => $subscriberBoxExt->getId(),
            ]);
        }

        return $this->render('subscriber_box_ext/edit.html.twig', [
            'subscriber_box_ext' => $subscriberBoxExt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscriber_box_ext_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, SubscriberBoxExt $subscriberBoxExt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscriberBoxExt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscriberBoxExt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subscriber_box_ext_index');
    }
    
    
    /**
     * @Route("/save-subscriber-box-ext", name="map-save-subscriber-box-ext", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function saveSubscriberBoxExtAction(
            EntityManagerInterface $em,
            Request $request,
            CircularSerializer $serializer) {

        $data = json_decode($request->getContent(), true)['data'];
        $subscriberExt = $em->getRepository(SubscriberBoxExt::class)->findOneBy(array(
            "id" => $data['subscriber-box-ext']
        ));
        $icon = $em->getRepository(\App\Entity\Icon::class)->findOneBy(array(
            'element' => SubscriberBoxExt::class
        ));
        if (!$icon) {
            return new JsonResponse([
                'message'   =>  "Debe definir un icono para la caja de extensión antes de añadirla al mapa."
            ], 400);
        }
        $subscriberExt
                ->setLatitude($data['latitude'])
                ->setLongitude($data['longitude'])
                ->setIcon($icon->getIcon());

        $em->persist($subscriberExt);
        $em->flush();

        return new JsonResponse([
            'type' => SubscriberBoxExt::class,
            'message' => "Caja de extensión guardada correctamente.",
            'data' => json_decode($serializer->serialize($subscriberExt, ['map']))
        ]);
    }
}
