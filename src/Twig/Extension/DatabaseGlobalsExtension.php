<?php

namespace App\Twig\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class DatabaseGlobalsExtension extends AbstractExtension implements GlobalsInterface
{

   protected $em;

   public function __construct(EntityManagerInterface $em)
   {
      $this->em = $em;
   }

   public function getGlobals()
   {
      return [
          'COMPANY' => $this->em->getRepository(\App\Entity\Company::class)->findOneBy(array(), array('id' => 'ASC'), 1),
          'NOTES'   => $this->em->getRepository(\App\Entity\Note::class)->findBy(['closed' => false], array('id' => 'DESC')),
          'ALERTS'  => $this->em->getRepository(\App\Entity\Alert::class)->findBy(['closed' => false], array('id' => 'DESC')),
      ];
   }
}
