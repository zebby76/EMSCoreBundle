<?php 
namespace EMS\CoreBundle\Form\DataTransformer;

use EMS\CoreBundle\Entity\DataField;
use EMS\CoreBundle\Entity\FieldType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\FormRegistryInterface;
use EMS\CoreBundle\Form\DataField\DataFieldType;

class DataFieldTransformer implements DataTransformerInterface
{
	/**@var FieldType */
	private $fieldType;
	/**@var FormRegistryInterface */
	private $formRegistry;

    public function __construct(FieldType $fieldType, FormRegistryInterface $formRegistry)
    {
    	$this->fieldType = $fieldType;
    	$this->formRegistry = $formRegistry;
    }

    /**
     * Transforms a DataField into an associative array.
     *
     * @param  DataField|null $issue
     * @return string|array
     */
    public function transform($data)
    {
        /**@var DataFieldType $dataFieldType*/
        $dataFieldType = $this->formRegistry->getType($this->fieldType->getType())->getInnerType();
        
        return $dataFieldType->transform($data);
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  $data from the Form
     * @return DataField|null
     */
    public function reverseTransform($data)
    {
    	/**@var DataFieldType $dataFieldType*/
    	$dataFieldType = $this->formRegistry->getType($this->fieldType->getType())->getInnerType();
    	
    	return $dataFieldType->reverseTransform($data);
    }
}