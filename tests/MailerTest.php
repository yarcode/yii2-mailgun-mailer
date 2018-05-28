<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
class MailerTest extends \PHPUnit\Framework\TestCase
{
    /** @var YarCode\Yii2\Mailgun\Mailer */
    public $a;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function setUp()
    {
        parent::setUp();
        $this->a = \Yii::createObject(\YarCode\Yii2\Mailgun\Mailer::class);
    }
}