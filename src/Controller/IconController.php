<?php

namespace App\Controller;

use App\Entity\Icon;
use App\Form\IconType;
use App\Repository\IconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Interfaces\EntityIconable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/icon")
 */
class IconController extends AbstractController
{
    /**
     * @Route("/", name="icon_index", methods={"GET"})
     */
    public function index(IconRepository $iconRepository): Response
    {
        return $this->render('icon/index.html.twig', [
            'icons' => $iconRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="icon_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $icon = new Icon();
        $form = $this->createForm(IconType::class, $icon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($icon);
            /** @type EntityIconable[] */
            $iconables = $entityManager->getRepository($icon->getElement())->findAll();
            foreach ($iconables as $iconable) {
                $iconable->setIcon($icon->getIcon());
                $entityManager->persist($iconable);
            }
            $entityManager->flush();

            return $this->redirectToRoute('icon_index');
        }

        return $this->render('icon/new.html.twig', [
            'icon' => $icon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="icon_show", methods={"GET"})
     */
    public function show(Icon $icon): Response
    {
        return $this->render('icon/show.html.twig', [
            'icon' => $icon,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="icon_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Icon $icon): Response
    {
        $form = $this->createForm(IconType::class, $icon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            /** @type EntityIconable[] */
            $iconables = $entityManager->getRepository($icon->getElement())->findAll();
            foreach ($iconables as $iconable) {
                $iconable->setIcon($icon->getIcon());
                $entityManager->persist($iconable);
            }
            $entityManager->flush();

            return $this->redirectToRoute('icon_index');
        }

        return $this->render('icon/edit.html.twig', [
            'icon' => $icon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="icon_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Icon $icon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$icon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($icon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('icon_index');
    }
}
