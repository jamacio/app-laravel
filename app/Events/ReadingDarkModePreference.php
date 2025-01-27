<?php

namespace App\Events;

use App\Http\Controllers\DarkModeController;

class ReadingDarkModePreference
{
    /**
     * An instance of the dark mode controller.
     *
     * @var DarkModeController
     */
    public $darkMode;

    /**
     * Create a new event instance.
     *
     * @param  DarkModeController  $ctrl
     */
    public function __construct(DarkModeController $ctrl)
    {
        $this->darkMode = $ctrl;
    }
}
