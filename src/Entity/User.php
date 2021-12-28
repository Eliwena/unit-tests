<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\OneToOne(targetEntity=ToDoList::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idToDoList;

    /*
     * @var App\Controller\ExternalAPIs
     */
    private $externalAPIs;

    /**
     * @param $firstname
     * @param $lastname
     * @param $email
     * @param $password
     * @param $birthdate
     * @param $externalAPIs
     */
    public function __construct($email, $firstname, $lastname, $password, $birthdate, $externalAPIs)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->birthdate = $birthdate;
        $this->externalAPIs = $externalAPIs;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthdate(): ?DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getIdToDoList(): ?ToDoList
    {
        return $this->idToDoList;
    }

    public function setIdToDoList(ToDoList $idToDoList): self
    {
        $this->idToDoList = $idToDoList;

        return $this;
    }

    public function IsValid(): Bool
    {
        if ($this->externalAPIs->checkEmail($this->getEmail())
            && !empty($this->lastname)
            && !empty($this->firstname)
            && $this->birthdate->addYears(13)->isBefore(Carbon::now())
            && (strlen($this->password) >= 8 && strlen($this->password) <= 40)) {
            return true;
        } else {
            return false;
        }
    }
}
