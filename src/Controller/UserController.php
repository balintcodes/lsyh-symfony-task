<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/api/user', name: 'api_user_')]
class UserController extends AbstractController
{
    #[Route(path: '/{id}', name: 'index', methods: ['GET'])]
    public function index(
        Request                $request,
        EntityManagerInterface $entityManager,
        SerializerInterface    $serializer,
        int|null               $id = null,
    ): Response
    {
        if ($id) {
            $result = $entityManager->getRepository(User::class)->find($id);
        } else {
            $result = $entityManager->getRepository(User::class)->findAll();
        }

        $format = strtolower($request->query->get('format', 'json'));
        if (!in_array($format, ['json', 'yaml'], true)) {
            $format = 'json';
        }

        $data = $serializer->serialize($result ?? [], $format);

        return (new Response(
            $data,
            $result ? 200 : 404,
            ['Content-Type' => $format === 'json' ? 'application/json' : 'application/x-yaml']
        ));
    }

    #[Route(path: '', name: 'store', methods: ['POST'])]
    public function store(
        #[MapRequestPayload] UserDto $userDto,
        ValidatorInterface           $validator,
        EntityManagerInterface       $entityManager,
    ): Response
    {
        $user = (new User());
        $user->setFirstName($userDto->firstName);
        $user->setLastName($userDto->lastName);
        $user->setPassword(
            password_hash($userDto->password, PASSWORD_DEFAULT)
        );
        $user->setEmailAddress($userDto->emailAddress);

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(
                $errors,
                400
            );
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(
            $user,
            201
        );
    }
}
