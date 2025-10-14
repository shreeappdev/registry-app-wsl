<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BaseComponent extends Component
{
    /**
     * Automatically select layout based on auth state
     */
    protected function getLayout(): string
    {
        return Auth::check() ? 'layouts.backend' : 'layouts.frontend';
    }

    /**
     * Render view with automatic layout
     */
    protected function renderView(string $view, array $data = [])
    {
        return view($view, $data)
               ->layout($this->getLayout());
    }
}
