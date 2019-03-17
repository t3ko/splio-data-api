<?php
namespace T3ko\SplioData;

use JMS\Serializer\Annotation as A;

class Field
{
    /**
     * @var int
     * @A\Type("int")
     */
    private $id;

    /**
     * @var string
     * @A\Type("string")
     */
    private $name;

    /**
     * @var string|null
     * @A\Type("string")
     */
    private $value;

    /**
     * Field constructor.
     * @param int $id
     * @param string $name
     * @param null|string $value
     */
    public function __construct($id, $name, $value = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getValue()
    {
        return $this->value;
    }
}