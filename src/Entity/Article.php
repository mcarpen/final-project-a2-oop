<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $author;

    const STATUS_PUBLISHED   = 0;
    const STATUS_UNPUBLISHED = 1;
    const STATUS_DRAFT       = 2;
    const MAX_PER_PAGE       = 50;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Article
     *
     * @throws \Exception
     */
    public function setId(int $id): Article
    {
        // Throwable
        // -> Error
        // -> Exception
        if ($id < 1) {
            throw new \Exception("Invalid value, id must be >= 1");
        }

        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Article
     *
     * @throws \Exception
     */
    public function setName(string $name): Article
    {
        if (empty($name)) {
            throw new \Exception("Article name cannot be empty.");
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Article
     */
    public function setContent(string $content): Article
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Article
     *
     * @throws \Exception
     */
    public function setStatus(int $status): Article
    {
        if (!in_array($status, self::getStatuses())) {
            throw new \Exception("Status value not valid");
        }

        $this->status = $status;

        return $this;
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_UNPUBLISHED,
            self::STATUS_PUBLISHED,
        ];
    }

    /**
     * @return User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return Article
     */
    public function setAuthor(User $author): Article
    {
        $this->author = $author;

        return $this;
    }
}