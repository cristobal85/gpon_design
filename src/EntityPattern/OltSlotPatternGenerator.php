<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\OltSlot;
use App\Entity\OltPort;


/**
 * @author cristobal
 */
class OltSlotPatternGenerator implements PatternGenerator {

    /**
     * @var ObjectManager
     */
    private $em;
    
    /**
     * @var OltSlot
     */
    private $oltSlot;
    

    public function __construct(ObjectManager $em, OltSlot $oltSlot) {
        $this->em = $em;
        $this->oltSlot = $oltSlot;
    }

    public function generate() {
        $oltPortNum = $this->oltSlot->getOltPortNum();
        $oltSlotNumber = (string)$this->oltSlot->getNumber();
        for ($i = $oltPortNum['first']; $i <= $oltPortNum['last']; $i++ ) {
            $oltPort = new OltPort();
            $oltPort->setOltSlot($this->oltSlot)->setNumber($i)->setName($oltSlotNumber. '.'. $i);
            $this->em->persist($oltPort);
        }
    }

}
