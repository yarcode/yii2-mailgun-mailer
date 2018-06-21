<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace YarCode\Yii2\Mailgun;

use Mailgun\Messages\MessageBuilder;
use yii\helpers\ArrayHelper;
use yii\mail\BaseMessage;

class Message extends BaseMessage
{
    /** @var MessageBuilder */
    protected $messageBuilder;

    public function __construct(MessageBuilder $messageBuilder, array $config = [])
    {
        $this->messageBuilder = $messageBuilder;
        parent::__construct($config);
    }

    /**
     * @return MessageBuilder
     */
    public function getMessageBuilder()
    {
        return $this->messageBuilder;
    }

    // MessageInterface implementation

    /**
     * @inheritdoc
     */
    public function attachContent($content, array $options = [])
    {
        if (empty($options['fileName'])) {
            throw new \InvalidArgumentException('File name not specified');
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'mailgun');
        file_put_contents($tempPath, $content);

        return $this->attach($tempPath, $options);
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {
        $this->getMessageBuilder()->addAttachment($fileName, ArrayHelper::getValue($options, 'fileName'));
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function embedContent($content, array $options = [])
    {
        if (empty($options['fileName'])) {
            throw new \InvalidArgumentException('File name not specified');
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'mailgun');
        file_put_contents($tempPath, $content);

        return $this->embed($tempPath, $options);
    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {
        $this->getMessageBuilder()->addInlineImage('@' . $fileName, ArrayHelper::getValue($options, 'fileName'));
        return basename($fileName);
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        return $this->getMessagePart('bcc');
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function getMessagePart($name)
    {
        $message = $this->messageBuilder->getMessage();
        return ArrayHelper::getValue($message, $name);
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        return $this->getMessagePart('cc');
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return 'UTF-8';
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return $this->getMessagePart('from');
    }

    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        return $this->getMessagePart('h:reply-to');
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getMessagePart('subject');
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->getMessagePart('to');
    }

    /**
     * @inheritdoc
     */
    public function setBcc($bcc)
    {
        if (is_string($bcc)) {
            $this->getMessageBuilder()->addBccRecipient($bcc);
        } elseif (is_array($bcc)) {
            foreach ($bcc as $key => $value) {
                if (is_string($key)) {
                    $this->getMessageBuilder()->addBccRecipient($key, ['full_name' => $value]);
                } else {
                    $this->getMessageBuilder()->addBccRecipient($value);
                }
            }
        } else {
            throw new \InvalidArgumentException('Invalid bcc address');
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setCc($cc)
    {
        if (is_string($cc)) {
            $this->getMessageBuilder()->addBccRecipient($cc);
        } elseif (is_array($cc)) {
            foreach ($cc as $key => $value) {
                if (is_string($key)) {
                    $this->getMessageBuilder()->addCcRecipient($key, ['full_name' => $value]);
                } else {
                    $this->getMessageBuilder()->addCcRecipient($value);
                }
            }
        } else {
            throw new \InvalidArgumentException('Invalid cc address');
        }

        return $this;
    }

    /**
     * Not implemented
     * @inheritdoc
     */
    public function setCharset($charset)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFrom($from)
    {
        if (is_string($from)) {
            $this->getMessageBuilder()->setFromAddress($from);
        } elseif (is_array($from) && count($from) == 1) {
            $this->getMessageBuilder()->setFromAddress(key($from), ['full_name' => current($from)]);
        } else {
            throw new \InvalidArgumentException('Invalid from address');
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setReplyTo($replyTo)
    {
        $this->getMessageBuilder()->setReplyToAddress($replyTo);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->getMessageBuilder()->setSubject($subject);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($text)
    {
        $this->getMessageBuilder()->setTextBody($text);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTo($to)
    {
        if (is_string($to)) {
            $this->getMessageBuilder()->addToRecipient($to);
        } elseif (is_array($to)) {
            foreach ($to as $key => $value) {
                if (is_string($key)) {
                    $this->getMessageBuilder()->addToRecipient($key, ['full_name' => $value]);
                } else {
                    $this->getMessageBuilder()->addToRecipient($value);
                }
            }
        } else {
            throw new \InvalidArgumentException('Invalid to address');
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($html)
    {
        $this->getMessageBuilder()->setHtmlBody($html);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        $message = $this->getMessageBuilder()->getMessage();
        return var_export($message, true);
    }
}
