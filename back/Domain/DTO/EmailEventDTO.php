<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\DTO;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Validator;

/**
 * @ExclusionPolicy("all")
 */
class EmailEventDTO
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
     *     pattern="/^([a-z]+.)$/",
     *     match=false,
     *     message="the code should only be a string separated by dot"
     * )
     */
    public $code;

    /**
     * @var string
     *
     * @Expose
     * @Type("string")
     */
    public $description;

    /**
     * @var \DateTimeImmutable
     */
    public $createdAt;

    /**
     * @var \DateTimeImmutable
     */
    public $updatedAt;

    /**
     * @var bool
     *
     * @Expose
     * @Type("boolean")
     */
    public $isActive;

    /**
     * @var EmailTemplateDTO
     *
     * @Expose
     * @Type("SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO")
     */
    public $emailTemplate;

    /**
     * @var EmailEventVariableDTO
     *
     * @Expose
     * @Type("SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO")
     */
    public $emailEventVariable;

    /**
     * @var Collection
     *
     * @Expose
     * @Type("ArrayCollection<SymplBundle\Emailing\Domain\DTO\EmailEventTemplateDTO>")
     */
    public $emailEventTemplates;

    /**
     * @var Collection
     *
     * @Expose
     * @Type("ArrayCollection<SymplBundle\Emailing\Domain\DTO\EmailEventVariableDTO>")
     */
    public $emailEventVariables;
}
