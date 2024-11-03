<?php

namespace App\Core\Domain\Enums;

enum ProductStatus: string
{
    case PUBLISHED = 'published';
    case TRASH = 'trash';
    case DRAFT = 'draft';
}
