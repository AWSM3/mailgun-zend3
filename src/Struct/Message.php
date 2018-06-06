<?php
/**
 * @filename: Message.php
 */
declare(strict_types=1);

/** @namespace */
namespace ZendMailgun\Struct;

/** @uses */
use Zend\Mime\Mime as ZendMime;
use Zend\Mail\Message as ZendMessage;

/**
 * Class Message
 * @package ZendMailgun\Struct
 */
class Message extends AbstractStruct
{
    /** @var string */
    private $from;
    /** @var string */
    private $to;
    /** @var string */
    private $cc;
    /** @var string */
    private $bcc;
    /** @var string */
    private $subject;
    /** @var string */
    private $text;
    /** @var string */
    private $html;

    /**
     * @param ZendMessage $zfMessage
     *
     * @return Message
     */
    public static function fromZendMessage(ZendMessage $zfMessage): Message
    {
        $message = new self();

        /** From */
        $fromEmail = $fromName = '';
        if ($zfMessage->getFrom()->count()) {
            $sender = new Sender(
                $zfMessage->getFrom()->current()->getEmail(),
                $zfMessage->getFrom()->current()->getName()
            );
        }

        /** To */
        if ($zfMessage->getTo()->count()) {
            $to = [];
            foreach ($zfMessage->getTo() as $address) {
                $to[] = new Recipient($address->getEmail(), $address->getName(), Recipient::RECIPIENT_TYPE_TO);
            }
            $recipients = new RecipientsList(...$to);
        }


        /** Content */
        $htmlPart = $textPart = null;
        $mimeParts = $zfMessage->getBody()->getParts();
        foreach ($mimeParts as $mimePart) {
            switch ($mimePart->getType()) {
                case ZendMime::TYPE_HTML:
                    $htmlPart = $mimePart->getContent();
                    break;

                case ZendMime::TYPE_TEXT:
                    $textPart = $mimePart->getContent();
                    break;

                default:
                    break;
            }
        }

        $message->setFrom($sender->prepare());
        $message->setTo($recipients->prepare());
        $message->setSubject((string)$zfMessage->getSubject());
        $message->setHtml((string)$htmlPart);
        $message->setText((string)$textPart);

        return $message;
    }


    /**
     * @param string $from
     *
     * @return Message
     */
    public function setFrom(string $from): Message
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string $to
     *
     * @return Message
     */
    public function setTo(string $to): Message
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param string $cc
     *
     * @return Message
     */
    public function setCc(string $cc): Message
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * @param string $bcc
     *
     * @return Message
     */
    public function setBcc(string $bcc): Message
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject(string $subject): Message
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return Message
     */
    public function setText(string $text): Message
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param string $html
     *
     * @return Message
     */
    public function setHtml(string $html): Message
    {
        $this->html = $html;

        return $this;
    }
}