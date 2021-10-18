# Suggestion

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