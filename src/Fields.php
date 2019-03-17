<?php
namespace T3ko\SplioData;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as A;

class Fields
{
    /**
     * @var Field[]|ArrayCollection
     * @A\Type("ArrayCollection<T3ko\SplioData\Field>")
     */
    private $fields;

    /**
     * @return ArrayCollection|Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }
}