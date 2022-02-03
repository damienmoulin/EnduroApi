<?php
/**
 * ValidationError.php.
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Form
 *
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintViolation;

/**
 *
 */
class ValidationError
{
    /**
     * @param Form $form
     *
     * @return array
     */
    public function process(FormInterface $form): array
    {
        $validationError = [];
        foreach ($form->getErrors() as $error) {
            /** @var ConstraintViolation $cause */
            $cause = $error->getCause();

            $causeMessage = $cause->getMessage();
            $errorMessage = $error->getMessage();
            if($causeMessage === $errorMessage){
                $message = $errorMessage;
            }else {
                $message = $errorMessage.' :: '.$causeMessage;
            }

            $invalidValue = ' ';
            $propertyPath = ' ';

            if (method_exists($cause, 'getPropertyPath')) {
                $propertyPath = $cause->getPropertyPath();
            }

            if (method_exists($cause, 'getInvalidValue')) {
                $invalidValue = $cause->getInvalidValue();
            }

            if (is_array($invalidValue)) {
                $invalidValue = json_encode($invalidValue);
            }

            $childErrors[$propertyPath] = $message.' -> '.$invalidValue;

            $validationError[$form->getName()][] = $childErrors;
        }

        foreach ($form as $child) {
            if ($child->isSubmitted() && !$child->isValid()) {
                $childErrors = [];
                $childValue = $form->get($child->getName())->getData();

                /** @var FormError $error */
                foreach ($child->getErrors(true) as $error) {
                    /** @var ConstraintViolation $cause */
                    $cause = $error->getCause();

                    $causeMessage = $cause->getMessage();
                    $errorMessage = $error->getMessage();
                    if($causeMessage === $errorMessage){
                        $message = $errorMessage;
                    }else {
                        $message = $errorMessage.' :: '.$causeMessage;
                    }

                    $invalidValue = ' ';
                    $propertyPath = ' ';

                    if (method_exists($cause, 'getPropertyPath')) {
                        $propertyPath = $cause->getPropertyPath();
                    }

                    if (method_exists($cause, 'getInvalidValue')) {
                        $invalidValue = $cause->getInvalidValue();
                    }

                    if (is_array($invalidValue)) {
                        $invalidValue = json_encode($invalidValue);
                    }

                    $childErrors[$propertyPath] = $message.' -> '.$invalidValue;
                }
                $validationError[$child->getName()] = [
                    //                    'input' => $childValue,
                    'errors' => $childErrors,
                ];
            }
        }

        return $validationError;
    }
}
