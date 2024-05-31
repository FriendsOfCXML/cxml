<?php

namespace CXml\Model;

use JMS\Serializer\Annotation as Serializer;

class MultilanguageString
{
    #[Serializer\XmlValue(cdata: false)]
    private ?string $value = null;

    #[Serializer\XmlAttribute]
    private ?string $type = null;

    #[Serializer\XmlAttribute(namespace: 'http://www.w3.org/XML/1998/namespace')]
    private ?string $lang = null;

    public function __construct(?string $value, string $type = null, string $lang = 'en')
    {
        $this->value = $value;
        $this->lang = $lang;
        $this->type = $type;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }
}
