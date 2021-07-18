<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseEventSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ViewEvent::class => ['serializeResponse'],
        ];
    }

    public function serializeResponse(ViewEvent $event): void
    {
        $result = $event->getControllerResult();

        if ($result instanceof Response) {
            return;
        }

        if ($result === null) {
            $event->setResponse(new Response('', Response::HTTP_NO_CONTENT));

            return;
        }

        if ($result instanceof View) {
            $event->setResponse(JsonResponse::fromJsonString($this->serializer->serialize($result->getData(), JsonEncoder::FORMAT), $result->getStatusCode(), $result->getHeaders()));

            return;
        }

        $event->setResponse(JsonResponse::fromJsonString($this->serializer->serialize($result, JsonEncoder::FORMAT)));
    }
}