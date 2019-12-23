<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author cristobal
 */
class PatternGeneratorFactory {
    
    /**
     * 
     * @param ObjectManager $em
     * @param object $entity
     */
    public static function make(ObjectManager $em, $entity) : PatternGenerator {
        switch (get_class($entity)) {
            case PatternGeneratorType::NODO:
                return new NodoPatternGenerator($em, $entity);
            case PatternGeneratorType::EDFA:
                return new EdfaPatternGenerator($em, $entity);
            case PatternGeneratorType::OLT_SLOT:
                return new OltSlotPatternGenerator($em, $entity);
            case PatternGeneratorType::PATCH_PANEL:
                return new PatchPanelPatternGenerator($em, $entity);
            case PatternGeneratorType::WIRE:
                return new WirePatternGenerator($em, $entity);
        }
    }
}
