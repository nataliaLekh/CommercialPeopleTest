<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("teams")
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team implements EntityInterface
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
     * @ORM\Column(type="string", length=255)
     */
    private $strip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="teams", cascade={"persist"})
     */
    private $league;

    /**
     * Team constructor.
     *
     * @param string $name
     * @param string $strip
     * @param League|null $league
     */
    public function __construct(string $name, string $strip, League $league)
    {
        $this->name = $name;
        $this->strip = $strip;
        $this->league = $league;
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
     * @return string
     */
    public function strip(): string
    {
        return $this->strip;
    }

    /**
     * @param League $league
     */
    public function updateLeague(League $league)
    {
        $this->league = $league;
    }

    /**
     * @param string $name
     */
    public function rename(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $strip
     */
    public function changeStrip(string $strip)
    {
        $this->strip = $strip;
    }

    /**
     * @return array
     */
    public function prepareResponse(): array
    {
        return [
            'name' => $this->name,
            'strip' => $this->strip,
            'league' => $this->league->name()
        ];
    }
}
