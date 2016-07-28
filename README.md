# yarcode/yii2-async-mailer
Mailgun mailer implementation for Yii2

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yarcode/yii2-mailgun-mailer
```

or add

```json
"yarcode/yii2-mailgun-mailer": "*"
```

## Usage
Configure `YarCode\Yii2\Mailgun\Mailer` as your mailer.
```
  'mailer' => [
      'class' => '\YarCode\Yii2\Mailgun\Mailer',
      'domain => 'example.org,
      'apiKey => 'foobar',
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
