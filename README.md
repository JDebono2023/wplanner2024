# YOUR PROJECT TITLE
#### Video Demo:  <URL HERE>
#### Description:
your name;
your GitHub and edX usernames;
your city and country;
and, the date you have recorded this video.

TODO

How to run this project:
- composer install
- npm install
- set up .env file
- php artisan storage:link
- php artisan migrate 


should be minimally multiple paragraphs in length, 
and should explain what your project is, 
Purpose
Create a scheduler to plan workouts for the future
Track personal progress


what each of the files you wrote for the project contains and does, 
Set-Up: Resources

Profile - email, name, password, height, age, goal weight -> customized by extending the base user profile data with the addtional height, age and goal weight

Progress - tracking variable data for stats: current weight, basic measurements, photos, BMI calculated on the fly, view by auth user

Scheduler - create and manage workouts scheduled, add new workout types to the library while creating a scheduled plan, view by auth user, only display by current date via laravel Carbon date/time functions

Library: name, source, main category, subcategory, image of workout, source and type duplication not permitted
- users can create new workouts, add and modify category, subcategory and source data for each library item on the spot

Dashboard: display workouts planned for the day, active progress widgets for at a glance info that update based on latest entry

Images: master default image created as a stand in when no images are added. Default is grabbed programatically from app storage, rather than populating the DB

Widgets

Set-Up: DB & Tables
- why sqlite3 vs mySqQL

Web Routing & Session overrides
- app/config/session.php : Session Lifetime adjusted to 5s, session cleared when browser window is closed, session storage in DB (default)

security
- Laravel Jetstream: package for login, registration, email verification, session management - 2 factor auth is currently disabled
- filament automates the process, but requires production set up in the .env file for full configuration
- dev environment option: Mailtrap.io https://mailtrap.io
- when accessing resources/pages, non authenticated users recieve a 404 error

and if you debated certain design choices, explaining why you made them. 
 - popover
 - table vs card
 - filament vs standard livewire & laravel

Ensure you allocate sufficient time and energy to writing a README.md that documents your project thoroughly. Be proud of it! A README.md in the neighborhood of 750 words is likely to be sufficient for describing your project and all aspects of its functionality. If unable to reach that threshold, that probably means your project is insufficiently complex

Resources Used:
https://laravel.com/docs/11.x
https://filamentphp.com/docs
https://jetstream.laravel.com/introduction.html
https://tailwindcss.com/docs/installation
https://www.php.net/manual/en/datetime.format.php
https://carbon.nesbot.com/docs/
https://www.myfitnesspal.com/
https://www.diabetes.ca/resources/tools-resources/body-mass-index-(bmi)-calculator



###to-do
- revise tables for clean installation
- 

- DB: sqlite
    - notes: VS Code extension: SQLITE - an explorer
    - notes: php.ini extension=pdo_sqlite needs to be uncommented
    - DB manager: SQLite3 Editor -> VS Code extension to manage schema and data
-
- laravel
- jetstream
- livewire
- filament v3.2





future feature releases
- data management: AWS S3
- reward screen/event for reaching goal weight target
- include: BF %
- integration with tracking apps
- interactive dashboard widgets(drag n drop, hide or add)
- create workout templates
- copy previous workouts to repeat a plan
- Plugin: Interactive weight chart with custom filters
https://github.com/leandrocfe/filament-apex-charts
https://apexcharts.com/docs/options/

