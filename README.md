Endomondo Old API base
============

Endomondo is not offering some official API but there is a way that allows you to put, read or delete some data through their mobile API. 

You can use this project on your own responsibility. Endomondo can make changes in this API without any warnings.

This is only basic API wrap that does not have any prepared endpoints. Only thing that is possible with this packpage is to authenticate in Endomondo API and send requests.

## Example
``` php
$endomondo = new \Fabulator\Endomondo\EndomondoOldAPIBase();
$response = $endomondo->requestAuthToken(ENDOMONDO_LOGIN, ENDOMONDO_PASSWORD)->getBody();

$authToken = explode('=', explode("\n", $response)[2])[1];

print_r(json_decode($endomondo->send('/mobile/api/profile/account/get', [
    'authToken' => $authToken,
])->getBody(), true));
```