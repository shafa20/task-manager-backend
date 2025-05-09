

//for postman check

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

7. http://127.0.0.1:8000/api/tasks/103  -> method put     //for update task

Headers
Content-Type    application/json

body -> raw -> json
{
  "name": "Updated Task Name",
  "description": "Updated Description",
  "status": "Completed"
}


8. http://127.0.0.1:8000/api/tasks/104  -> method delete   //for delete task