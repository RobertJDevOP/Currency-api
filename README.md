

# a simple convert of currencies Laravel 

## Content
* [Install](#install)
* [Usage](#Usage)
* [Response Properties](#Response-Properties)
* [Error handling](#Error-handling)
* [Api codes](#Api-codes)
* [Request & Response Examples](#request-response-examples)

## Install

This is a simple implementation of the currencylayer api, which converts the amounts entered from the standard currency USD to any currency,in which cache is used, avoiding multiple requests to the currencylayer api.

To use it

Clone the project 

```bash
git clone https://github.com/RobertJDevOP/Currency-api.git
```
Run composer commands
```bash
composer install
```

```bash
php artisan serve
```
Once the service is started we can consume the API

# Usage

$cache - Set this to FALSE if you do not want to enabled cachine (TRUE by default)
$cacheFolder - Set your cache folder. By default
$cacheTimeout - Set the amount of time the rates are cached for (in seconds), set to 1 day by default

## Response Properties

| Property    | Description        | Type     
| ----------- | --------------- | --------- | 
| success     | Show code status          | String      | 
| created_at   | Save the date the request was made| timestamp | 
| source      | Currency acronym to convert           | String   | 
| total      | converted currency    | Float | 
| message      | Short description of the errors produced          | String | 
| result      |   Array containing the converted currencies     | Array |

## Error handling
This error is shown when the url is badly formed or simply does not have the required mandatory parameters
Examples of requests failed ,

    {
      "code" : 404,
      "message" : "Api resource not found"
    }

## API Codes

| Code  | Info        | 
| ----- | -------------------------------------------------| 
| 200   |Success  Request                                  | 
| 201   |You have supplied an invalid Source Currency       | 
| 202   |You have provided one or more invalid Currency Codes| 
| 404   |The request is invalid| 
| 500   |Internal Server Error                              | 


## Request & Response Examples

### API Resources

The api resources requires the from to and amount fields to be required and date is optional

  - [GET /convert/[from]/[to]/[amount]/[date]](#get-convert)
  - [GET /multipleConvert/from=USD&to=COP-EUR-GBP&amount=1000&date=2021-11-21](#get-multipleConvert)

### GET /convert/[from]/[to]/[amount][date]

The date field is optional.

Example: http://127.0.0.1:8000/api/v1/convert/[from]/[to]/[amount]/[date]

True example : http://127.0.0.1:8000/api/v1/convert/USD/COP/1000  or
http://127.0.0.1:8000/api/v1/convert/USD/COP/1000/2021-11-21

Response body example:

         {
          "source":"USD",
          "success":true,
          "code":200,
          "created_at":1637914204,
          "result":[{
             "COP":3981,
             "convert":3981000
            }]
        }


### GET /multipleConvert/
The date field is optional.

Example Full URL :  http://127.0.0.1:8000/api/v1/multipleConvert?from=USD&to=COP-EUR&amount=1000&date=2021-11-21

Request body:

        {
            "source": "USD",
            "success": true,
            "code": 200,
            "created_at":1637539199,
            "result": [
                   {
                    "COP":3914,
                    "convert":3914000
                    },
                    {
                    "EUR":0.886902,
                    "convert":886.9019999999999
                    },
                    {
                    "GBP":0.74439,
                    "convert":744.39
                    }
                ]
        }


