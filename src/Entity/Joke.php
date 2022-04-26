<?php

namespace App\Entity;

use App\Repository\JokeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JokeRepository::class)]
class Joke
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $likes;

    #[ORM\OneToOne(mappedBy: 'joke', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\OneToMany(mappedBy: 'joke', targetEntity: Like::class)]
    private $relationlike;

    public function __construct()
    {
        $this->relationlike = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getJoke() !== $this) {
            $user->setJoke($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getRelationlike(): Collection
    {
        return $this->relationlike;
    }

    public function addRelationlike(Like $relationlike): self
    {
        if (!$this->relationlike->contains($relationlike)) {
            $this->relationlike[] = $relationlike;
            $relationlike->setJoke($this);
        }

        return $this;
    }

    public function removeRelationlike(Like $relationlike): self
    {
        if ($this->relationlike->removeElement($relationlike)) {
            // set the owning side to null (unless already changed)
            if ($relationlike->getJoke() === $this) {
                $relationlike->setJoke(null);
            }
        }

        return $this;
    }
}
