<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Nodo;
use App\Entity\DistributionBox;
use App\Entity\SubscriberBox;


/**
 * @author cristobal
 */
class NodoPatternGenerator implements PatternGenerator {

    /**
     *
     * @var ObjectManager
     */
    private $em;
    
    /**
     *
     * @var Nodo
     */
    private $nodo;
    
    public function __construct(ObjectManager $em, Nodo $nodo) {
        $this->em = $em;
        $this->nodo = $nodo;
    }


    public function generate() {
        foreach ($this->nodo::ID_DISTIRUBTION_BOX as $distBoxId) {
            $distributionBox = new DistributionBox();
            $distributionBox->setNodo($this->nodo)->setName($this->nodo. $distBoxId);
            $this->em->persist($distributionBox);
            foreach ($this->nodo::ID_SUBSCRIBER_BOX as $subsBoxId) {
                $subscriberBox = new SubscriberBox();
                $subscriberBox->setDistributionBox($distributionBox)->setName($distributionBox.$subsBoxId)->setLatitude(0)->setLongitude(0);
                $this->em->persist($subscriberBox);
            }
        }
    }

}
