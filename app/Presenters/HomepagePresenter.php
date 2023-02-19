<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {

    }
    public function renderDefault(): void
    {
        $this->template->brands = $this->database
            ->table('brands')
            ->order('name DESC')
            ->limit(20);
    }
}
