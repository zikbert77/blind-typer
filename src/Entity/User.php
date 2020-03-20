<?php

namespace App\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    const ROLE_ADMIN = 0;
    const ROLE_USER = 1;

    const IS_NOT_PREMIUM = 0;
    const IS_PREMIUM = 1;

    private $id;

    private $email;

    private $plainPassword;

    private $password;

    private $roles;

    private $isPremium;

    private $subscriptionExpireDateTime;

    private $defaultKeyboard;

    private $interfaceLanguage;

    private $defaultLanguage;

    private $createdAt;

    private $updatedAt;

    private $roleTitle = [
        self::ROLE_ADMIN => 'ROLE_ADMIN',
        self::ROLE_USER => 'ROLE_USER',
    ];

    private $subscriptionStatus;

    public function __construct()
    {
        $this->roles = self::ROLE_USER;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getRoles(): ?array
    {
        return [$this->roleTitle[$this->roles]] ?? null;
    }

    public function setRoles(?int $role): self
    {
        $this->roles = $role;

        return $this;
    }

    public function getIsPremium(): ?bool
    {
        return $this->isPremium;
    }

    public function setIsPremium(?bool $isPremium): self
    {
        $this->isPremium = $isPremium;

        return $this;
    }

    public function getDefaultKeyboard(): ?int
    {
        return $this->defaultKeyboard;
    }

    public function setDefaultKeyboard(?int $defaultKeyboard): self
    {
        $this->defaultKeyboard = $defaultKeyboard;

        return $this;
    }

    public function getDefaultLanguage(): ?Languages
    {
        return $this->defaultLanguage;
    }

    public function setDefaultLanguage(?Languages $defaultLanguage): self
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getSubscriptionExpireDateTime(): ?\DateTimeInterface
    {
        return $this->subscriptionExpireDateTime;
    }

    public function setSubscriptionExpireDateTime(?\DateTimeInterface $subscriptionExpireDateTime): self
    {
        $this->subscriptionExpireDateTime = $subscriptionExpireDateTime;

        return $this;
    }

    public function getSubscriptionStatus(): ?bool
    {
        return $this->subscriptionStatus;
    }

    public function setSubscriptionStatus(?bool $subscriptionStatus): self
    {
        $this->subscriptionStatus = $subscriptionStatus;

        return $this;
    }

    public function getInterfaceLanguage(): ?Languages
    {
        return $this->interfaceLanguage;
    }

    public function setInterfaceLanguage(?Languages $interfaceLanguage): self
    {
        $this->interfaceLanguage = $interfaceLanguage;

        return $this;
    }
}
