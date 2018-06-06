<?php
/**
 * Recipient.php
 */
declare(strict_types=1);

/** @namespace */
namespace ZendMailgun\Struct;

/**
 * Class Recipient
 * @package ZendMailgun\Struct
 */
class Recipient extends Participant
{
    const
        RECIPIENT_TYPE_TO = 'to',
        RECIPIENT_TYPE_CC = 'cc',
        RECIPIENT_TYPE_BCC = 'bcc';

    /** @var string the recipient's header type i.e. 'to', 'cc', 'bcc' */
    protected $type = self::RECIPIENT_TYPE_TO;

    /**
     * @inheritdoc
     * @param string $type  the recipient's header type i.e. 'to', 'cc', 'bcc'
     */
    public function __construct($email = null, $name = null, $type = self::RECIPIENT_TYPE_TO)
    {
        parent::__construct($email, $name);
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Recipient
     */
    public function setType(string $type): Recipient
    {
        $this->type = $type;

        return $this;
    }
}
