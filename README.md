# lsyh-symfony-task

## To run the project

1. `docker build -t lsyh-symfony-task .`
2. `docker run -p 8000:8000 lsyh-symfony-task`
3. Access the site on `127.0.0.1:8000`

## Available endpoints

| Endpoint       | Method | Description                                                                                        |
|----------------|--------|----------------------------------------------------------------------------------------------------|
| /api/user/{id} | GET    | Lists all or a single User based on <br>[id]<br>Use `?format=yaml` to retrieve the results in YAML |
| /api/user      | POST   | Creates a new user                                                                                 |

## User creation example request

`[POST] /api/user`

```json
{
  "firstName": "John",
  "lastName": "Doe",
  "password": "secret",
  "emailAddress": "john@doe.test"
}
```