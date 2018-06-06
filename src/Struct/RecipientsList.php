<?php
/**
 * @filename: RecipientsList.php
 */
declare(strict_types=1);

/** @namespace */
namespace ZendMailgun\Struct;

/**
 * Class RecipientsList
 * @package ZendMailgun\Struct
 */
class RecipientsList extends AbstractStruct
{
    /** @var array */
    private $recipients = [];

    /**
     * RecipientsList constructor.
     *
     * @param Recipient ...$recipients
     */
    public function __construct(Recipient ...$recipients)
    {
        $this->recipients = $recipients;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param Recipient ...$recipients
     *
     * @return RecipientsList
     */
    public function setRecipients(Recipient ...$recipients): RecipientsList
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * Prepare recipients list for sending message (make comma separated recipient email's)
     * like 'User one <user1@mail.com>, User two <user2@mail.com>'
     *
     * @return string
     */
    public function prepare(): string
    {
        $recipientsString = '';
        $recipientsList = array_map(
            function (Recipient $recipient) {
                return $recipient->prepare();
            }, $this->getRecipients());

        return implode(',', $recipientsList);
    }
}