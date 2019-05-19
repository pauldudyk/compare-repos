## Installation

```bash
composer install
npm install
npm run dev
php artisan l5-swagger:generate
php artisan serve
```
## Description
Used:
- Laravel 5.8
- nwidart/laravel-modules
- guzzlehttp/guzzle
- darkaonline/l5-swagger
- Vue + axios + Vuetify

All main logic locates at **Modules\Comparator**.
Number of open pull requests and number of closed pull requests is currently limited due to the structure of Github API - paginated list makes to increase the number of requests (in future this issue will be solved).

## Documentation
After l5-swagger:generate you could find documentation at /api/documentation url.


## License
[MIT](https://choosealicense.com/licenses/mit/)