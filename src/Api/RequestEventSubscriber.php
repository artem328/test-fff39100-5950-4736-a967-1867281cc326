<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class RequestEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => ['parseRequest']
        ];
    }

    public function parseRequest(RequestEvent $event): void {
        $request = $event->getRequest();

        if ('json' !== $request->getContentType()) {
            return;
        }

        try {
            $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new BadRequestHttpException('Failed to parse JSON body', $e);
        }

        $request->request->replace($data);
    }
}