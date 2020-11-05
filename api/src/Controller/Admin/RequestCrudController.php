<?php

namespace App\Controller\Admin;

use App\Entity\Request;
use App\Manager\RequestManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;

class RequestCrudController extends AbstractCrudController
{
    /**
     * @var RequestManager
     */
    public $requestManager;

    public function __construct(RequestManager $requestManager)
    {
        $this->requestManager = $requestManager;

    }
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


    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        $crudUrlGenerator = $this->get(CrudUrlGenerator::class);

        $removeAllUrl = $crudUrlGenerator->build()
        ->setAction('removeAll')
        ->generateUrl();


        if (Crud::PAGE_INDEX === $responseParameters->get('pageName')) {
            $responseParameters->set('removeAllUrl', $removeAllUrl);

        }

        return $responseParameters;
    }


    public function removeAll(AdminContext $context)
    {
        try {
            $this->requestManager->removeAll();
        } catch(\Exception $e) {
            throw new \Exception(sprintf("Error Processing Request, %s",$e), 1);

        }

        return $this->redirectToRoute($context->getDashboardRouteName());
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('build/request.css');
    }

}
