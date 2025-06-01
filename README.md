<div align='center'>

# 🕒 Freelance Time Tracker API

</div>

A Laravel 10+ RESTful API that enables freelancers to track and manage work hours across clients and projects, with reporting, PDF export, tagging, and daily notifications.



## Project Overview

This API allows registered freelancers to:
- Manage their **clients** and **projects**
- Start, stop, and manually log **work time**
- View and filter time logs by **day**, **week**, **project**, and **client**
- Export logs to **PDF**
- Use **tags** (e.g. `billable`, `non-billable`) for classification
- Get **email notifications** when 8+ hours are logged in a day

Built with **Laravel Sanctum** for authentication, Eloquent ORM, and JSON API standards.

---

## ⚙️ Setup Instructions

1. **Clone the repository**

```bash
git clone git@github.com:Irfan-Chowdhury/freelance-time-tracker-api.git

cd freelance-time-tracker-api
````

2. **Install dependencies**

```bash
composer install

cp .env.example .env

php artisan key:generate
```

3. **Configure `.env`**

Update your database, mail, queue connection and other credentials.

4. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

###  Queue Configuration (for Email Notifications)

Email notifications (when a user logs more than 8 hours in a day) are sent **asynchronously using Laravel queues**. Follow these steps to configure:

5. **Set queue connection**


In your `.env`:

```env
QUEUE_CONNECTION=database
```

Then run:

```bash
php artisan config:cache
```

6. **Create Jobs Table**

<!-- ```bash
php artisan queue:table
php artisan migrate
``` -->
    Already created in migrations.

7. **Start Queue Worker**

Run this in a separate terminal:

```bash
php artisan queue:work
```

>  This is needed to process the email jobs (like the daily hour notification).

---

8. **Serve the app**

```bash
php artisan serve
```
> The API will now be available at http://127.0.0.1:8000

---

<br>

## User Login Credentials 

- **Email** : admin@gmail.com
- **Password** : admin

---

<br>


## API Endpoints

Here are the available endpoints with their descriptions.

### Authentication :
---

| **Method** | **Endpoint**       | **Description**              |
|------------|--------------------|------------------------------|
| POST       | `/api/register`    | Register new user            |
| POST       | `/api/login`       | Login and get access token   |
| POST       | `/api/logout`      | Logout user                  |
| GET        | `/api/profile`     | Get authenticated user info  |


### Clients :
---

| **Method** | **Endpoint**         | **Description**              |
|------------|----------------------|------------------------------|
| GET        | `/api/clients`       | List all clients             |
| POST       | `/api/clients`       | Create a new client          |
| GET        | `/api/clients/{id}`  | Show a specific client       |
| PUT        | `/api/clients/{id}`  | Update a client              |
| DELETE     | `/api/clients/{id}`  | Delete a client              |


### Projects :
---

| **Method** | **Endpoint**           | **Description**               |
|------------|------------------------|-------------------------------|
| GET        | `/api/projects`        | List all projects             |
| POST       | `/api/projects`        | Create a new project          |
| GET        | `/api/projects/{id}`   | Show a specific project       |
| PUT        | `/api/projects/{id}`   | Update a project              |
| DELETE     | `/api/projects/{id}`   | Delete a project              |


### Time Logs :
---

| **Method** | **Endpoint**                         | **Description**                     |
|------------|--------------------------------------|-------------------------------------|
| GET        | `/api/time-logs`                     | List all time logs                  |
| POST       | `/api/time-logs`                     | Create a time log                   |
| PUT        | `/api/time-logs/{timeLog}`           | Update a time log                   |
| DELETE     | `/api/time-logs/{timeLog}`           | Delete a time log                   |
| POST       | `/api/time-logs/{timeLog}/stop`      | Stop timer for ongoing time log     |
| GET        | `/api/time-logs/pdf`                 | Export time logs as PDF             |


### Reports :
---

| **Method** | **Endpoint**     | **Description**                            |
|------------|------------------|--------------------------------------------|
| GET        | `/api/report`    | Get report by client/project/date range    |



<br>

## API Documentation
Please click the [API Documentation](https://documenter.getpostman.com/view/34865364/2sB2qgeJnf) link to check overall details for this User Managemnet API. 


<br>

## Database Structure & Seeding

### Database Schema : 
Please visit the link - https://drawsql.app/teams/irfan-chy/diagrams/freelance-time-tracker

### Tables Relationship

* `users` – Freelancer accounts
* `clients` – Belongs to `users`
* `projects` – Belongs to `clients`
* `time_logs` – Belongs to `projects`

### Seed Data

Use `php artisan db:seed` to generate:

*  1 default user
*  2 sample clients
*  2 sample projects
*  5 sample time logs
---



<br>

## Download Postman Collection & Test with Postman

#### Download :
Please download this **POSTMAN Collection File** : [Download Now](https://drive.google.com/file/d/1VdjZfgayLZ_PVEi3e0-6mj-4FvU70uWA/view?usp=sharing)


#### Import :

1. Import the provided Postman collection into your Postman tool.
2. Setup a Environment to use the token for all API request.
3. Then click on the root folder, open the **Authorization** tab.  
    - Select **Type:** `Bearer Token` 
    - In **Token** field, just put the `environment variable`.
4. Test all the endpoints mentioned above.

Some screenshot given below - 

<img src="https://snipboard.io/OezHn7.jpg" />
<br>
<img src="https://snipboard.io/v8ADLV.jpg" />


<br>

<br>

## API Authentication (Sanctum)

* All API routes (except login/register) are protected by **Laravel Sanctum**.
* Use `/api/register` and `/api/login` to get an access token.
* Attach `Authorization: Bearer {token}` header for all authenticated routes.
---

<br>


## Rate Limiting (Throttle)
* All authenticated API requests are rate limited using Laravel’s `throttle` middleware.
* By default, a user can make **60 requests per minute**.
* If exceeded, the API returns `429 Too Many Requests`.
* This protects the system from abuse and ensures fair usage.
---

<br>

## Performance Notes

* To optimize reporting queries, indexes have been added on `start_time` and `end_time` columns in the `time_logs` table.
* This improves the efficiency of date-based filtering and aggregation (e.g., total hours per day/week/month).
* Eloquent relationships are eager-loaded where needed to reduce N+1 query problems.

---

<br>


## Extra Features

### ✅ PDF Export

* Export logs as a downloadable PDF
* Endpoint:

```http
GET /api/time-logs/pdf
```

### ✅ Tags for Logs

* Field: `tags` (`["billable", "non-billable"]`)
* Store tags as JSON on each time log

### ✅ Email Notifications

* When a freelancer logs **more than 8 hours** in a single day, an **email alert** is automatically sent.

<br>

## 📊 Reports & Filtering

### Endpoint

```http
GET /api/report?client_id=&project_id=&from=YYYY-MM-DD&to=YYYY-MM-DD
```

### Supported Filters

| Param        | Required | Description         |
| ------------ | -------- | ------------------- |
| `client_id`  | Optional | Filter by client    |
| `project_id` | Optional | Filter by project   |
| `from`       | Optional | Start date for logs |
| `to`         | Optional | End date for logs   |

### Returns:

```json
{
  "by_day": {
    "2024-06-01": 6.5,
    "2024-06-02": 3
  },
  "by_project": [
    {
      "project_id": 1,
      "project_title": "Landing Page Design",
      "total_hours": 9.5
    }
  ],
  "by_client": [
    {
      "client_id": 2,
      "client_name": "Acme Inc.",
      "total_hours": 9.5
    }
  ]
}
```

---

## Error Handling
The API includes proper error handling with meaningful HTTP status codes:
- **403 Forbidden:** Unauthorized access.
- **404 Not Found:** Resource not found.
- **422 Unprocessable Entity:** Validation errors.
- **429 Error:** Too Many Request.
- **500 Error:** Internal Server error.

