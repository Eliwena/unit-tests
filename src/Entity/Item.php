<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $date_add;

    /**
     * @ORM\ManyToOne(targetEntity=ToDoList::class, inversedBy="Items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idToDoList;

    /**
     * @param $name
     * @param $content
     * @param $date_add
     */
    public function __construct($name, $content, $date_add)
    {
        $this->name = $name;
        $this->content = $content;
        $this->date_add = $date_add;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateAdd(): ?DateTime
    {
        return $this->date_add;
    }

    public function setDateAdd(DateTime $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getIdToDoList(): ?ToDoList
    {
        return $this->idToDoList;
    }

    public function setIdToDoList(?ToDoList $idToDoList): self
    {
        $this->idToDoList = $idToDoList;

        return $this;
    }

    public function IsValid(): Bool
    {
        if (!empty($this->name)
            && !empty($this->content)
            && strlen($this->content) <= 1000
            && !empty($this->date_add)) {
            return true;
        } else {
            return false;
        }
    }
}
