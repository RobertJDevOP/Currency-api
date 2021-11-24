

#  Convert of currencys API 

* [Install](#install)
* [Request & Response Examples](#request--response-examples)
* [Error handling](#Error handling)
* [Mock Responses](#mock-responses)




## Error handling

Error responses should include a common HTTP status code, message for the developer, message for the end-user (when appropriate), internal error code (corresponding to some specific internally determined ID), links where developers can find more info. For example:

    {
      "status" : 400,
      "developerMessage" : "Verbose, plain language description of the problem. Provide developers
       suggestions about how to solve their problems here",
      "userMessage" : "This is a message that can be passed along to end-users, if needed.",
      "errorCode" : "444444",
      "moreInfo" : "http://www.example.gov/developer/path/to/help/for/444444,
       http://drupal.org/node/444444",
    }

Use three simple, common response codes indicating (1) success, (2) failure due to client-side problem, (3) failure due to server-side problem:
* 200 - OK
* 400 - Bad Request
* 500 - Internal Server Error


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

    


