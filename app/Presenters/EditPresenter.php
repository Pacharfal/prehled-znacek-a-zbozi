<?php
namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class EditPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Nette\Database\Explorer $database,
    )
    {

    }
    protected function createComponentPostForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Značka:')
            ->setRequired();

        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'postFormSucceeded'];

        return $form;
    }
    public function postFormSucceeded(array $data): void
    {
        $id = $this->getParameter('id');

        if ($id) {
            $brand = $this->database
                ->table('brands')
                ->get($id);
            $brand->update($data);

        } else {
            $brand = $this->database
                ->table('brands')
                ->insert($data);
        }

        $this->flashMessage("Značka úspěšně přidána.", 'success');
        $this->redirect("Homepage:default");
    }
    public function renderEdit(int $id): void
    {
        $brand = $this->database
            ->table('brands')
            ->get($id);

        if (!$brand) {
            $this->error('Brand not found');
        }

        $this->getComponent('postForm')
            ->setDefaults($brand->toArray());
    }


}
