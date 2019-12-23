<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Edfa;
use App\Entity\EdfaSlot;
use App\Entity\EdfaPort;

/**
 * @author cristobal
 */
class EdfaPatternGenerator implements PatternGenerator {

    /**
     * @var ObjectManager
     */
    private $em;
    
    /**
     * @var Edfa
     */
    private $edfa;

    public function __construct(ObjectManager $em, Edfa $edfa) {
        $this->em = $em;
        $this->edfa = $edfa;
    }

    public function generate() {
        foreach ($this->edfa->getEdfaSlotTypes() as $edfaSlotType) {
            $edfaSlot = new EdfaSlot();
            $edfaSlot->setType($edfaSlotType);
            $edfaSlot->setEdfa($this->edfa);
            $this->em->persist($edfaSlot);
            $edfaPortNum = $this->edfa->getEdfaPortNum();
            for ($i = $edfaPortNum['first']; $i <=$edfaPortNum['last']; $i++ ) {
                $edfaPort = new EdfaPort();
                $edfaPort->setNumber($i)->setEdfaSlot($edfaSlot);
                $this->em->persist($edfaPort);
            }
        }
    }

}
