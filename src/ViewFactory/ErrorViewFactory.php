<?php

declare(strict_types=1);

namespace App\ViewFactory;

use App\View\ErrorView;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ErrorViewFactory
{
    public function createFromHttpException(HttpException $exception): ErrorView
    {
        $view = new ErrorView();

        $view->setCode($exception->getStatusCode());
        $view->setMessage($exception->getMessage());

        return $view;
    }

    public function createFromThrowable(\Throwable $exception): ErrorView {
        if ($exception instanceof HttpException) {
            return $this->createFromHttpException($exception);
        }

        $view = new ErrorView();

        $view->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        $view->setMessage(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);

        return $view;
    }
}