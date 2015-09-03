<?php

namespace JC\FrameworkExtraBundle\Request\ParamConverter\Model;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class QueryParamConverter implements ParamConverterInterface {
    
    /**
     * @var Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    private $accessor;

    public function __construct() {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration) {        
        $model = $this->createModel($configuration);

        foreach ($request->query->all() as $query_parameter_key => $query_parameter_value) {
            $this->accessor->setValue($model, $query_parameter_key, $query_parameter_value);
        }

        $request->attributes->set($configuration->getName(), $model);     
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration) {
        if (!$configuration->getClass()) {
            return false;
        }

        return true;
    }

    private function createModel(ParamConverter $configuration) {
        $class = $configuration->getClass();

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Failed to load model class [%s]', $class));
        }

        return new $class;
    }
}