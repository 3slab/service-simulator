<?php

namespace App\Controller\Admin;

use App\Entity\PreconfigureResponse;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpKernel\KernelInterface;

class PreconfigureResponseCrudController extends AbstractCrudController
{
    /** KernelInterface $appKernel */
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }

    public static function getEntityFqcn(): string
    {
        return PreconfigureResponse::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Details'),
            IntegerField::new('priority'),
            ChoiceField::new('httpVerb')->setChoices(
                ["GET" => "get", "POST"=> "post", "PUT" => "put", "DELETE" => "delete" ,  "OPTIONS" =>  "options"])
                ->renderAsNativeWidget(true),
            TextField::new('regex'),
            IntegerField::new('code')->setFormTypeOptions(['attr' => ['min' => 0]]),
            TextareaField::new('body')->setFormTypeOptions(['attr' => ['rows' => 10]]),
            TextareaField::new('headers'),
        ];
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        $templates = $this->getPreconfigureTemplate();

        if (Crud::PAGE_NEW === $responseParameters->get('pageName') || Crud::PAGE_EDIT === $responseParameters->get('pageName')) {
            $responseParameters->set('templates', $templates);

        }

        return $responseParameters;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addCssFile('build/custom.css');
    }


    private function getPreconfigureTemplate()
    {
        $templates = [];
        $projectDir = $this->appKernel->getProjectDir();

        $files = scandir(sprintf("%s/config/simtemplates", $projectDir), 1);

        foreach($files as $file) {
            $data = file_get_contents(sprintf("%s/config/simtemplates/%s", $projectDir, $file));
            $obj = json_decode($data);
            if($obj) {
                $templates[$obj->name] = $obj;
            }
        }

        return $templates;
    }


}
