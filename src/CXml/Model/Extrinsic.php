<?php

namespace CXml\Model;

use JMS\Serializer\Annotation as Serializer;

class Extrinsic
{
    #[Serializer\XmlAttribute]
    private string $name;

    #[Serializer\XmlValue(cdata: false)]
    private string $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
