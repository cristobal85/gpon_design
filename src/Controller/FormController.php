<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WirePatternRepository;
use App\Repository\LayerGroupRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Serializer\CircularSerializer;
use App\Repository\WireRepository;

class FormController extends AbstractController {

    /**
     * @Route("/form/wire-pattern", name="form-wire-pattern")
     */
    public function getWirePatternFormData(
            WirePatternRepository $wirePatternRep,
            LayerGroupRepository $layerRep,
            CircularSerializer $serializer) {

        $layersJson = $serializer->serialize($layerRep->findAll(), ['form']);
        $wirePatternJson = $serializer->serialize($wirePatternRep->findAll(), ['form']);

        $data = [
            'layers' => json_decode($layersJson),
            'wirePatterns' => json_decode($wirePatternJson)
        ];

        return new JsonResponse($data);
    }
    
    /**
     * @Route("/form/layer", name="form-layer")
     */
    public function getLayerFormData(
            LayerGroupRepository $layerRep,
            CircularSerializer $serializer) {
        
        return new Response($serializer->serialize($layerRep->findAll(), ['form']));
    }
    
    /**
     * @Route("/form/wire", name="form-wire")
     */
    public function getWireFormData(
            WireRepository $wireRep,
            CircularSerializer $serializer) {
        
        return new Response($serializer->serialize($wireRep->findAll(), ['form']));
    }

}
