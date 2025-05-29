<?php

namespace App\Traits;

trait MessageTrait
{
    public function setSuccessMessage($message): void
    {
        session()->flash('message', $message);
        session()->flash('type', 'success');
    }

    public function setErrorMessage($message): void
    {
        session()->flash('message', $message);
        session()->flash('type', 'danger');
    }
}
