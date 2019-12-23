<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityManagerInterface;
use \App\Serializer\CircularSerializer;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController {

    /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository): Response {
        return $this->render('note/index.html.twig', [
                    'notes' => $noteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $note->setUser($this->getUser());
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/new.html.twig', [
                    'note' => $note,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_show", methods={"GET"})
     */
    public function show(
            Note $note,
            Request $request,
            CircularSerializer $serializer): Response {

        if ($request->isXmlHttpRequest()) {
            $jsonObject = $serializer->serialize($note, ['note']);
            return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);
        }

        return $this->render('note/show.html.twig', [
                    'note' => $note,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response {
        if ($note->getClosed() && !$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'La nota (' . $note->getTitle() . ') está cerrada y no se puede editar.');
            return $this->redirectToRoute('note_index');
        }
        if ($note->getUser() !== $this->getUser() && !$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'No puede editar notas de otros usuarios sin permiso de administrador.');
            return $this->redirectToRoute('note_index');
        }
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $closedBy = ($note->getClosed()) ? $this->getUser() : null;
            $note->setClosedBy($closedBy);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/edit.html.twig', [
                    'note' => $note,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Note $note): Response {
        if ($note->getClosed() && !$this->getUser()->isAdmin()) {
            $this->addFlash('error', 'La nota (' . $note->getTitle() . ') está cerrada y no se puede eliminar.');
            return $this->redirectToRoute('note_index');
        }
        if ($this->isCsrfTokenValid('delete' . $note->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();
        }

        return $this->redirectToRoute('note_index');
    }

    /**
     * @Route("/update-position", name="note_update_position", methods={"POST", "PUT"})
     */
    public function update(
            Request $request,
            NoteRepository $noteRep,
            EntityManagerInterface $em): Response {

        $data = json_decode($request->getContent(), true)['data'];

        $note = $noteRep->findOneBy(array(
            "id" => $data['id']
        ));
        $note
                ->setLatitude(floatval($data['latitude']))
                ->setLongitude(floatval($data['longitude']));

        $em->persist($note);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse([
            'message' => "Nota modificada correctamente."
        ]);
    }

}
