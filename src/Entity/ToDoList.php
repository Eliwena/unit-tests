<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use App\Service\EmailSenderService;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Framework\Exception;

/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="idToDoList", orphanRemoval=true)
     */
    private $Items;

    /*
     * @var App\Service\EmailSenderService
     */
    private $emailSenderService;

    /**
     * @param $emailSenderService
     */
    public function __construct($emailSenderService)
    {
        $this->Items = new ArrayCollection();
        $this->emailSenderService = $emailSenderService;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->Items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->Items->contains($item)) {
            if ($this->Items->count() > 0) {
                $lastItem = $this->Items->last();
                $dateCarbon = Carbon::createFromDate($lastItem->getDateAdd());
                if ($dateCarbon->addMinutes(30)->isBefore(Carbon::now())){
                    $this->Items[] = $item;
                    $item->setIdToDoList($this);
                } else {
                    throw new Exception("Veuillez attendre 30 min avant d'ajouter une nouvelle tâche");
                }
            } else if ($this->Items->count() == 0) {
                $this->Items[] = $item;
                $item->setIdToDoList($this);
            }
            if ($this->Items->count() == 8) {
                $this->emailSenderService->sendEmail();
            }
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->Items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getIdToDoList() === $this) {
                $item->setIdToDoList(null);
            }
        }

        return $this;
    }
}
