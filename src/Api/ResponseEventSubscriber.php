<?php

declare(strict_types=1);

namespace App\Api;

use App\ViewFactory\ErrorViewFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class ResponseEventSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    private ErrorViewFactory $errorViewFactory;

    public function __construct(SerializerInterface $serializer, ErrorViewFactory $errorViewFactory)
    {
        $this->serializer = $serializer;
        $this->errorViewFactory = $errorViewFactory;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ViewEvent::class => ['serializeResponse'],
            ExceptionEvent::class => ['serializeExceptionResponse'],
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
            $event->setResponse(JsonResponse::fromJsonString(
                $this->serializer->serialize($result->getData(), JsonEncoder::FORMAT),
                $result->getStatusCode(),
                $result->getHeaders()
            ));

            return;
        }

        $event->setResponse(JsonResponse::fromJsonString($this->serializer->serialize($result, JsonEncoder::FORMAT)));
    }

    public function serializeExceptionResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $view = $this->errorViewFactory->createFromThrowable($exception);

        $event->setResponse(JsonResponse::fromJsonString(
            $this->serializer->serialize($view, JsonEncoder::FORMAT),
            $exception instanceof HttpException ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR,
            $exception instanceof HttpException ? $exception->getHeaders() : []
        ));
    }
}