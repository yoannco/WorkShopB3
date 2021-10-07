<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('link')
            // ->add('UserId')
            ->add('link', FileType::class ,array('label' => 'choissisez un document'))
            // ->add('link', TextType::class, [
                // 'label' => 'link (PDF file)',

                // // unmapped means that this field is not associated to any entity property
                // 'mapped' => false,

                // // make it optional so you don't have to re-upload the PDF file
                // // every time you edit the Product details
                // 'required' => false,

                // // unmapped fields can't define their validation using annotations
                // // in the associated entity, so you can use the PHP constraint classes
                // 'constraints' => [
                //     new File([
                //         // 'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             'application/pdf',
                //             'application/x-pdf',
                //         ],
                //         'mimeTypesMessage' => 'Please upload a valid PDF document',
                //     ])
                // ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
