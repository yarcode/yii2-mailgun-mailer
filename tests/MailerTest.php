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
        $this->a = \Yii::createObject([
            'class' => \YarCode\Yii2\Mailgun\Mailer::class,
            'apiKey' => 'test-key',
            'domain' => 'example.org',
        ]);
    }

    public function testInterface()
    {
        $this->assertInstanceOf(\yii\mail\MailerInterface::class, $this->a);
    }
}