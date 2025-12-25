📘 TicketFlow – Architecture & Code Structure
1. Project Overview

TicketFlow is a self-hosted, Jira-like ticket management system built using core PHP with a custom MVC architecture.
It is designed to be lightweight, framework-free, and easy to extend.

The system supports:

User authentication

Project-based ticket management

Status & priority workflows

Ticket assignment

Comments and attachments

Installer-driven database setup

2. Technology Stack

Backend: Core PHP (no framework)

Architecture: MVC (Model–View–Controller)

Database: MySQL (PDO)

Frontend: HTML, Bootstrap, minimal JavaScript

Auth: Session-based authentication

Routing: Custom Router

Deployment: Apache (XAMPP compatible)

3. High-Level Architecture
Browser
   │
   ▼
public/index.php
   │
   ▼
Router
   │
   ▼
Controller
   │
   ▼
Model  ───► Database (MySQL)
   │
   ▼
View (HTML + PHP)
   │
   ▼
Response


Key principle:
Each layer has a single responsibility and does not bypass adjacent layers.

4. Folder Structure
ticketflow/
├── app/
│   ├── controllers/        # Handle HTTP requests & actions
│   ├── models/             # Business logic & database access
│   ├── views/              # UI templates
│   └── core/               # Router, base Controller, DB connection
│
├── config/
│   └── config.php          # App-level configuration
│
├── database/
│   └── ticketflow.sql      # Database schema
│
├── install/
│   └── index.php           # Initial setup / installer
│
├── public/
│   ├── index.php           # Application entry point
│   └── assets/             # CSS, JS, images
│
└── uploads/                # User-uploaded files

5. Application Entry Point
public/index.php

Acts as the front controller

Bootstraps configuration

Initializes the Router

Dispatches requests to controllers

All browser requests are routed through this file.

6. Routing Mechanism
app/core/Router.php

Responsibilities:

Parse the request URI

Map routes to controller actions

Extract route parameters

Dispatch requests securely

Example flow:

/tickets/show/5
→ TicketsController::show(5)


Routing is centralized, preventing direct access to controllers.

7. Controllers

Location:

app/controllers/


Responsibilities:

Validate user input

Enforce access control

Call models

Select views for rendering

Rules:

No SQL in controllers

No HTML generation logic

Controllers coordinate, they do not compute

8. Models

Location:

app/models/


Responsibilities:

Encapsulate database access

Enforce business rules

Use PDO with prepared statements

Return structured data (arrays)

Examples:

Ticket creation & updates

Assignment handling

Status and priority changes

Comment retrieval

Models never render views or handle HTTP logic.

9. Views

Location:

app/views/


Responsibilities:

Render HTML output

Display data provided by controllers

Escape output for security

Constraints:

No direct database access

Minimal logic (loops, conditionals only)

No session or auth logic

10. Database Architecture
Schema file:
database/ticketflow.sql


Design principles:

Normalized tables

Foreign keys for referential integrity

Explicit relationships (users, tickets, projects)

Status & priority handled via constrained values

Typical relationships:

A user can report many tickets

A ticket belongs to a project

A ticket can be assigned to a user

Tickets can have multiple comments

11. Installer
install/index.php

Responsibilities:

Initial database setup

Schema import

First-time configuration

This allows TicketFlow to be deployed without manual SQL execution.

12. Security Considerations

Implemented:

PDO prepared statements (SQL injection protection)

Session-based authentication

Escaped output in views

No public access to /app or /config

Recommended future improvements:

CSRF protection

Role-based access control (RBAC)

Centralized authorization checks

13. Extension Points
Feature	Where to Extend
New page	Controller + View
New business logic	Model
New route	Router
UI changes	View + assets
New DB entity	SQL + Model

The architecture is intentionally extensible without refactoring core files.

14. Known Limitations

No service layer (controllers call models directly)

No REST API layer

No automated test suite yet

No middleware pipeline

These are intentional tradeoffs for simplicity.

15. Planned Improvements

Service layer for complex logic

REST API endpoints

Role & permission system

Event logging / audit trail

Automated documentation generation

Unit & integration tests
