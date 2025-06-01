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

```bash
php artisan queue:table
php artisan migrate
```

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

---

## 🔐 API Authentication (Sanctum)

* All API routes (except login/register) are protected by **Laravel Sanctum**.
* Use `/api/register` and `/api/login` to get an access token.
* Attach `Authorization: Bearer {token}` header for all authenticated routes.

---

## Database Structure & Seeding

### Tables

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

---

## Postman Collection

You’ll find the Postman collection in the project root:

<!-- ```
/Freelance-TimeTracker-API.postman_collection.json
``` -->

Import it in Postman to test all endpoints easily.

---

