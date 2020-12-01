<?php

namespace App\Services;

use App\Events\Tag\TagCreated;
use App\Events\Tag\TagDeleted;
use App\Events\Tag\TagUpdated;
use App\Models\Tag;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TagService.
 */
class TagService extends BaseService
{
    /**
     * TagService constructor.
     *
     * @param  Tag  $tag
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * @param  array  $data
     *
     * @return Tag
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Tag
    {
        DB::beginTransaction();

        try {
            $tag = $this->model::create(
                [
                    'name' => $data['name'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Tag.'));
        }

        event(new TagCreated($tag));

        DB::commit();

        return $tag;
    }

    /**
     * @param  Tag  $tag
     * @param  array  $data
     *
     * @return Tag
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Tag $tag, array $data = []): Tag
    {
        DB::beginTransaction();

        try {
            $tag->update(
                [
                    'name' => $data['name'],
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Tag.'));
        }

        event(new TagUpdated($tag));

        DB::commit();

        return $tag;
    }

    /**
     * @param  Tag  $tag
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Tag $tag): bool
    {
        if ($this->deleteById($tag->id)) {
            event(new TagDeleted($tag));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Tag.'));
    }
}