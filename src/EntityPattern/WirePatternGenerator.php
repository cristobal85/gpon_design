<?php

namespace App\EntityPattern;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Wire;
use App\Entity\Tube;
use App\Entity\Fiber;
use App\Entity\WirePattern;
use App\Entity\TubePattern;
use App\Entity\FiberPattern;

/**
 * @author cristobal
 */
class WirePatternGenerator implements PatternGenerator {

    /**
     *
     * @var ObjectManager
     */
    private $em;

    /**
     *
     * @var Wire
     */
    private $wire;

    public function __construct(ObjectManager $em, Wire $wire) {
        $this->em = $em;
        $this->wire = $wire;
    }

    public function generate() {
        $wirePattern = $this->wire->getWirePattern();
        foreach ($wirePattern->getTubePatterns() as $tubePattern) {
            $tube = new Tube();
            $tube->setHexaColor($tubePattern->getHexaColor())
                    ->setName($tubePattern->getName())
                    ->setLayer($tubePattern->getLayer())
                    ->setWire($this->wire);
            $this->em->persist($tube);
            foreach ($wirePattern->getFiberPatterns() as $fiberPattern) {
                $fiber = new Fiber();
                $fiber->setColor($fiberPattern->getName())
                    ->setHexaColor($fiberPattern->getHexaColor())
                    ->setTube($tube);
                $this->em->persist($fiber);
            }
        }
        $this->wire
                ->setHexaColor($wirePattern->getHexaColor())
                ->setWeight($wirePattern->getWeight())
                ->setImage($wirePattern->getImage())
                ->setUpdatedAt(new \DateTime());
    }

}
