<?php

namespace JAOcero\ViltTable\Table\Contracts;

use JAOcero\ViltTable\Table\Table;

interface HasTable
{
    public function table(): Table;
}
