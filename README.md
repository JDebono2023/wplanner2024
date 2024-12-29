Resources Used:
https://laravel.com/docs/11.x
https://filamentphp.com/docs
https://tailwindcss.com/docs/installation
https://www.php.net/manual/en/datetime.format.php
https://www.myfitnesspal.com/
https://www.diabetes.ca/resources/tools-resources/body-mass-index-(bmi)-calculator

Plugin:
https://github.com/leandrocfe/filament-apex-charts
https://apexcharts.com/docs/options/


###to-do

- set up DB: sqlite
    - notes: VS Code extension: SQLITE - an explorer
    - notes: php.ini extension=pdo_sqlite needs to be uncommented
-
- laravel
- jetstream
- livewire
- filament v3.2


Purpose
Create a scheduler to plan workouts for the future
Track personal progress

profile - email, name, password, height, age, goal weight
Progress - tracking variable data for stats: current weight, basic measurements, photos, BMI calculated on the fly
scheduler - create and manage workouts scheduled, add new workout types to the library while creating a scheduled plan
library: name, source, main category, subcategory, image of workout, source and type duplication not permitted
dashboard: display workouts planned for the day


future
- reward screen/event for reaching goal weight target
- include: BF %
- integration with tracking apps
- interactive dashboard widgets(drag n drop, hide or add)
- create workout templates
- copy previous workouts to repeat a plan
