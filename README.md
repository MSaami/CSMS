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
- run `docker-composer exec app composer install` to install project dependencies // For the first time, it may take some time.
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

