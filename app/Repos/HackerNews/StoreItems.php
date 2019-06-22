<?php

namespace App\Repos\HackerNews;

use App\Models\HackerNewsItem;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreItems
{
    /**
     * A mapping between api field names and table column names
     *
     * @var Collection
     */
    protected $map;

    /**
     * The validation rules for the data received from the hn api
     *
     * @var array
     */
    protected $validationRules;

    protected $changes = [
        'new' => 0,
        'updated' => 0,
        'failed' => 0,
    ];

    public function __construct()
    {
        $this->map = new Collection([
            // apiField => column
            'parent' => 'parent_id',
            'kids' => 'kids',
            'dead' => 'dead',
            'url' => 'url',
            'score' => 'score',
            'title' => 'title',
            'text' => 'text',
        ]);
        $this->validationRules = [
            'id' => ['required', 'integer'],
            'by' => ['sometimes', 'string', 'max:255'],
            'time' => ['integer', 'min:1'],
            'type' => ['required', 'string', Rule::in(ItemType::all())],
            'parent' => ['sometimes', 'integer', 'min:1'],
            'kids' => ['sometimes', 'array'],
            'kids.*' => ['sometimes', 'integer'],
            'dead' => ['sometimes', 'boolean'],
            'url' => ['sometimes', 'url'],
            'score' => ['sometimes', 'integer', 'max:32767', 'min:-32768'],
            'title' => ['sometimes', 'string', 'max:1000'],
            'text' => ['sometimes', 'string', 'max:65000'],
            'descendants' => ['sometimes', 'integer', 'max:65535'],
            'deleted' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Parses and stores the given stories.
     *
     * @param array $stories The stories parsed from the HN API
     * @return int Returns the number of updated/created hn story items.
     */
    public function store($stories): int
    {
        $changed = $this->validate(new Collection($stories))
            ->each(function ($story) {
                $id = $story->id;
                $hackerNewsItem = $this->getOrCreateModel($id, $story);
                $this->setMapProperties($hackerNewsItem, $story);
                $descendants = data_get($story, 'descendants');
                if (! $descendants || $descendants < 0) {
                    $descendants = 0;
                }
                $hackerNewsItem->descendants = $descendants;
                if (property_exists($story, 'deleted')) {
                    $hackerNewsItem->deleted_at = Carbon::now();
                }
                try {
                    $hackerNewsItem->save();
                } catch (Exception $exception) {
                    $this->changes['failed'] += 1;
                    Log::error(
                        "Could not save story to DB",
                        [
                            'exceptionMessage' => $exception->getMessage(),
                            'data' => print_r($story, true),
                        ]
                    );
                }
            })
            ->count();
        $this->changes['updated'] = $changed - $this->changes['new'];

        return $changed;
    }

    /**
     * Returns the number of new, changes, and failed items.
     *
     * @return array
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * Checks if it's an update or a new item and creates a model object
     * accordingly.
     *
     * @param int $id The id of the story
     * @param object $story The story info
     * @return HackerNewsItem Returns the model object
     */
    protected function getOrCreateModel($id, $story): HackerNewsItem
    {
        $hackerNewsItem = HackerNewsItem::withTrashed()
            ->where('id', $id)
            ->first();
        if (is_null($hackerNewsItem)) {
            // new item
            $hackerNewsItem = new HackerNewsItem();
            $hackerNewsItem->id = $id;
            if (property_exists($story, 'by')) {
                $hackerNewsItem->by = $story->by;
            }
            $time = data_get($story, 'time', 1);
            $created_at = Carbon::createFromTimestamp($time ? $time : 1);
            $hackerNewsItem->created_at = $created_at;
            $hackerNewsItem->type = $story->type;
            $this->changes['new'] += 1;
        }

        return $hackerNewsItem;
    }

    /**
     * Using the mapped properties it sets the values from the api to the table
     * column
     *
     * @param HackerNewsItem $hackerNewsItem The model instance that stores the
     *                                       story information. Sent by
     *                                       reference.
     * @param object         $story The object that containst the story info as
     *                              returned from the api
     */
    protected function setMapProperties(HackerNewsItem &$hackerNewsItem, $story)
    {
        $this->map
            ->each(static function ($column, $apiField) use (
                $hackerNewsItem,
                $story
            ) {
                if (property_exists($story, $apiField)) {
                    $hackerNewsItem->{$column} = data_get(
                        $story,
                        $apiField
                    );
                }
            });
    }

    /**
     * The validator object is built here with the provided data and the defined
     * validation rules
     *
     * @param array $data The array of data provided by the api
     * @return \Illuminate\Contracts\Validation\Validator Returns the validator
     *                                                    object.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, $this->validationRules);
    }

    /**
     * Uses a validator instance to validate against defined validation rules
     *
     * @param Collection $collection
     * @return Collection Returns the validated data as a Collection.
     */
    protected function validate(Collection $collection): Collection
    {
        return $collection
            ->map(function ($story) {
                $validator = $this->validator((array) $story);
                if ($validator->fails()) {
                    $errors = [];
                    foreach ($validator->errors()->all() as $error) {
                        $errors[] = $error;
                    }
                    Log::error(
                        "Error when validating story",
                        ['errors' => $errors]
                    );
                    return null;
                }
                return (object) $validator->validated();
            })
            ->filter();
    }
}
