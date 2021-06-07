<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProductStatus extends Enum
{
    public const OutOfStock = 0;
    public const InStock = 1;
    public const IsHidden = 2;
    public const AtTheSupplier = 3;
    public const PreOrder = 4;
}
