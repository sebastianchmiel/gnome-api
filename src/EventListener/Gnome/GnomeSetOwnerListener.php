<?php

namespace App\EventListener\Gnome;

use Symfony\Component\Security\Core\Security;
use App\Entity\Gnome;

/**
 * set owner for gnome listener
 * 
 * @author Sebastian Chmiel <s.chmiel2@gmail.com>
 */
final class GnomeSetOwnerListener
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * pre persist - set owner
     *
     * @param Gnome $gnome
     * 
     * @return void
     */
    public function prePersist(Gnome $gnome): void
    {
        if ($gnome->getOwner()) {
            return;
        }

        if ($this->security->getUser()) {
            $gnome->setOwner($this->security->getUser());
        }
    }
}