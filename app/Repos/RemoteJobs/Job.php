<?php

namespace App\Repos\RemoteJobs;

use Illuminate\Support\Carbon;

class Job
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $howToApply;

    /**
     * @var string
     */
    public $url;

    /**
     * @var Carbon
     */
    public $time;

    /**
     * @var string
     */
    public $source;

    /**
     * @var string
     */
    public $companyUrl;
}
