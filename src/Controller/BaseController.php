<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class BaseController extends AbstractController {
    
    use HandleTrait;
    
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    
    /**
     * @param object
     *
     * @return mixed
     */
    protected function handleMessage(object $message)
    {
        return $this->handle($message);
    }
}
