<?php


namespace App\Model;


class User extends Model
{
    private ?int $id;
    private ?string $email;
    private ?string $tel;

    /**
     * User constructor.
     * @param int|null $id
     * @param string|null $email
     * @param string|null $tel
     */
    public function __construct(?int $id = null, ?string $email = null, ?string $tel = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->tel = $tel;
    }


    /**
     * @return string|null
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @param string|null $tel
     */
    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }


    static function getTable(): string
    {
        return 'users';
    }

}