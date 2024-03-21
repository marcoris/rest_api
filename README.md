# REST api v1 - sending and receiving json data
<img src="https://github.com/marcoris/rest_api/blob/master/restapi.png">

## Usage
Run `docker compose up -d --build` and check if the api is working over `http://localhost:8080`

## Endpoints
| Category | URL                                      | Method | Access  |
|----------|------------------------------------------|--------|---------|
| category | /api/v1/categories/create                | POST   | Private |
| category | /api/v1/categories/                      | GET    | Public  |
| category | /api/v1/categories/{id}                  | GET    | Public  |
| category | /api/v1/categories/update/{id}           | PUT    | Private |
| category | /api/v1/categories/delete/{id}           | DELETE | Private |

## Token
There has to be a token (in the future) for the `POST`, `PUT` and `DELETE` methods. You can generate the token under `http://localhost:8080/api/v1/login` with `marco:1234`. There is no production solution implemented yet!

## Unit tests
They have to be written...

## Adding new endpoint
1. Open `php` docker container
2. Run `symfony console make:entity`
3. Answer field questions
4. Run `symfony console make:migration`
5. Run `symfony console doctrine:migrations:migrate`
6. Generate controller with `symfony console make:controller XyzController`
7. Adjust file with CRUD functionality under `app/src/Controller/XyzController`

## Payload
In the header: the token

In the body: { json }

## TODOs
- [ ] Add PHPUnit tests
- [ ] Add Swagger UI
- [ ] Add Authorization to get an access token for the private accesses
