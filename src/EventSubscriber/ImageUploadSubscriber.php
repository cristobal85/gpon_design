<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Impulze\Bundle\InterventionImageBundle\ImageManager;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Event\Event;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Icon;

class ImageUploadSubscriber implements EventSubscriberInterface {

    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var ParameterBagInterface 
     */
    private $params;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param ImageManager $imageManager
     */
    public function __construct(
            ImageManager $imageManager,
            ParameterBagInterface $params,
            EntityManagerInterface $em) {
        $this->imageManager = $imageManager;
        $this->params = $params;
        $this->em = $em;
    }

    public function onVichUploaderPreUpload(Event $event) {
        // Entity that has been updated
        $entity = $event->getObject();
        /** @var PropertyMapping */
        $mapping = $event->getMapping();
        /** @var string */
        $filePath = $mapping->getFile($entity);

        if (exif_imagetype($filePath)) {
            $height = Factory\HeightFactory::make(
                            $entity,
                            $this->params->get('images_max_height')
            );

            $this->imageManager
                    ->make($filePath)
                    ->orientate()
                    ->heighten($height)
                    ->save($filePath);
        }
    }

    public static function getSubscribedEvents() {
        return [
            'vich_uploader.pre_upload' => 'onVichUploaderPreUpload',
        ];
    }

}
