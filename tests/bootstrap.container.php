<?php declare(strict_types = 1);

use App\Bootstrap;

require_once __DIR__ . '/bootstrap.php';

return Bootstrap::boot()->createContainer();
