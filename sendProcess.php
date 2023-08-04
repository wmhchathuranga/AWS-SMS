<?php
require_once(__DIR__ . '/vendor/autoload.php');

use TextMagic\Models\;
use TextMagic\Api\TextMagicApi;
use TextMagic\Configuration;

// put your Username and API Key from https://my.textmagic.com/online/api/rest-api/keys page.
$config = Configuration::getDefaultConfiguration()
->setUsername('YOUR_USERNAME')
->setPassword('YOUR_API_KEY');

$api = new TextMagicApi(
new GuzzleHttp\Client(),
$config
);

$input = new SendMessageInputObject();

// Required parameters
$input->setText("Hello, how are you?");
$input->setPhones("+788292094");

// Optional parameters, you can skip these setters calls
$input->setTemplateId(1);
$input->setSendingTime(1565606455);
$input->setSendingDateTime("2020-05-27 13:02:33");
$input->setSendingTimezone("America/Buenos_Aires");
$input->setContacts("1,2,3,4");
$input->setLists("1,2,3,4");
$input->setCutExtra(true);
$input->setPartsCount(6);
$input->setReferenceId(1);
$input->setFrom("Test sender id");
$input->setRrule("FREQ=YEARLY;BYMONTH=1;BYMONTHDAY=1;COUNT=1");
$input->setCreateChat(false);
$input->setTts(false);
$input->setLocal(false);
$input->setLocalCountry("US");
$input->setDestination("mms");
$input->setResources("tmauKcSmwflB77kLQ15904023426649.jpg");

try {
// SendMessageResponse class object
$result = $api->sendMessage($input);
// ...
} catch (Exception $e) {
echo 'Exception when calling TextMagicApi->sendMessage: ', $e->getMessage(), PHP_EOL;
}