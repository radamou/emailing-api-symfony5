<?php

declare(strict_types=1);

namespace SymplBundle\Emailing\Domain\DTO;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use SymplBundle\Entity\CustomerCompany;

/**
 * @ExclusionPolicy("all")
 */
class EmailEventTemplateDTO
{
    /**
     * @var string
     * @Expose
     * @Type("string")
     */
    public $id;

    /**
     * @var EmailEventDTO
     *
     * @Expose
     * @Type("SymplBundle\Emailing\Domain\DTO\EmailEventDTO")
     */
    public $emailEventDTO;

    /**
     * @var EmailTemplateDTO
     *
     * @Expose
     * @Type("SymplBundle\Emailing\Domain\DTO\EmailTemplateDTO")
     */
    public $emailTemplate;

    /**
     * @var CustomerCompany
     *
     * @Expose
     * @Type("SymplBundle\Emailing\Domain\DTO\CustomerCompanyDTO")
     */
    public $customerCompany;

    /**
     * @var bool
     *
     * @Expose
     * @Type("boolean")
     */
    public $isActive;
}
