Mailgun API for Zend Framework 3
================

A PHP ZF3 client library for [Mailgun's API](https://documentation.mailgun.com/en/latest/).

This library provides all of the functionality present in the [official PHP client](https://github.com/mailgun/mailgun-php), 
but makes use of namespaces, provides helper classes to ease message sending and works with Zend Framework 3 (uses its library).

Installation Using [Composer](http://getcomposer.org/)
======================================================

Assuming composer.phar is located in your project's root directory, run the following command:

```bash
composer require awsm3/mailgun-zend3
```

Usage
=====
Sending a Message
-----------------

```php
/** @uses */
use ZendMailgun\{
    Mailgun,
    Struct\Message,
    Struct\Sender,
    Struct\Recipient,
    Struct\RecipientsList
}

// Instantiate a client object
$transport = new Mailgun('your_api_key');

// Instantiate a sender
$sender = new Sender('test@example.com', 'Your name');
 
// Instantiate a Message object
$message = new Message();
 
// Define message properties
$message->setText('Hello, username');
$message->setSubject('Test');
$message->setFrom($sender->prepare());
 
// Instantiate a Recipient object and add details
$recipient = new Recipient();
$recipient->setEmail('recipient.email@example.com');
$recipient->setName('Recipient Name');
 
// Add the recipient to the message
$message->setTo($recipient->prepare());

// Or make recipients list
$recipientsList = new RecipientsList(
    new Recipient('recipient-1@mail.com', 'Recipient 1'),
    new Recipient('recipient-2@mail.com', 'Recipient 2'),
);
$message->setTo($recipientsList->prepare());
 
// Send the message
$response = $transport->messages()->send('your-domain', $message);
```

Sending a ZF3 Message
-----------------

```php
/** @uses */
use ZendMailgun\{
    Mailgun,
    Struct\Message,
    Struct\Sender,
    Struct\Recipient,
    Struct\RecipientsList
}
 
// Convert from ZF message
// $zfMessage is instance of \Zend\Mail\Message
$message = Message::fromZendMessage($zfMessage);

// Instantiate a client object
$transport = new Mailgun('your_api_key');
 
// send the message
$response = $transport->messages()->send('your-domain', $message);
```
