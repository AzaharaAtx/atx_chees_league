<?php

// Se utilizara en todas las clases que necesiten validar formularios
// Recupera los errores a través del formulario

declare(strict_types=1);
namespace App\Trait;

use Symfony\Component\Form\FormInterface;

trait WithFormErrors
{
    // Generamos un array de errorer que retorna el error en json
    private function getErrors(FormInterface $form): array
    {
        $errors = array();

        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrors($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;

    }

}