<?php

declare(strict_types=1);

namespace Emailing\Domain\DTO;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * @ExclusionPolicy("all")
 */
class EmailTemplateDTO
{
    /**
     * @var string
     *
     * @Expose
     * @Type("string")
     */
    public $id;

    /**
     * @var string
     *
     * @Expose
     * @Type("string")
     */
    public $title;

    /**
     * @var string
     *
     * @Expose
     * @Type("string")
     */
    public $body;

    /** @var string
     *
     * @Expose
     * @Type("string")
     */
    public $language;

    /**
     * @var EmailEventDTO
     *
     * @Expose
     * @Type("Emailing\Domain\DTO\EmailEventDTO")
     */
    public $emailEvent;

    /** @var \DateTimeImmutable */
    public $createdDate;

    /** @var \DateTimeImmutable */
    public $updateDate;
}
