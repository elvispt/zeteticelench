<?php

namespace App\View\Composers;

use App\Libraries\Inspire\Inspire;
use Illuminate\View\View;

class InspireComposer
{
    public function compose(View $view)
    {
        $inspire = new Inspire();

        $__inspire = $inspire->adviceSlip();
        $view->with('__inspire', $__inspire);
    }
}
