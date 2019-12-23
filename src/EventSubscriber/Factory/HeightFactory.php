<?php

namespace App\EventSubscriber\Factory;

/**
 * @author cristobal
 */
class HeightFactory {
    
    /**
     * 
     * @param Doctrine\ORM\Mapping\Entity $entity
     * @param int $defaultHeight
     * @return int
     */
    public static function make($entity, int $defaultHeight) : int {
        $height = $defaultHeight;
        if (get_class($entity) === \App\Entity\Icon::class) {
            $height = $entity->getHeight();
        }
        if (in_array(\App\Entity\Interfaces\EntityIconable::class, class_implements($entity)) ) {
            $height = $this->em->getRepository(Icon::class)->findOneBy([
                    'element' => get_class($entity)
                ])->getHeight();
        }
        
        return $height;
    }
}
