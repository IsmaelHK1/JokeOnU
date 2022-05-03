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

    #[ORM\Column(type: 'integer', nullable: true)]
    private $likes;

    #[ORM\OneToOne(mappedBy: 'joke', targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\OneToMany(mappedBy: 'joke', targetEntity: Like::class)]
    private $like_relation;

    #[ORM\Column(type: 'integer')]
    private $key_api;

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function __construct()
    {
        $this->like_relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
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
    public function getLikeRelation(): Collection
    {
        return $this->like_relation;
    }

    public function addLikeRelation(Like $likeRelation): self
    {
        if (!$this->like_relation->contains($likeRelation)) {
            $this->like_relation[] = $likeRelation;
            $likeRelation->setJoke($this);
        }

        return $this;
    }

    public function removeLikeRelation(Like $likeRelation): self
    {
        if ($this->like_relation->removeElement($likeRelation)) {
            // set the owning side to null (unless already changed)
            if ($likeRelation->getJoke() === $this) {
                $likeRelation->setJoke(null);
            }
        }

        return $this;
    }

    public function getKeyApi(): ?int
    {
        return $this->key_api;
    }

    public function setKeyApi(int $key_api): self
    {
        $this->key_api = $key_api;

        return $this;
    }
}
