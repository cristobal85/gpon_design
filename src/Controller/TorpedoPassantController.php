<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WireRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TorpedoPassant;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Torpedo;
use \Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Psr\Log\LoggerInterface;

class TorpedoPassantController extends AbstractController {

    /**
     * @Route("/torpedo-passant/{torpedo}", name="torpedo_passant_new", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(
            Request $request,
            WireRepository $wireRep,
            Torpedo $torpedo,
            EntityManagerInterface $em,
            ValidatorInterface $validator,
            LoggerInterface $logger
    ) {
        $data = json_decode($request->getContent(), true)['data'];
        $wire1 = $wireRep->findOneBy(['id' => intval($data['wire1Id'])]);
        $wire2 = $wireRep->findOneBy(['id' => intval($data['wire2Id'])]);
        $passantsCount = 0;

        $wire1Tubes = $wire1->getTubes();
        for ($i = 0; $i < count($wire1Tubes); $i++) {
            $fibers = $wire1Tubes[$i]->getFibers();
            for ($j = 0; $j < count($fibers); $j++) {
                $fiber1 = $fibers[$j];
                $fiber2 = $wire2->getTubes()[$i]->getFibers()[$j];
                // TODO: Refactoring this
                if (!empty($fiber1) && !empty($fiber2) && $fiber1 !== $fiber2 &&
                        !$torpedo->isFiberInUse($fiber1) && !$torpedo->isFiberInUse($fiber2)) {
                    $torpedoPassant = new TorpedoPassant();
                    $torpedoPassant->addFiber($fiber1)->addFiber($fiber2)->setTorpedo($torpedo);
                    $torpedo->addPassant($torpedoPassant);

                    $torpedoErrors = $validator->validate($torpedoPassant);
                    $fiber1Errors = $validator->validate($fiber1);
                    $fiber2Errors = $validator->validate($fiber2);

                    $errorsString = "";
                    if (count($torpedoErrors) > 0) {
                        $errorsString = (string) $torpedoErrors;
                    }
                    if (count($fiber1Errors) > 0) {
                        $errorsString = (string) $fiber1Errors;
                    }
                    if (count($fiber2Errors) > 0) {
                        $errorsString = (string) $fiber2Errors;
                    }
                    if (!empty($errorsString)) {
                        return new JsonResponse([
                            'message' => $errorsString
                                ], 400);
                    }

                    $em->persist($torpedo);

                    $passantsCount++;
                } 
//                else 
//                {
//                    $logger->info('No entro la bola en: '. $fiber1);
//                    $logger->info('¿Está fusionada? '. ($torpedo->isFiberInUseAsFusion($fiber1) ? 'SI' : 'NO'));
//                    $logger->info('¿Está como pasante? '. ($torpedo->isFiberInUseAsPassant($fiber1) ? 'SI' : 'NO'));
//                    $logger->info('Fusiones: ');
//                    foreach ($fiber1->getTorpedoFusions() as $torpedoFusion) {
//                        $logger->info($torpedoFusion);
//                    }
//                    $logger->info('Pasantes: ');
//                    foreach ($fiber1->getTorpedoPassants() as $torpedoPassant) {
//                        $logger->info($torpedoPassant);
//                    }
//                    $logger->info('--- o ---');
//                    $logger->info('No entro la bola en: '. $fiber2);
//                    $logger->info('¿Está fusionada? '. ($torpedo->isFiberInUseAsFusion($fiber2) ? 'SI' : 'NO'));
//                    $logger->info('¿Está como pasante? '. ($torpedo->isFiberInUseAsPassant($fiber2) ? 'SI' : 'NO'));
//                    $logger->info('Fusiones: ');
//                    foreach ($fiber2->getTorpedoFusions() as $torpedoFusion) {
//                        $logger->info($torpedoFusion);
//                    }
//                    $logger->info('Pasantes: ');
//                    foreach ($fiber2->getTorpedoPassants() as $torpedoPassant) {
//                        $logger->info($torpedoPassant);
//                    }
//                    $logger->info('----------------------------------------');
//                    $logger->info('----------------------------------------');
//                }
            }
        }

        $em->flush();

        return new JsonResponse([
            'message' => 'Se han añadido (' . $passantsCount . ') pasantes en el torpedo.'
        ]);
    }
    
    /**
     * @Route("/torpedo-passant/{torpedo}", name="torpedo_passant_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deletePassants(
            Request $request,
            Torpedo $torpedo,
            EntityManagerInterface $em) {
        if ($request->isXmlHttpRequest()) {
            $passants = $torpedo->getPassants();
            $passantsCount = 0;
            foreach ($passants as $passant) {
                $em->remove($passant);
                $passantsCount++;
            }
            $em->flush();

            return new JsonResponse([
                'message' => 'Se han eliminado (' . $passantsCount . ') pasantes del torpedo.'
            ]);
        }
        
        throw new BadRequestHttpException();
    }

}
