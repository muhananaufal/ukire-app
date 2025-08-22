<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OrderStatus extends Component
{
    /**
     * The status of the order.
     *
     * @var string
     */
    public string $status;

    /**
     * The background color class for the status badge.
     *
     * @var string
     */
    public string $bgColor;

    /**
     * The text color class for the status badge.
     *
     * @var string
     */
    public string $textColor;

    /**
     * Create a new component instance.
     *
     * @param  string  $status
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status; // <-- Kita definisikan secara eksplisit

        match ($this->status) {
            'unpaid' => [$this->bgColor, $this->textColor] = ['bg-yellow-100', 'text-yellow-800'],
            'processing' => [$this->bgColor, $this->textColor] = ['bg-blue-100', 'text-blue-800'],
            'shipped' => [$this->bgColor, $this->textColor] = ['bg-indigo-100', 'text-indigo-800'],
            'completed' => [$this->bgColor, $this->textColor] = ['bg-green-100', 'text-green-800'],
            'cancelled' => [$this->bgColor, $this->textColor] = ['bg-red-100', 'text-red-800'],
            default => [$this->bgColor, $this->textColor] = ['bg-gray-100', 'text-gray-800'],
        };
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.order-status');
    }
}
