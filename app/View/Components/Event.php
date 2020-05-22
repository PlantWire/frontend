<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Event extends Component
{
    public $event;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
        $this->content = json_decode($event->content);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.event', ['event' => $this->event, 'content', $this->content]);
    }
}
