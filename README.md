# Usage

SDK to manage webhooks from [https://clicktovalid.com/](https://clicktovalid.com/)

## How to use :
```php
<?php
// load dependencies
// ...

// Get webhook data
$data    = file_get_contents("php://input");
$webhook = ClickToValid\Manager::parseData($data);

// do what you want
// for example you want to send a mail
// when a new request is sent :
if ($webhook instanceof ClickToValid\Webhook\RequestSentWebhook) {
    $to      = 'johndoe@mycompany.com';
    $title   = 'A new ClickToValid request was sent';
    $message = 'Hi John, the request "'.$webhook->getRequest()->getName().'" was sent at '.$webhook->getDate()->format('Y-m-d H:i:s').' by "'.$webhook->getRequest()->getSender()->getFullname().'".';
    mail($to, $title, $message);
}
```

## Types :
We invite you to open webhook classes to see properties and to perform what you want :

| Types | Location |
| -------- | -------- |
| A recipient viewed a file (request attachment) | [src/ClickToValid/Webhook/FileViewedWebhook.php](src/ClickToValid/Webhook/FileViewedWebhook.php) |
| A recipient answered a request | [src/ClickToValid/Webhook/RecipientAnsweredWebhook.php](src/ClickToValid/Webhook/RecipientAnsweredWebhook.php) |
| A request expired before being answered | [src/ClickToValid/Webhook/RequestExpiredWebhook.php](src/ClickToValid/Webhook/RequestExpiredWebhook.php) |
| A request has been answered by all recipients and is now closed | [src/ClickToValid/Webhook/RequestFullyAnsweredWebhook.php](src/ClickToValid/Webhook/RequestFullyAnsweredWebhook.php) |
| A sender revived manually a request | [src/ClickToValid/Webhook/RequestManualRevivedWebhook.php](src/ClickToValid/Webhook/RequestManualRevivedWebhook.php) |
| A recipient opened a request | [src/ClickToValid/Webhook/RequestOpenedWebhook.php](src/ClickToValid/Webhook/RequestOpenedWebhook.php) |
| A new request has been sent | [src/ClickToValid/Webhook/RequestSentWebhook.php](src/ClickToValid/Webhook/RequestSentWebhook.php) |
