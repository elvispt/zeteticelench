<?php

namespace App\Libraries\CommonMark;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\HtmlElement;

class TableRenderer implements BlockRendererInterface
{
    protected array $attrs;

    public function __construct(array $attrs = [])
    {
        $this->attrs = $attrs;
    }

    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!$block instanceof Table) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $attrs = $block->getData('attributes', []);
        $attrs = array_merge($attrs, $this->attrs);

        $separator = $htmlRenderer->getOption('inner_separator', "\n");

        $children = $htmlRenderer->renderBlocks($block->children());

        return new HtmlElement('table', $attrs, $separator . \trim($children) . $separator);
    }
}
