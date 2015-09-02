<?php

namespace JC\FrameworkExtraBundle\Request\ParamConverter\Model;

use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class EncodedParamConverter implements ParamConverterInterface
{
    /**
     * @param \JMS\Serializer\SerializerInterface
     */
    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration) {
        $notification = $this->serializer->deserialize($request->getContent(), $configuration->getClass(), $request->attributes->get('_format'));

        $request->attributes->set($configuration->getName(), $notification);        
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
}