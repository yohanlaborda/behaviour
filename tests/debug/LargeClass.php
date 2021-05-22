<?php

namespace yohanlaborda\behaviour\Tests\debug;

class LargeClass
{
    private ?int $id;
    private ?string $name;
    private ?string $telephone;
    private ?string $email;
    private ?string $username;
    private ?string $address;
    private ?string $city;
    private ?string $country;
    private ?string $fatherName;
    private ?string $fatherTelephone;
    private ?string $motherName;
    private ?string $motherTelephone;
    private ?bool $isTest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(?string $fatherName): void
    {
        $this->fatherName = $fatherName;
    }

    public function getFatherTelephone(): ?string
    {
        return $this->fatherTelephone;
    }

    public function setFatherTelephone(?string $fatherTelephone): void
    {
        $this->fatherTelephone = $fatherTelephone;
    }

    public function getMotherName(): ?string
    {
        return $this->motherName;
    }

    public function setMotherName(?string $motherName): void
    {
        $this->motherName = $motherName;
    }

    public function getMotherTelephone(): ?string
    {
        return $this->motherTelephone;
    }

    public function setMotherTelephone(?string $motherTelephone): void
    {
        $this->motherTelephone = $motherTelephone;
    }

    public function getIsTest(): ?bool
    {
        return $this->isTest;
    }

    public function setIsTest(?bool $isTest): void
    {
        $this->isTest = $isTest;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'username' => $this->username,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'father_name' => $this->fatherName,
            'father_telephone' => $this->fatherTelephone,
            'mother_name' => $this->motherName,
            'mother_telephone' => $this->motherTelephone,
            'is_test' => $this->isTest
        ];
    }

    public function toString(): string
    {
        return implode('-', [
            'id' => $this->id,
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'username' => $this->username,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'father_name' => $this->fatherName,
            'father_telephone' => $this->fatherTelephone,
            'mother_name' => $this->motherName,
            'mother_telephone' => $this->motherTelephone,
            'is_test' => $this->isTest
        ]);
    }

    public function toJson(): string
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'username' => $this->username,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'father_name' => $this->fatherName,
            'father_telephone' => $this->fatherTelephone,
            'mother_name' => $this->motherName,
            'mother_telephone' => $this->motherTelephone,
            'is_test' => $this->isTest
        ], JSON_THROW_ON_ERROR);
    }
}
