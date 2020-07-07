### Prebuild
Please install composer.phar in project
     
### Build example
     docker-compose build
     docker-compose up -d
     docker exec -it solar /ban/bash 
     root@aa5414d067a1:/var/www/html# ./composer.phar install && cp .env.example .env && sed -i "s/DB_HOST=127.0.0.1/DB_HOST=solardb/g" .env && php artisan key:generate && php artisan migrate && php artisan db:seed && php artisan test


### API
    PUT      | api/v1/comments/{comment} | api. | App\Http\Controllers\Api\V1\CommentApiController@update  | api        |
    DELETE   | api/v1/comments/{comment} | api. | App\Http\Controllers\Api\V1\CommentApiController@destroy | api        |
    GET|HEAD | api/v1/comments/{post_id} | api. | App\Http\Controllers\Api\V1\CommentApiController@index   | api        |
    POST     | api/v1/comments/{post_id} | api. | App\Http\Controllers\Api\V1\CommentApiController@store   | api        |

### Examples
     $this->json('PUT', '/api/v1/comments/{comment_id}', ['body' => 'update comment_id 1 and returned 202'])
     $this->json('POST', '/api/v1/comments/{post_id}', ['body' => 'Create new root comment for post_id 1', 'user_id' => 1])
     $this->json('POST', '/api/v1/comments/{post_id}'', ['body' => 'Create new child comment to parent_id=comment_id parrent', 'parent_id' => 1, 'user_id' => 1])
     $this->json('DELETE', '/api/v1/comments/{comment_id}}')
