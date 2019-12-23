<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\PatchPanel;
use App\Entity\PatchPanelSlot;
use App\Entity\PatchPanelSlotConector;

/**
 * @author cristobal
 */
class PatchPanelPatternGenerator implements PatternGenerator {

    /**
     * @var ObjectManager
     */
    private $em;
    
    /**
     * @var PatchPanel
     */
    private $patchPanel;
    

    public function __construct(ObjectManager $em, PatchPanel $patchPanel) {
        $this->em = $em;
        $this->patchPanel = $patchPanel;
    }

    public function generate() {
        $patchSlotNum = $this->patchPanel->getPatchSlotNums();
        for ($i = $patchSlotNum['first']; $i <= $patchSlotNum['last']; $i++) {
            $patchPanelSlot = new PatchPanelSlot();
            $patchPanelSlot->setPatchPanel($this->patchPanel)->setNumber($i);
            $this->em->persist($patchPanelSlot);
            $patchPortNum = $this->patchPanel->getPatchPortNums();
            for ($j = $patchPortNum['first']; $j <= $patchPortNum['last']; $j++ ) {
                $patchPanelSlotConector = new PatchPanelSlotConector();
                $patchPanelSlotConector->setPatchPanelSlot($patchPanelSlot)->setNumber($j);
                $this->em->persist($patchPanelSlotConector);
            }
        }
    }

}
