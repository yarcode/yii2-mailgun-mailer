# Mailgun mailer component for Yii2 framework

[![Build Status](https://travis-ci.org/yarcode/yii2-mailgun-mailer.svg?branch=master)](https://travis-ci.org/yarcode/yii2-mailgun-mailer)
[![Latest Stable Version](https://poser.pugx.org/yarcode/yii2-mailgun-mailer/v/stable)](https://packagist.org/packages/yarcode/yii2-mailgun-mailer)
[![Total Downloads](https://poser.pugx.org/yarcode/yii2-mailgun-mailer/downloads)](https://packagist.org/packages/yarcode/yii2-mailgun-mailer)
[![License](https://poser.pugx.org/yarcode/yii2-mailgun-mailer/license)](https://packagist.org/packages/yarcode/yii2-mailgun-mailer)

Mailgun is a transactional email cloud service. 
Say goodbye to your usual sendmail or postfix MTA problems. 
You can start sending emails via cloud without writing any line of code.

## Installation

The preferred way to install this extension is through
[composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist yarcode/yii2-mailgun-mailer
```

or add

```json
"yarcode/yii2-mailgun-mailer": "*"
```

to the `require` section of your composer.json.

## Usage
Configure `YarCode\Yii2\Mailgun\Mailer` as your mailer.
```
  'mailer' => [
      'class' => \YarCode\Yii2\Mailgun\Mailer::class,
      'domain => 'example.org',
      'apiKey => 'CHANGE-ME',
      'viewPath' => '@common/mail',
  ],
```
Now you can send your emails as usual.
```
$message = \Yii::$app->mailer->compose()
  ->setSubject('test subject')
  ->setFrom('test@example.org')
  ->setHtmlBody('test body')
  ->setTo('user@example.org');

\Yii::$app->mailer->send($message);
```

Templates, attachments and embedded images
```
$message = \Yii::$app->mailer->compose(['html' =>'welcome-html']) #
  ->setSubject('test subject')
  ->setFrom('test@example.org')
  ->setHtmlBody('test body')
  ->setTo('user@example.org')
  ->attach(Yii::getAlias('@common').'/mail/Tweety-bird.jpg')
  # Reference 'fileName' value with  <img src="cid:daffy_duck.jpg"/> in common/mail/welcome-html.php
  ->embed(Yii::getAlias('@common').'/mail/daffy_duck-1048.jpg', ['fileName'=>'daffy_duck.jpg']);

\Yii::$app->mailer->send($message);
```
## Licence ##

MIT
    
## Links ##

* [GitHub repository](https://github.com/yarcode/yii2-mailgun-mailer)
* [Composer package](https://packagist.org/packages/yarcode/yii2-mailgun-mailer)