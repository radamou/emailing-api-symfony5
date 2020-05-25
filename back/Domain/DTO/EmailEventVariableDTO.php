<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\DTO;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Validator;

/**
 * @ExclusionPolicy("all")
 */
class EmailEventVariableDTO
{
    /**
     * @var string
     * @Expose
     * @Type("string")
     */
    public $id;

    /**
     * @var string
     *
     * @Expose
     * @Type("string")
     * @Validator\Regex(
     *     pattern="/^([a-z]+.?)$/",
     *     match=false,
     *     message="the title should only by a string separated by dot"
     * )
     **/
    public $name;

    /**
     * @var string
     *
     * @Expose
     * @Type("string")
     **/
    public $description;
}
