# todo
A to-do list app written in Laravel 10 (which I use as a template for my other Laravel projects). Work in progress.
![A screenshot of task list](public/images/Screenshot%20from%202023-10-22%2022-48-23.png "A screenshot of task list")
## Installation
Create a database, copy the ```.env.example``` file and rename it to ```.env```, edit the ```.env``` file to match your environment configuration, then run ```composer update && npm install && npm run build && php artisan migrate:fresh --seed && php artisan key:generate && php artisan storage:link```.
## Usage
Run ```php artisan serve``` and visit http://localhost:8000 (or whichever port ```artisan``` serves on) on your browser.
