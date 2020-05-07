<?php

namespace App\Models;

use App\Libraries\CommonMark\TableExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use RZ\CommonMark\Ext\Footnote\FootnoteExtension;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Note onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Note withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Note withoutTrashed()
 * @mixin \Eloquent
 */
class Note extends Model
{
    public const WITH_SYNTAX_HIGHLIGHTING = 1;

    use SoftDeletes;

    use Searchable;

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bodyToHtml($withSyntaxHighlight = null): string
    {
        $scoutMetadata = $this->scoutMetadata();
        $body = data_get($scoutMetadata, '_highlightResult.body.value');
        if (!$body) {
            $body = $this->body;
        }

        $environment = null;
        $config = [];
        if ($withSyntaxHighlight === self::WITH_SYNTAX_HIGHLIGHTING) {
            $languagesSupported = [
                'html',
                'php',
                'js',
                'ts',
                'sql',
                'markdown',
                'java',
                'yaml',
                'ini',
            ];
            $environment = Environment::createCommonMarkEnvironment();
            $environment->addExtension(new AutolinkExtension());
            $environment->addExtension(new StrikethroughExtension());
            $environment->addExtension(new TableExtension(['class' => 'table table-hover']));
            $environment->addExtension(new FootnoteExtension());
            $environment->addExtension(new ExternalLinkExtension());
            $environment->addBlockRenderer(
                FencedCode::class,
                new FencedCodeRenderer($languagesSupported)
            );
            $environment->addBlockRenderer(
                IndentedCode::class,
                new IndentedCodeRenderer($languagesSupported)
            );
            // Set your configuration
            $config = [
                'external_link' => [
                    'internal_hosts' => ['159.65.199.206:8080', 'localhost:8080'],
                    'open_in_new_window' => true,
                    'html_class' => 'external-link',
                ],
            ];
        }
        $commonMarkConverter = new CommonMarkConverter($config, $environment);
        return $commonMarkConverter->convertToHtml($body);
    }

    public function extractTitle(): string
    {
        $title = '';
        $output = $this->bodyToHtml();
        $exploded = explode("\n", $output);
        if (is_array($exploded) && count($exploded) > 0) {
            $titleTagged = $exploded[0];
            $title = trim(strip_tags($titleTagged));
        }

        return $title;
    }

    public function extractDescription()
    {
        $description = '';
        $output = $this->bodyToHtml();
        $exploded = explode("\n", $output);
        if (is_array($exploded) && count($exploded) > 0) {
            $descriptionTagged = Arr::get($exploded, 1);
            $description = trim(strip_tags($descriptionTagged));
        }

        return $description;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array = $this->transform($array);
        $array['tags'] = $this->tags
            ->map(fn(Tag $tag): string => $tag->tag)
            ->toArray();

        return $array;
    }

}
