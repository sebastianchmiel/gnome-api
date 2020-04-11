<?php

namespace App\Controller\Gnome;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GnomeRepository;
use App\Entity\User;
use App\Model\Gnome\RaceType;

/**
 * get only my gnomes
 */
final class GetMyGnomesAction
{
    /**
     * pagination page size
     */
    const PAGE_SIZE = 100;

    /**
     * @var GnomeRepository;
     */
    private $repository;

    /**
     * current logged user
     *
     * @var User
     */
    private $user;

    /**
     * @param GnomeRepository $repository
     * @param Security $security
     */
    public function __construct(GnomeRepository $repository, Security $security)
    {
        $this->repository = $repository;
        $this->user = $security->getUser();
    }

    /**
     * @Route(
     *     name="gnome_getMy",
     *     path="/me",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Gnome::class
     *     }
     * )
     */
    public function __invoke(Request $request, $params = null)
    {
        $raceType = new RaceType();

        $page = intval($request->query->get('page'));
        $race = $raceType->isValid($request->query->get('race')) ? $request->query->get('race') : null;

        $filters = [
            'owner' => $this->user,
        ];
        if ($race) {
            $filters['race'] = $race;
        }

        $items = $this->repository->findBy(
            $filters,
            [],
            self::PAGE_SIZE,
            self::PAGE_SIZE * ($page - 1)
        );

        return $items;
    }
}
