
<h1 style="text-align:center">WPLANNER</h1> 

<p style="text-align:center">![alt](https://drive.google.com/file/d/1zQx2VrnJP9MEzH_OO65He1X0mkcx2uB6 "WPlanner Logo")</p> 




Name: Jennifer Debono

GitHub: jdebono2023

edX: JD_2410_8GLE

Location: London, ON, Canada

Date: December 29, 2024

#### Video Demo:  <URL HERE>

## Description:

> ### Purpose

This innovative app is designed to transform how users approach fitness by focusing on proactive planning rather than just post-workout tracking. Unlike traditional workout apps that merely log metrics like weights, reps, or cardio time, this app empowers users to take control of their fitness journey by scheduling workouts in advance.

With the ability to create custom workouts, categorize them, and plan ahead, users gain a clear view of their fitness goals right from the app dashboard. Whether it’s a home workout DVD, a trip to the gym or an app-based session like Peloton, users can seamlessly integrate all their routines into one organized schedule.

Insipred by a need to organize, stopping wasting time and paper, the app offers flexibility to view upcoming workouts by date or category, ensuring users stay on track. It also features tools for setting weight goals, tracking measurements, and monitoring progress over time. From building a personalized workout library to scheduling and viewing achievements, this app is a comprehensive solution for anyone aiming to take their fitness planning to the next level. 


> ### Project Set-Up

- [Laravel v.11.3](https://laravel.com/docs/11.x)
- [Jetstream v.5.3](https://jetstream.laravel.com/introduction.html)
- [Livewire v.3.0](https://livewire.laravel.com/docs/quickstart)
- [Filament v.3.2](https://filamentphp.com/docs/3.x/panels/installation)
- [TailwindCSS v.3.4.17](https://tailwindcss.com/docs/installation)
- [PHP Date/Time](https://www.php.net/manual/en/datetime.format.php)
- [Carbon](https://carbon.nesbot.com/docs/)
- [Diabetes Canada](https://www.diabetes.ca/resources/tools-resources)
- DB: sqlite 
- DB manager: SQLite3 Editor (VS Code extension to manage schema and data)

In this project, I opted to use a newer famework, Filament. In my regular development, I use Laravel with Livewire, which requires manually programming controllers and views for the front and back end. In an effort to improve development speed, while providing quiality UX, Filament offered an opportunity to expand development skills by using a all-in-one development framework.

---

#### <ins>Resource Pages

<ins>Dashboard

The dashboard provides a clear overview of the day’s planned workouts and displays active progress widgets for quick insights. These widgets automatically update based on the user’s most recent entries.

<ins>Scheduler

The scheduler enables users to create and manage their workout plans. It allows for adding new workout types to the library during the scheduling process. Workouts are displayed only for the authenticated user and filtered by the current date using Laravel’s Carbon date/time functions.

<ins>Profile

The profile page includes essential personal details such as email, name, and password, along with additional fields for height, age, and goal weight. This page has been customized by extending the base user profile page and table to accommodate these extra attributes, ensuring a personalized experience for each user.

<ins>Progress 

This section allows users to track various fitness metrics, including current weight, measurements (hips, waist, chest), and progress photos. BMI is calculated dynamically, using information from [Diabetes Canada](https://www.diabetes.ca/resources/tools-resources). All progress data is displayed exclusively for the authenticated user, ensuring privacy and relevance.

<ins>Library

The workout library stores detailed information for each workout, including name, source, main category, subcategory, and an optional image. Source and type duplication are not allowed to maintain data integrity. Users can create new workouts, and modify categories, subcategories, and sources directly from this section, ensuring flexibility and efficiency.

---
#### <ins>Widgets

Three custom widgets have been developed to enhance the user experience. Each widget provides real-time values, a compact chart to visualize trends over time, and descriptive text to highlight progress and reflect changes in the data, making it easy for users to monitor and stay on track with their fitness goals.

1. Daily Workouts Widget: 
    
Displays the workouts scheduled for the current day, giving users an at-a-glance view of their daily plan.

2. User Measurements Overview: 

Highlights the most recent measurement data, providing quick access to key stats such as hips, waist, and chest measurements.

3. User Weight Overview: 

Leverages user profile data, including goal weight, and combines it with progress entries to display the current weight and dynamically calculated BMI. The BMI is computed using the height from the user profile and the latest weight data from progress records.

 ---

#### <ins>Database

Default installation of Laravel V.11 uses Sqlite. A built in database, for the scope and scale of this project seemed reasonable, rather than my standard development which uses an external MySQL databse. The Laravel and Jetstream frameworks auto create user tables along with authentication and session tables.

<ins>Tables:

1. schedules: (1:M - users, 1:M - libraries)

Contains workout name, date, time attributed to the user.

2. progress: (1:M - users)

Contains progress measurements and user progress images, attributed to the user.

3. libraries (1:M - type_seconds, 1:M - type_mains, 1:M - sources)

Contains workout name, source, category, subcategory and images. Publically visible and enditable by all users.

4. type_mains: (category names)
5. type_seconds: (subcategory names)
6. sources: (workout source names)

---
#### <ins>Web Routing & Session Overrides & Security
- Customized via app/routes/web.php: default laravel routing was overridden to allow a better user experince by providing redirects to the developed Filament based pages
- Customized via app/config/session.php: Session Lifetime adjusted to 5s, session cleared when browser window is closed, session storage in DB (default)
- when accessing resources/pages, non authenticated users recieve a 404 error

---
#### <ins>Future Feature Releases
- data management: AWS S3
- reward screen/event for reaching goal weight target
- include: BF %
- integration with tracking apps
- interactive dashboard widgets(drag n drop, hide or add)
- copy previous workouts to repeat a plan as a template

---

> ### Run this project in VS Code:

\* Note 1: the .env file has been provided and configured for local development purposes. The database makes use of SQLite3 as a default, with all tables in tact. Demo data includes the information shown in the demo video. This project has been optimized for production, with the exception of email.

\* Note 2: on install, php.ini extension=pdo_sqlite needs to be uncommented

- open a new terminal
- cd project/wplanner
- composer install
- npm install
- php artisan serve
- npm run dev
