<div align='center'>

# COVID Vaccine Registration System

</div>


## Configuration
- PHP-8.1
- Laravel-10

## How to run this project

### ENV Setup 
- Please create `.env` file and copy-paste data from the `.env.example` file.
- You have to setup database related credentials properly in .env
- You have to setup mail related credentials properly.
- You have to setup QUEUE_CONNECTION=database to run Queue for sending mail
- Set APP_TIMEZONE=Asia/Dhaka


### Update Your Composer 
```bash
composer update
```

### Generate APP_KEY
```bash
php artisan key:generate
```

### Migrate 
<h5>Just run this command</h5>

```bash
php artisan migrate
```

### Seeder
```bash
php artisan db:seed
```

### Run Project 
```bash
php artisan serve
```

### Run Queue 
```bash
php artisan queue:work
```

### To Test CORN JOB 
```bash
php artisan reminder:send
```

## Test Case Result 
Just run the command
```bash
php artisan test
```

<img src="https://snipboard.io/s5wdeX.jpg">


### What I have done
- User can registration for Covid Vaccine.
- User can check registration status
- You (Reviewer) can see all vaccine center list
- You (Reviewer) can see all users list
- Used datatable 
- Testing by PEST Framework
- Corn Job setup for sending email to the registered user at 09:00 PM before 1 day ago of their vaccine schedule date.
- Mail sent asynchronously 
- Schedule vaccination only for the weekdays (Sunday to Thursday)


### About performance for the `User Registration` and `Search`

Though I try to make a better performance to build this system but If I had more time, I would also recommend the following additional optimizations: -

- `Indexing :` Database indexes improve the speed of read operations by helping the database quickly locate rows instead of scanning the entire table. Without indexes, queries (like searching by NID or retrieving schedules) can become slow as the amount of data grows.
- `Caching:` Use caching mechanisms like Redis or Memcached to store frequently accessed data such as user records or search results. This can significantly reduce the time taken to fetch data from the database.
- `Eager Loading:` When querying the database for user records or search results, use eager loading to load related data in a single query, instead of making multiple queries. This can help reduce the number of queries made to the database, improving performance.
- `Queue Email Notifications:` 
    - Already implemented queued jobs for sending email reminders to avoid blocking the main request. 
    - Using Laravel's queue system to offload time-consuming tasks like sending emails or processing data in the background, freeing up server resources for faster user registration and search.
    - Optimizations for production: Use Redis as the queue driver instead of the default database driver for better speed and scalability.
- `Optimize Images:` Optimize images to reduce their file size and load times. This can help improve the overall performance of the application, especially if I have a lot of images on the site.
- `Pagination :` If the search feature grows to return multiple results (e.g., by name or partial NID match), implementing pagination will prevent slow queries and heavy memory usage.
- `Optimize Cron Jobs for Notification Emails`
    - If the user base grows, sending thousands of emails at once might slow things down.
        - `Batch processing` can be used to send emails in smaller batches (e.g., 100 at a time) to avoid overloading the mail server.
        - Use `event-driven notifications` if available, to trigger emails based on real-time activity instead of relying entirely on cron jobs.
- `Monitor Performance with Tools` : Integrate tools like `Laravel Telescope` or `New Relic` to monitor query performance and identify bottlenecks in real-time.



### About ‘SMS’ notification

If an additional requirement to send `SMS notifications` along with database notifications for vaccine reminders is introduced, several changes will be necessary in both the `business logic` and `infrastructure` to ensure SMS is sent effectively. Below are the steps and the changes you’ll need to make.

1. Need to choose an SMS Gateway Provider like : Twilio, Nexmo (Vonage), Plivo, Textlocal
2. Need to update the `SendVaccineReminderJob` class to include both database and SMS logic.
3. Need to update the Notification Parameters
    - `Phone Number:` Need to modify the user registration form to collect the patient’s phone number.
    - `Validation Rule:` Need to add a validation rule for a valid phone number in the registration logic.
4. Need to add SMS gateway credentials in .env
5. Ensure Error Handling : 
    - If the `SMS gateway fails`, it may need to log the error and ensure it doesn’t stop the `database notification` from being sent.
    - Implement a `retry mechanism` if SMS sending fails (it can configure Laravel's job retries).
6. Queue Both `Database` and `SMS Notifications`
    - Ensure that both notifications are queued to avoid blocking the main thread.
    - Laravel jobs and queues will handle the sending efficiently.
7. Testing and Deployment
    - Use a sandbox mode (like Twilio’s test environment) to test SMS sending before going live.
    - Monitor for any rate limits imposed by the SMS gateway provider to avoid being blocked.


### Visit Page

- Home Page : http://127.0.0.1:8000

<img src="https://snipboard.io/GkH2eW.jpg">

<br>

- Vaccine Registration Form : http://127.0.0.1:8000/registration

<img src="https://snipboard.io/PjQUwC.jpg">

<br>

- Vaccine Center List : http://127.0.0.1:8000/vaccine-center-list

<img src="https://snipboard.io/hT7SDN.jpg">

<br>

- Vaccine Registration Status : http://127.0.0.1:8000/search

<img src="https://snipboard.io/Zk9Wbd.jpg">

<br>

<img src="https://snipboard.io/M8oPjO.jpg">

<br>

- All Users : http://127.0.0.1:8000/all-users

<img src="https://snipboard.io/OxHjEb.jpg">


### Packages used in application
- #### [Artisan View](https://github.com/svenluijten/artisan-view)
- #### [Laravel Pint](https://github.com/laravel/pint)
- #### [PEST Framework](https://pestphp.com)


### Reference
1. Surokkha : https://surokkha.gov.bd/
# freelance-time-tracker-api
