<?php

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author cristobal
 */
class CircularSerializer {

    /**
     * @var SerializerInterface 
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    /**
     * 
     * @param mixed $data
     * @param string $group
     * @param string $format
     * @return string
     */
    public function serialize($data, array $groups, string $format = 'json'): string {
        return $this->serializer->serialize($data, $format, [
                    'circular_reference_handler' => function ($object) {
//                        return $object->getId();
                        return null;
                    },
                    'groups' => $groups,
        ]);
    }

}
