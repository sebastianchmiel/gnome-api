<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\{ApiResource, ApiProperty, ApiFilter};
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Validator\Gnome\IsValidStrength;
use App\Entity\User;
use App\Controller\Gnome\GetMyGnomesAction;

/**
 * A Gnome
 *
 * @ORM\Entity(repositoryClass="App\Repository\GnomeRepository")
 * @ORM\EntityListeners({"App\EventListener\Gnome\GnomeSetOwnerListener"})
 * 
 * @ApiResource(
 *      attributes={
 *          "pagination_items_per_page"=100,
 *          "security"="is_granted('ROLE_API')"
 *      },
 *      normalizationContext={
 *           "groups"={"gnome"}
 *      },
 *      collectionOperations={
 *          "get",
 *          "post",
 *          "getMy"={
 *              "method"="GET",
 *              "path"="/gnomes/my",
 *              "controller"=GetMyGnomesAction::class,
 *          }
 *      },
 *      itemOperations={
 *          "get"={"security"="object.owner == user", "security_message"="Sorry, but you are not the gnome owner."},
 *          "patch"={"security_post_denormalize"="object.owner == user", "security_post_denormalize_message"="Sorry, but you are not the actual gnome owner."},
 *          "delete"={"security_post_denormalize"="object.owner == user", "security_post_denormalize_message"="Sorry, but you are not the actual gnome owner."},
 *      } 
 * )
 * @ApiFilter(SearchFilter::class, properties={"race": "exact"})
 */
class Gnome
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"gnome"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups({"gnome"})
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @var int
     *
     * @ORM\Column(type="tinyint", nullable=false, options={"unsigned"=true})
     * @Groups({"gnome"})
     * @IsValidStrength()
     */
    public $strength;

    /**
     * @var int
     *
     * @ORM\Column(type="tinyint", nullable=false, options={"unsigned"=true})
     * @Groups({"gnome"})
     * @Assert\Range(min=0, max=100)
     */
    public $age;

    /**
     * @var string
     *
     * @ORM\Column(type="RaceType", nullable=false)
     * @Groups({"gnome"})
     * @Assert\Choice({"rock", "forest", "river", "fire", "sky"})
     */
    public $race;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"gnome"})
     * @ApiProperty(iri="http://schema.org/image")
     */
    public $avatar;

    /**
     * @var User The owner
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Groups({"gnome"})
     */
    public $owner;

    /**
     * get id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * set name
     *
     * @param string $name
     * 
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * get strength
     *
     * @return int|null
     */
    public function getStrength(): ?int
    {
        return $this->strength;
    }

    /**
     * set strength
     *
     * @param int $strength
     * 
     * @return self
     */
    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * get age
     *
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * set age
     *
     * @param int $age
     * 
     * @return self
     */
    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * get race
     *
     * @return string|null
     */
    public function getRace(): ?string
    {
        return $this->race;
    }

    /**
     * set race
     *
     * @param string $race
     * 
     * @return self
     */
    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    /**
     * get avatar
     *
     * @return MediaObject|null
     */
    public function getAvatar(): ?MediaObject
    {
        return $this->avatar;
    }

    /**
     * set avatar
     *
     * @param MediaObject|null $avatar
     * 
     * @return self
     */
    public function setAvatar(?MediaObject $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * get owner
     *
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * set owner
     *
     * @param User|null $owner
     * 
     * @return self
     */
    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
