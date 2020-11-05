<?php

namespace App\Controller\Admin;

use App\Entity\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Request::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['callAt' => 'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        if($pageName === Crud::PAGE_DETAIL) {
            return [
                TextField::new('httpVerb'),
                TextField::new('url'),
                TextField::new('regex', 'Regex Request'),
                DateTimeField::new('callAt'),
                TextareaField::new('bodyRequest'),
                TextareaField::new('headerRequest'),
                TextareaField::new('bodyResponse'),
                TextareaField::new('headerResponse'),
            ];
        }
        return [
            TextField::new('httpVerb'),
            TextField::new('url'),
            DateTimeField::new('callAt'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT);
    }

}
