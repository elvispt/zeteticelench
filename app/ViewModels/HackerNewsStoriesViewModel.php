<?php

namespace App\ViewModels;

use App\Actions\AppendDomainAction;
use App\Actions\StoriesBookmarkStatusAction;
use App\Models\HackerNewsItemsBookmark;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class HackerNewsStoriesViewModel extends ViewModel
{
    public const SHOW_MANUAL_BOOKMARK_FORM = 1;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var object
     */
    protected $items;

    /**
     * @var int
     */
    protected $showManualBookmarkForm;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $hnPostUrlFormat;

    /**
     * @var string
     */
    protected $paginationRouteName;

    /**
     * @var int
     */
    protected $perPage;

    public function __construct(
        User $user,
        object $items,
        int $currentPage,
        string $title,
        string $paginationRouteName,
        int $showManualBookmarkForm = 0
    ) {
        $this->user = $user;
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->title = $title;
        $this->paginationRouteName = $paginationRouteName;
        $this->showManualBookmarkForm = $showManualBookmarkForm;
        $this->hnPostUrlFormat = config('hackernews.site_url') . '/item?id=%s';
        $this->perPage = config('hackernews.list_limit');
    }

    public function stories()
    {
        $stories = $this->lengthAwarePaginator(
            $this->currentPage,
            $this->items,
            route($this->paginationRouteName)
        );
        $appendDomainAction = new AppendDomainAction();
        $storiesBookmarkStatusAction = new StoriesBookmarkStatusAction();
        $stories = $appendDomainAction->execute($stories);
        return $storiesBookmarkStatusAction->execute($stories);
    }

    public function nBookmarkedStories(): int
    {
        return HackerNewsItemsBookmark
            ::where('user_id', $this->user->id)
            ->count();
    }

    public function bookmarkStore(): bool
    {
        return $this->showManualBookmarkForm === self::SHOW_MANUAL_BOOKMARK_FORM;
    }

    /**
     * Grabs the story list and creates a pagination object based on the current
     * page, items, and the links to load new pages.
     *
     * @param int $currentPage The current page
     * @param object $items The list of story items
     * @param string $withPath The path to another page
     *
     * @return mixed
     */
    private function lengthAwarePaginator($currentPage, $items, $withPath)
    {
        $stories = new LengthAwarePaginator(
            $items->stories,
            $items->total,
            $this->perPage,
            $currentPage
        );
        $stories->withPath($withPath);
        $stories->onEachSide(1);

        return $stories;
    }
}
