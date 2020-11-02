<?php

namespace App\Controller\Admin;

use App\Entity\PreconfigureResponse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PreconfigureResponseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PreconfigureResponse::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('priority'),
            ChoiceField::new('httpVerb')->setChoices(["GET" => "get", "POST"=> "post", "PUT" => "put", "DELETE" => "delete" ,  "OPTION" =>  "option"]),
            TextField::new('regex'),
            IntegerField::new('code')->setFormTypeOptions(['attr' => ['min' => 0]]),
            TextareaField::new('body'),
            TextareaField::new('headers'),
        ];
    }

}
