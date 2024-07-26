<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlertResponse extends Component
{
    public ?bool $success   = null;
    public ?string $title   = null;
    public ?string $message = null;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (session()->has('success') && session()->has('message')) {
            $this->success = session('success');
            $this->message = session('message');
            $this->title   = true === $this->success ? __('Berhasil') : __('Gagal');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        return view('components.alert-response');
    }
}
