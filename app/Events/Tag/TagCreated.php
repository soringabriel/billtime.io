<?php

namespace App\Events\Tag;

use App\Models\Tag;
use Illuminate\Queue\SerializesModels;

/**
 * Class TagCreated.
 */
class TagCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $tag;

    /**
     * @param $Tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
}
