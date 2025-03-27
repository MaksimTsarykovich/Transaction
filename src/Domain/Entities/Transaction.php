<?php


declare(strict_types = 1);

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'transactions')]
class Transaction
{
    #[ORM\Id]
    #[ORM\Column(name: 'id',type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'file_id', type: 'int')]
    private int $file_id;

    #[ORM\Column(name: 'data', type: 'string', length: 55)]
    private string $data;

    #[ORM\Column(name: 'check', type: 'string', length: 55)]
    private string $check;

    #[ORM\Column(name: 'description', type: 'string', length: 255)]
    private string $description;

    #[ORM\Column(name: 'amount', type: 'int')]
    private string $amount;

    #[ORM\Column(name: 'is_positive', type: 'tinyint', length: 1)]
    private string $is_positive;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFileId(): int
    {
        return $this->file_id;
    }

    public function setFileId(int $file_id): void
    {
        $this->file_id = $file_id;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function getCheck(): string
    {
        return $this->check;
    }

    public function setCheck(string $check): void
    {
        $this->check = $check;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): void
    {
        $this->amount = $amount;
    }

    public function getIsPositive(): string
    {
        return $this->is_positive;
    }

    public function setIsPositive(string $is_positive): void
    {
        $this->is_positive = $is_positive;
    }

}