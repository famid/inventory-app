```
Requirements:
-------------
1. PHP >= 8.1.14 and also php extension
2. composer
3. Mysql
4. node v17.9.1


```

```
Installation:
--------------
1. Lets go to the directory where you want to keep your project.

2. Then run the below command from the terminal:
$ git clone "https://github.com/famid/inventory-app.git"

3. create a .env file and copy from .env.example then set these variables .
 
 APP_NAME,
 DB_DATABASE,
 DB_USERNAME,
 DB_PASSWORD,
 
4. Then run:
$ composer install

5. Lastly, run a few commands:
import sql in your project database from (path: SQL/laravel_evaluation.sql)
command: mysql -u username -p database_name < {file_path}/laravel_evaluation.sql

$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ npm run dev
6. To run the application locally, run:

$ php artisan serve

7. For login, use the below credentials(Make sure you run the db:seed command):
email: admin@email.com
password: 1234
```
```
 Local Url: http://localhost:8000
```


### User Authentication/Registration Page
```
Registration:

url: /login
Using Fields: name, email, password

Login:

url: /registration
Using Fields: email, password

Constrains:
    Email validation is not added.
    For Production, email validation need to be added.

```

### Project conding pattern.



- **[Request](#)**
```
    How to make request class for validation?
    
    For Web: php artisan make:request TestRequest
    
    Example code:
    
    public function rules(): array {
        return [
            'price' => 'required|numeric|between:0,9999999999.99',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
             ......
        ];
    }
    
    /**
     * @return array
     */
    public function messages(): array {
        return [
            'price.required' => __('Price id field can not be empty.'),
            'price.numeric' => __('Price field must be numeric.'),
            'thumbnail.required' => __('Thumbnail id field can not be empty.'),
             .......
        ]; 
    }
```
- **[Controller](#)**
```
Controller Structure (app/Http/Controllers):

├── Auth
│   ├── ConfirmPasswordController.php
│   ├── ForgotPasswordController.php
│   ├── LoginController.php
│   ├── RegisterController.php
│   ├── ResetPasswordController.php
│   └── VerificationController.php
├── CategoryController.php
├── Controller.php
├── HomeController.php
├── ProductController.php
└── SubcategoryController.php



```

```
   
    How to make controller class?
    For Web: php artisan make:controller TestController
    
    Example code:
    
     /**
     * @param TestRequest $request
     * @return JsonResponse
     */
    public function testMethod(TestRequest $request): JsonResponse {
        return response()->json($this->testService->testFunction($request));
    }
    
    In controller class, we does not write our bussiness logic, it will 
    just receive the request and pass the response.
```
- **[Services](#)**

```
Services Structure (app/Http/Services):

.
├── Boilerplate
│   ├── BaseService.php
│   └── ResponseService.php
├── Category
│   └── CategoryService.php
├── Product
│   └── ProductService.php
└── Subcategory
    └── SubcategoryService.php

```

```
    In Service class, we only write our business logic, then 
    return the required data to the controller class.
    
    In the service class, we can use a special method 
    called response.
    
    
    public function someFunc($request_data) {
        // process data
        // if have some other thing to do
        // Anything save to data on database call Repository class
        ......
        if anythin went wrong:
            return $this->response()->error();
        
        return $this->response()->success();     
    }
    
    If you need to send any data, pass in the response method,
    return $this->response($data)->error();
    
    If want to send any success message send a success message.
    return $this->response($data)->success("something is created successfully");
    
    Similarly to send any error message send in the error method.
    return $this->response($data)->error("any error message you want to write");
    
    If we only use it as 
    return $this->response($data)->error();
    By default the error message will be something went wrong.
    
    If you want to customize the default error message or other things,
    checkout on "ResponseService" in App\Http\Services\Boilerplate dir.  
```
- **[Repository](#)**
```
Repositories Structure (app/Http/Repositories):

├── BaseRepository.php
├── CategoryRepository.php
├── ProductRepository.php
└── SubcategoryRepository.php

```
```
    If you need to query anything on the database, write the function on 
    repository class.
    
    All repository classes inherited abstract BaseRepository class.
    BaseRepository class provides lots of query methods that we use 
    most frequently. Besides if you need to write a new query, you 
    will write on the repository class.
    
    You can create a Repository class by running the artisan command.
    
    $ php artisan make: repository TestRepository
    
    In the service class, use the repository class as,
    
    $updateTestResponse = $this->testRepository->updateWhere(
                ['id' => $request->test_id],
                $this->updatedData
            );
    If you need to write any customer query write as,
    
    public function getUserLatestResetCode (int $userId) {
    
        return $this->model::where(
            ['user_id' => $userId, 'status' => PENDING_STATUS])
            ->orderBy('id', 'desc')
            ->first();
    }
```
### Why this pattern?

Workflow: Route -> Request -> Controller -> Service -> Repository

Why this structure?
1. If our projects grows, we can easily add new module.
2. Easy to understand and find errors.
3. If anything need to change, we can easily change it.
   Ex. Present Situation: We query the products by category, subcategory, title, price.
New requirement is added that products need query by timestamps!! 
```
   We only need to change the only one function(Add only one line!!) in ProductRepository class.
   Don't need to bother about the other part of that feature. 
  ```
    
