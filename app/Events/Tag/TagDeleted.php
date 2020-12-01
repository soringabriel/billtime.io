<?php

namespace App\Events\Tag;

use App\Models\Tag;
use Illuminate\Queue\SerializesModels;

/**
 * Class TagDeleted.
 */
class TagDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $tag;

    /**
     * @param $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
}
