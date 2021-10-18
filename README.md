# A Rest API for give a rating based on CDR

A CSMS (charging station management system) such as be.ENERGISED is used to manage charging stations, charging
processes and customers (so-called eDrivers) amongst other things.
One of the most important functionalities of such a CSMS is to calculate a price to a particular charging process so that
the eDriver can be invoiced for the consumed services. Establishing a price for a charging process is usually done by
applying a rate to the CDR (charge detail record) of the corresponding charging process.

Main directories
-------------------

      app/http/controllers/     contains web controller
      app/services              contains business logic
      tests/                    contains various tests for the basic application

# Installation 
-------------------------
- Clone the project.
- run `docker-compose up -d` to building the image and up containers //  For the first time, it may take some time.
- run `docker-compose exec app composer install` to install project dependencies // For the first time, it may take some time.
- You can then access the application through the `http://localhost:8000`


# API Document
-----------------
- You can send data in `POST` to the following URL:
```
http://localhost:8000/api/v1/rate
```
- Body:
```
{
    "rate": {
        "energy": 0.3,
        "time": 3,
        "transaction": 1
    },
    "cdr": {
        "meterStart": 1204307,
        "timestampStart": "2021-04-05T10:04:00Z",
        "meterStop": 1215230,
        "timestampStop": "2021-04-05T11:27:00Z"
    }
}
```

- Response:
```
{
    "overall": 8.43,
    "components": {
        "energy": 3.277,
        "time": 4.15,
        "transaction": 1
    }
}
```
**Also there is a swagger document in the source code.**


# Testing
-------------------
Tests are located in `tests` directory. They are developed by [PHPUnit](https://phpunit.de/)
Tests can be executed by running:
```
vendor/bin/phpunit
```

![Screenshot from 2021-10-18 02-36-44](https://user-images.githubusercontent.com/27271223/137649254-59f7664e-6acf-4069-b011-1054886f8d12.png)


# Suggestions to improve API design

- First we have to have a clear view about the naming. At this point, we have a `cdr` which based on we can create a `rate`
- we have to define a correct prefix for api, for example `/api/`
- Use a API versioning system and define it into routes like `/api/v1/`
- About the request's body we must use a top level like `data`: 
```
"data": {
        "rate": {
            "energy": 0.3,
            "time": 3,
            "transaction": 1
        },
        "cdr": {
            "meterStart": 1204307,
            "timestampStart": "2021-04-05T10:04:00Z",
            "meterStop": 1215230,
            "timestampStop": "2021-04-05T11:27:00Z"
        }
}
```
- Instead of sending `rate` params which it defines conditions, we can store the conditions for each station in database (if they are different) and use a station's UID in route's path, like this:

Route: `/api/v1/stations/7add9320-2ff9-11ec-8d3d-0242ac130003/relationships/rate`
Method: `POST`
Body: 
```
"data": {
    "cdr": {
        "meterStart": 1204307,
        "timestampStart": "2021-04-05T10:04:00Z",
        "meterStop": 1215230,
        "timestampStop": "2021-04-05T11:27:00Z"
    }
}
```
**Also we can return `201 Created` as status**

- About the response we have to return a primary and clear object like this:
```
{
    "data": {
        "type": "rate",
        "id": 34,
        "attributes":{
            "energy": 3.277,
            "time": 2.767,
            "transaction": 1,
            "overall": 7.04
        }
    }
}
```
Also we should use field that shows currency at `meta` field like this:
```
{
    "data": {
        "type": "rate",
        "id": 34,
        "attributes":{
            "energy": 3.277,
            "time": 2.767,
            "transaction": 1,
            "overall": 7.04
        }
    },
    "meta": {
        "currency": "EUR"
    }
}
```
