<?php

namespace App\Controller;

use App\Entity\LatiguilloEdfa;
use App\Form\LatiguilloEdfaType;
use App\Repository\LatiguilloEdfaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/latiguillo-edfa")
 */
class LatiguilloEdfaController extends AbstractController
{
    /**
     * @Route("/", name="latiguillo_edfa_index", methods={"GET"})
     */
    public function index(LatiguilloEdfaRepository $latiguilloEdfaRepository): Response
    {
        return $this->render('latiguillo_edfa/index.html.twig', [
            'latiguillo_edfas' => $latiguilloEdfaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="latiguillo_edfa_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $latiguilloEdfa = new LatiguilloEdfa();
        $form = $this->createForm(LatiguilloEdfaType::class, $latiguilloEdfa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            try {
                $entityManager->persist($latiguilloEdfa);
                $entityManager->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Ya se ha usado el puerto de la OLT o EDFA en otro latiguillo.');
            } 

            return $this->redirectToRoute('latiguillo_edfa_index');
        }

        return $this->render('latiguillo_edfa/new.html.twig', [
            'latiguillo_edfa' => $latiguilloEdfa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="latiguillo_edfa_show", methods={"GET"})
     */
    public function show(LatiguilloEdfa $latiguilloEdfa): Response
    {
        return $this->render('latiguillo_edfa/show.html.twig', [
            'latiguillo_edfa' => $latiguilloEdfa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="latiguillo_edfa_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, LatiguilloEdfa $latiguilloEdfa): Response
    {
        $form = $this->createForm(LatiguilloEdfaType::class, $latiguilloEdfa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
            } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
                $this->addFlash('error', 'Ya se ha usado el puerto de la OLT o EDFA en otro latiguillo.');
            } 
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('latiguillo_edfa_index', [
                'id' => $latiguilloEdfa->getId(),
            ]);
        }

        return $this->render('latiguillo_edfa/edit.html.twig', [
            'latiguillo_edfa' => $latiguilloEdfa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="latiguillo_edfa_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, LatiguilloEdfa $latiguilloEdfa): Response
    {
        if ($this->isCsrfTokenValid('delete'.$latiguilloEdfa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($latiguilloEdfa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('latiguillo_edfa_index');
    }
}
