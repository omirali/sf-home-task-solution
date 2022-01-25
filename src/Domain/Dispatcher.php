<?php

namespace App\Domain;

class Dispatcher
{
    /**
     * @var array
     */
    private $listeners;

    /**
     * Add a Listener
     *
     * @param string $name
     * @param ListenerInterface $listener
     * @return void
     */
    public function add($name, ListenerInterface $listener)
    {
        $this->listeners[$name][] = $listener;
    }

    public function dispatch($events)
    {
        if (is_array($events)) {
            $this->fireEvents($events);
            return;
        }
        $this->fireEvent($events);
    }

    public function hasListeners($name)
    {
        return isset($this->listeners[$name]);
    }

    public function getListeners($name)
    {
        if ( ! $this->hasListeners($name)) {
            return [];
        }
        return $this->listeners[$name];
    }

    public function getAnyListeners($name)
    {
        return $this->getListeners($name);
    }

    private function fireEvents(array $events)
    {
        foreach ($events as $event) {
            $this->fireEvent($event);
        }
    }

    private function fireEvent(EventInterface $event)
    {
        foreach ($this->getAnyListeners($event->name()) as $listener) {
            $listener->handle($event);
        }
    }
}