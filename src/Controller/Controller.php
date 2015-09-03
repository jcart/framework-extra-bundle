<?php

namespace JC\FrameworkExtraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController {

    private function renderErrors($errors) {
        $formattedErrors = [];

        foreach ($errors as $key => $value) {
            $formattedErrors[$value->getPropertyPath()] = $value->getMessage();
        }

        return $formattedErrors;
    }
}
