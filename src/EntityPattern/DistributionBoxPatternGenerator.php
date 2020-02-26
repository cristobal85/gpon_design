<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\DistributionBox;


/**
 * @author cristobal
 */
class DistributionBoxPatternGenerator implements PatternGenerator {

    /**
     *
     * @var ObjectManager
     */
    private $em;

    /**
     *
     * @var DistributionBox
     */
    private $dsBox;

    public function __construct(ObjectManager $em, DistributionBox $dsBox) {
        $this->em = $em;
        $this->dsBox = $dsBox;
    }

    public function generate() {
        for ($i = 1; $i <= DistributionBox::PORTS; $i++) {
            $port = new \App\Entity\DistributionBoxPort();
            $port->setNumber($i);
            $port->setDistributionBox($this->dsBox);
            $this->em->persist($port);
        }
    }

}