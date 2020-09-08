<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    public function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge_recursive([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ],$options);
    }
}