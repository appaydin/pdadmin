<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Serializer;

use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

/**
 * pdAdmin Class Object Normalizer
 *
 * @package AdminBundle\Serializer
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class ObjectNormalizer extends AbstractObjectNormalizer
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    public function __construct(ClassMetadataFactoryInterface $classMetadataFactory = null, NameConverterInterface $nameConverter = null, PropertyAccessorInterface $propertyAccessor = null, PropertyTypeExtractorInterface $propertyTypeExtractor = null)
    {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyTypeExtractor);

        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = array())
    {
        // Normalizer Set Ignored Attributes
        $attributes = ['__initializer__', '__cloner__', '__isInitialized__'];
        if (isset($context['setIgnoredAttributes'])) {
            $attributes = array_merge($attributes, $context['setIgnoredAttributes']);
        }
        $this->setIgnoredAttributes($attributes);

        // Normalizer Set Circular Handler
        if (isset($context['setCircularReferenceHandler'])) {
            $this->setCircularReferenceHandler($context['setCircularReferenceHandler']);
        }

        // Parent Normalizer
        return parent::normalize($object, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractAttributes($object, $format = null, array $context = array())
    {
        // If not using groups, detect manually
        $attributes = array();

        // methods
        $reflClass = new \ReflectionClass($object);
        foreach ($reflClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflMethod) {
            if (
                $reflMethod->getNumberOfRequiredParameters() !== 0 ||
                $reflMethod->isStatic() ||
                $reflMethod->isConstructor() ||
                $reflMethod->isDestructor()
            ) {
                continue;
            }

            $name = $reflMethod->name;
            $attributeName = null;

            if (0 === strpos($name, 'get') || 0 === strpos($name, 'has')) {
                // getters and hassers
                $attributeName = lcfirst(substr($name, 3));
            } elseif (strpos($name, 'is') === 0) {
                // issers
                $attributeName = lcfirst(substr($name, 2));
            }

            if (null !== $attributeName && $this->isAllowedAttribute($object, $attributeName, $format, $context)) {
                $attributes[$attributeName] = true;
            }
        }

        // properties
        foreach ($reflClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $reflProperty) {
            if ($reflProperty->isStatic() || !$this->isAllowedAttribute($object, $reflProperty->name, $format, $context)) {
                continue;
            }

            $attributes[$reflProperty->name] = true;
        }

        return array_keys($attributes);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAttributeValue($object, $attribute, $format = null, array $context = array())
    {
        return $this->propertyAccessor->getValue($object, $attribute);
    }

    /**
     * {@inheritdoc}
     */
    protected function setAttributeValue($object, $attribute, $value, $format = null, array $context = array())
    {
        try {
            $this->propertyAccessor->setValue($object, $attribute, $value);
        } catch (NoSuchPropertyException $exception) {
            // Properties not found are ignored
        }
    }
}