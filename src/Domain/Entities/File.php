<?php

declare(strict_types = 1);

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'files')]
class File
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private  int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'size', type: 'integer')]
    private string $size;

    #[ORM\Column(name: 'type', type: 'string', length: 100)]
    private string $type;

    #[ORM\Column(name: 'path', type: 'string', length: 255)]
    private string $path;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): File
    {
        $this->name = $name;
        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): File
    {
        $this->size = $size;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): File
    {
        $this->type = $type;
        return $this;

    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): File
    {
        $this->path = $path;
        return $this;

    }

}