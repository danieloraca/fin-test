# App info
The application is built as an API accepting two parameters in the following format
```yaml
path: /api/{term}/{amount}
```
- First parameter accepts `12` or `24`
- Second parameter accepts float values from `1000` to `20000`

The API call returns json response in the following format:
```json
{
  "term": 24,
  "amount": "£2,322.22",
  "fee": "£105.00"
}
```
The json response is using PoundFormatter to render the `amount` and `fee` in money format.


## Exceptions
1. When `{amount}` is not in 1000 - 20000 range the following exception will be thrown:
```injectablephp
ParameterRangeException
```
2. If the API doesn't receive any of the parameters, or the type is different than the types defined in routes the `ApiExceptionListener` will kick in. 


## Command lines
Running tests using PHPUnit
```
$ make unit
```
Currently there are several unit tests and functional tests defined.

```
$ make analysis
```
Running static analysis using PHPStan
