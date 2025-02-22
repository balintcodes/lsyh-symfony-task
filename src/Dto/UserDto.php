<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class UserDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $lastName,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $password,
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[Assert\Email]
        public string $emailAddress
    )
    {
        //
    }
}