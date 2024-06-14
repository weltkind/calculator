<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestHandler
{
    private $serializer;
    private $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function handleRequest(Request $request, string $type)
    {
        $data = $this->serializer->deserialize($request->getContent(), $type, 'json');
        $errors = $this->validator->validate($data);
        if (count($errors) > 0) {
            throw new BadRequestHttpException((string) $errors);
        }

        return $data;
    }
}