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
            ->order('name ASC')
            ->limit(20);
    }

    public function handleDelete($id)
    {
        $this->database->table('brands')->where('id', $id)->delete();

        $this->flashMessage("Smazáno");
        $this->redirect("Homepage:default");
    }
}
