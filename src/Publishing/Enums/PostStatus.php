<?php

declare(strict_types=1);
 
namespace Freziertz\PostPackage\Publishing\Enums;


enum PostStatus: string
{
    case PUBLISHED = 'published';
    case DRAFT = 'draft';
    case QUEUED = 'queued';
}