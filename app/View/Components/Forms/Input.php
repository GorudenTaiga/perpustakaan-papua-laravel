<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $type;
    public string $name;
    public string $id;
    public string $label;
    public ?string $icon;
    public ?string $helperText;
    public mixed $value;
    public array $options;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'text',
        string $name = '',
        string $id = '',
        string $label = '',
        ?string $icon = null,
        ?string $helperText = null,
        mixed $value = null,
        array $options = []
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->id = $id ?: $name;
        $this->label = $label;
        $this->icon = $icon;
        $this->helperText = $helperText;
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.input');
    }
}
