

#  Convert of currencys API 

* [Install](#install)
* [Request & Response Examples](#request--response-examples)
* [Error handling](#Error handling)
* [Mock Responses](#mock-responses)


## Response Properties


| Property    | Description        | Type     
| ----------- | --------------- | --------- | 
| success     | ...          | String      | 
| timestamp   |--| Timestamp | 
| source      | ---           | String   | 
| total      | 2992           | Float | 
| message      | ''           | String | 
## Error handling 

This is a example of request failed

    {
      "code" : 404,
      "message" : "Verbose, plain language description of the problem. Provide developers
    }

## API Codes

| Code  | Info        | 
| ----- | -------------------------------------------------| 
| 200   | Success  Request                                  | 
| 201   |You have supplied an invalid Source Currency       | 
| 202   |You have provided one or more invalid Currency Codes| 
| 404   |The request is invalid| 
| 500   | Internal Server Error                              | 


## Request & Response Examples

### API Resources

  - [GET /convert/[from]/[to]/[amount]](#get-convert)
  - [GET /convert/[from]/[to]/[amount]/[date]](#get-convert)
  - [GET /multipleConvert/](#get-multipleConvert)

### GET /convert/[from]/[to]/[amount]

Example: http://127.0.0.1:8000/api/v1/convert/[from]/[to]/[amount]

Response body:

        "source": {
          "source":"USD",
          "COP":3914,
          "total":4696800
        },
    

### GET /convert/[from]/[to]/[amount]/[date]

Example: http://127.0.0.1:8000/api/v1/convert/[from]/[to]/[amount]/[date]

Response body:

    "source": {
          "source":"USD",
          "COP":1882.081485,
          "total":1882.081485
        },



### GET /multipleConvert/

Example: multipleConvert – GET  http://example.gov/api/v1/magazines/[id]/articles
http://127.0.0.1:8000/api/v1/convertCurrencys?from=USD&to=COP-EUR&amount=1000&date=2021-11-21

Request body:

    


