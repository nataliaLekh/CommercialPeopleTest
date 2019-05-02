<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("leagues")
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 */
class League implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="league", orphanRemoval=true, cascade={"persist"})
     */
    private $teams;

    /**
     * League constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->teams = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Collection
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    /**
     * @param Team $team
     */
    public function addTeam(Team $team)
    {
        $this->teams->add($team);
    }

    /**
     * @return array
     */
    public function prepareResponse(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
