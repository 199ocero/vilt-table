<?php

namespace JAOcero\LaravelInertiaTable\Table\Contracts;

use JAOcero\LaravelInertiaTable\Table\Table;

interface HasTable
{
    public function table(): Table;
}
