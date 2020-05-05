<?php

namespace App\Libraries\CommonMark;

use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Extension\Table\TableCell;
use League\CommonMark\Extension\Table\TableCellRenderer;
use League\CommonMark\Extension\Table\TableParser;
use League\CommonMark\Extension\Table\TableRow;
use League\CommonMark\Extension\Table\TableRowRenderer;
use League\CommonMark\Extension\Table\TableSection;
use League\CommonMark\Extension\Table\TableSectionRenderer;

class TableExtension implements ExtensionInterface
{
    protected array $attrs;

    public function __construct(array $attrs = [])
    {
        $this->attrs = $attrs;
    }

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockParser(new TableParser())

            ->addBlockRenderer(Table::class, new TableRenderer($this->attrs))
            ->addBlockRenderer(TableSection::class, new TableSectionRenderer())
            ->addBlockRenderer(TableRow::class, new TableRowRenderer())
            ->addBlockRenderer(TableCell::class, new TableCellRenderer())
        ;
    }
}
