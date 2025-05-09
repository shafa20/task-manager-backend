

//backend project download and setup
1.write command -> git clone https://github.com/shafa20/task-manager-backend

2. run command ->  composer install

3.copy the .env.example file and rename it to .env

in .rnv file write below code

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

.................
Note if you use my db which is inside db.zip file then it could be like
in phpmyadmin create a database name task-manager

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task-manager
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

4.php artisan key:generate

5.php artisan migrate && php artisan db:seed (if you use my db in xampp do not need to seed )

6. run command -> php artisan serve

................
Unit testing

8. run command php artisan test

.....................................

//Frontend project download and setup
1. 1st run command -> git clone https://github.com/shafa20/task-manager-frontend
2. 2nd run command -> npm install
3. run command -> npm start

...................................

//For Backend Api Check in postman

1. http://127.0.0.1:8000/api/tasks  -> method get  // to get all tasks list

2. http://127.0.0.1:8000/api/tasks?page=1&per_page=10   -> method get  // to get  tasks list by pagination

3. http://127.0.0.1:8000/api/tasks?search=Sample  -> method get  // to get  tasks list by name filtering

4. http://127.0.0.1:8000/api/tasks?status=Pending   -> method get  // to get  tasks list by status filtering pending

5. http://127.0.0.1:8000/api/tasks?status=Completed   -> method get  // to get  tasks list by status filtering completed

6. http://127.0.0.1:8000/api/tasks?search=Sample&status=Completed&page=1&per_page=5  -> method get  // to get  tasks list by complete filter and pagination

7. http://127.0.0.1:8000/api/tasks?status=Completed&page=1&per_page=10 ->method get  // to get  tasks list by complete filter and pagination

8. http://127.0.0.1:8000/api/tasks?search=Sample&status=Pending&page=1&per_page=5  -> method get  // to get  tasks list by pending filter and pagination

9. http://127.0.0.1:8000/api/tasks?status=Pending&page=1&per_page=10 ->method get  // to get  tasks list by pending filter and pagination

10. http://127.0.0.1:8000/api/tasks   -> method post  // for create task

Headers
Content-Type    application/json

body -> raw -> json

{
  "name": "My New Task1",
  "description": "This is a test task",
  "status": "Pending"
}

7. http://127.0.0.1:8000/api/tasks/{id}  -> method put     //for update task

Headers
Content-Type    application/json

body -> raw -> json
{
  "name": "Updated Task Name",
  "description": "Updated Description",
  "status": "Completed"
}


8. http://127.0.0.1:8000/api/tasks/{id}  -> method delete   //for delete task
