<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Exception\ResourceNotFoundException;
use AppBundle\Exception\ResourceUniqueConstraintValidationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return
            [
                KernelEvents::EXCEPTION => [
                    ['identifyException']
                ],
            ];
    }

    public function identifyException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof NotFoundHttpException) {

            if ($event->getRequest()->attributes->get('id')) {

                $message = sprintf("Resource '%s' not found", $event->getRequest()->attributes->get('id'));
                throw new ResourceNotFoundException($message);
            }

            throw new ResourceNotFoundException("Not found URI.");

        } elseif ($event->getException() instanceof UniqueConstraintViolationException) {

            $message = $event->getException()->getPrevious()->getMessage();

            throw new ResourceUniqueConstraintValidationException($message, 409);
        }
    }
}