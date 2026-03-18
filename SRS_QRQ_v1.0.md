# Software Requirements Specification

## QRQ – Digital Queue Management System (QRQ Clone)

**Version:** 1.0 – Generated Draft  
**Date:** 2026-03-18  
**Status:** Draft – Awaiting Stakeholder Review  
**Prepared by:** Senior Requirements Engineering (AI-Assisted)  
**Confidentiality:** Internal / Project Team

---

## Revision History

| Version | Date       | Description          | Author         |
|---------|------------|----------------------|----------------|
| 1.0     | 2026-03-18 | Initial draft        | Requirements Team |

---

## Table of Contents

1. [Introduction](#1-introduction)
   - 1.1 Purpose
   - 1.2 Scope
   - 1.3 Definitions, Acronyms, and Abbreviations
   - 1.4 References
   - 1.5 Overview
2. [Overall Description](#2-overall-description)
   - 2.1 Product Perspective
   - 2.2 Product Functions
   - 2.3 User Classes and Characteristics
   - 2.4 Operating Environment
   - 2.5 Design and Implementation Constraints
   - 2.6 Assumptions and Dependencies
3. [Specific Requirements](#3-specific-requirements)
   - 3.1 External Interface Requirements
   - 3.2 Functional Requirements
   - 3.3 Non-Functional Requirements
   - 3.4 Data Requirements / Database Summary
4. [Supporting Information](#4-supporting-information)
   - Use-Case / User Journey Summaries
   - Queue State Machine
   - Glossary
   - Open Questions / Assumptions to Validate

---

# 1. Introduction

## 1.1 Purpose

This Software Requirements Specification (SRS) defines the complete functional and non-functional requirements for **QRQ – Digital Queue Management System**, version 1.0. The document serves as the primary contractual and developmental reference between the product stakeholders, development team, and quality assurance team.

The intended readership includes:
- Software developers and architects implementing the system
- QA engineers writing and executing test plans
- Business stakeholders reviewing feature scope
- System administrators responsible for deployment and operations

This SRS conforms to the structure and principles of **ISO/IEC/IEEE 29148:2018** and **IEEE Std 830-1998** for software requirements specifications.

## 1.2 Scope

**Product Name:** QRQ – Digital Queue Management System  
**Short Name:** QRQ

QRQ is a **web-based, mobile-first, SaaS queue management platform** that enables small-to-medium businesses (clinics, salons, government service counters, eateries, banks, etc.) to replace physical queuing with a **QR-code-driven virtual queue system**.

The system eliminates the need for customers to physically wait at a location by allowing them to:
- Join a virtual queue by scanning a QR code
- Monitor their queue position and estimated wait time remotely via any modern web browser
- Receive real-time push notifications when they are about to be called

The system additionally provides:
- A staff/admin authenticated dashboard for queue control operations
- A public large-screen display page for on-premises signage
- Business and queue configuration management for administrators
- Basic operational analytics

**Target Market:** Small-to-medium businesses in Sri Lanka and similar markets with mobile-first user bases and variable internet connectivity conditions.

**V1.0 Boundaries:**

| In Scope (V1.0) | Out of Scope (Future Versions) |
|---|---|
| Web-based customer queue joining via QR code | Native iOS/Android mobile applications |
| Real-time position & ETA updates | SMS / WhatsApp notifications |
| Staff dashboard for queue control | Appointment / pre-booking hybrid system |
| Public display screen page | Payment processing |
| Web-push notifications | White-label custom domains |
| Business and queue management (admin) | Advanced AI/ML wait-time prediction |
| Basic operational analytics | Multi-language UI (i18n) |
| VAPID-based push notification opt-in | SSO / OAuth login for customers |

## 1.3 Definitions, Acronyms, and Abbreviations

| Term | Definition |
|---|---|
| **QRQ** | The product name: QR Queue system |
| **QR Code** | Quick Response code. A 2D barcode scannable by smartphone cameras. |
| **Ticket** | A virtual queue entry representing one customer's place in a specific queue. |
| **Queue** | A named, ordered list of waiting tickets belonging to a business service. |
| **Business** | An organisation registered in the system corresponding to a real-world service provider (e.g., a clinic or salon). |
| **Slug** | A URL-safe, lowercase, hyphen-separated unique identifier used in route paths (e.g., `city-clinic-general`). |
| **ETA** | Estimated Time of Arrival / Estimated Wait Time, shown to a customer. |
| **Admin** | A registered, authenticated user who manages one or more business profiles and their queues. |
| **Staff** | Synonym for Admin in this context; the person operating the queue dashboard during service hours. |
| **Super Admin** | A platform-level administrator with access to all businesses and system configuration. |
| **Customer** | An unauthenticated end user joining a queue via QR code. |
| **Public Display** | A browser tab or TV screen displaying the currently served ticket and upcoming queue for on-premises signage. |
| **Livewire** | Laravel Livewire — a full-stack reactive component framework. Specific version: 4.1. |
| **Reverb** | Laravel Reverb — a first-party WebSocket server for real-time broadcasting. |
| **VAPID** | Voluntary Application Server Identification — security protocol for Web Push. |
| **SRS** | Software Requirements Specification. |
| **SaaS** | Software as a Service. |
| **InnoDB** | MySQL/MariaDB storage engine with ACID compliance and foreign key support. |
| **PWA** | Progressive Web Application. |
| **NFR** | Non-Functional Requirement. |
| **API** | Application Programming Interface. |
| **HTTPS** | HyperText Transfer Protocol Secure. |

## 1.4 References

| # | Document / Standard |
|---|---|
| [1] | ISO/IEC/IEEE 29148:2018 – Systems and Software Engineering — Life Cycle Processes — Requirements Engineering |
| [2] | IEEE Std 830-1998 – IEEE Recommended Practice for Software Requirements Specifications |
| [3] | Laravel 12 Documentation – https://laravel.com/docs/12.x |
| [4] | Laravel Livewire 4.x Documentation – https://livewire.laravel.com |
| [5] | Laravel Reverb Documentation – https://reverb.laravel.com |
| [6] | Web Push Protocol – RFC 8030 (IETF) |
| [7] | Minishlink/WebPush PHP Library v10.x Documentation |
| [8] | SimpleSoftwareIO/simple-qrcode v4.x Documentation |
| [9] | Laravel Breeze Documentation – https://laravel.com/docs/12.x/starter-kits |
| [10] | OWASP Top 10 Web Application Security Risks (2021) |
| [11] | W3C Web Push API Specification – https://www.w3.org/TR/push-api/ |

## 1.5 Overview

The remainder of this document is structured as follows:

- **Section 2 – Overall Description**: Provides product context, high-level functions, user classes, operational environment, implementation constraints, and assumptions.
- **Section 3 – Specific Requirements**: Contains the full set of functional requirements (grouped by feature area), non-functional requirements with measurable targets, interface requirements, and the data model summary.
- **Section 4 – Supporting Information**: Contains user journey narratives, the ticket state machine, a glossary, and a list of open questions and assumptions requiring stakeholder validation.

---

# 2. Overall Description

## 2.1 Product Perspective

QRQ is a standalone, multi-tenant, web-based SaaS application. It is **not a replacement for an existing system**; rather, it introduces digital queue management where previously only physical queuing (numbered tokens, manual calling) existed.

The system fits into the following broader ecosystem:

```
Customer's Smartphone
       │ (scans QR code → browser)
       ▼
 [Public Web (no auth)]
 /join/{queue-slug}     ─────────────────────────────┐
 /display/{queue-slug}                                │
       │                                              │
       │      WebSocket (Laravel Reverb)              │
       ▼                                              ▼
 [QRQ Web Application]  ◄────────────────  [Admin/Staff Browser]
 Laravel 12 + Livewire                    /admin, /dashboard/{queue-slug}
       │
       ▼
 [MySQL / MariaDB Database]
       │
       ▼
 [Web Push Service (VAPID via minishlink/web-push)]
       │
       ▼
 Customer's Browser Push Notification
```

The system operates as a multi-tenant platform where each **Business** is an isolated tenant with its own queues and staff. Tenants share the same database schema (schema-per-row isolation, not schema-per-tenant).

## 2.2 Product Functions (High-Level)

The primary high-level capabilities of QRQ v1.0 are:

1. **Business & Queue Management** – Authenticated admins can register business profiles and create multiple named queues with unique URL slugs.
2. **QR Code Generation** – The system generates a printable/displayable QR code for each queue, encoding the public join URL.
3. **Customer Queue Joining (Unauthenticated)** – Customers scan a QR code, optionally provide their name and phone number, and receive a virtual ticket with a position number.
4. **Real-Time Customer Status View** – Customers see their current position, ticket status, and estimated wait time, updated in real time via WebSockets.
5. **Public Display Screen** – A large-screen-optimised page displays the currently served ticket and the next waiting tickets for on-premises visibility.
6. **Staff Queue Control Dashboard** – Authenticated staff can call the next customer, mark tickets as served, cancel tickets, and monitor the live waiting list.
7. **Web-Push Notifications** – Customers who grant browser push permission receive notifications when they are approaching the front of the queue.
8. **Basic Analytics** – Admins can view summary statistics including total tickets served, waiting count per queue, and aggregate performance indicators.

## 2.3 User Classes and Characteristics

| User Class | Authentication Required | Technical Proficiency | Primary Device | Primary Concerns |
|---|---|---|---|---|
| **Customer** | No | Low – basic smartphone use | Smartphone (mobile browser) | Ease of joining, position visibility, not missing their turn |
| **Staff / Operator** | Yes (admin role) | Medium – comfortable with web dashboards | Tablet or desktop browser | Fast queue control, clear view of waiting list, minimal errors |
| **Business Admin** | Yes (admin role) | Medium – configures business settings | Desktop / tablet | Business setup, queue configuration, reporting |
| **Super Admin** | Yes (super_admin role) | High – platform-level operations | Desktop | User management, system health, all-business visibility |

> **Note:** In v1.0, Staff and Business Admin share the same authenticated user role (`admin`). A Super Admin role is provisioned via the `role` column of the `users` table but the Super Admin-specific UI is outside v1.0 scope.

## 2.4 Operating Environment

### Server Environment
- **Operating System:** Linux (Ubuntu 22.04 LTS recommended) for production; Windows 10/11 also supported for development.
- **Web Server:** Nginx (reverse proxy) + PHP-FPM, or Apache with `mod_php`.
- **PHP:** 8.2 or later.
- **Database:** MySQL 8.0+ or MariaDB 10.6+, InnoDB storage engine, with foreign key constraints enabled.
- **Node.js:** 18 LTS or later (for Vite asset compilation).
- **WebSocket Server:** Laravel Reverb (self-hosted, included in the project).

### Client Environment
- **Customers:** Any modern mobile browser supporting WebSockets and the Web Push API (Chrome ≥ 80, Firefox ≥ 75, Edge ≥ 80). iOS Safari supported for browsing; push notifications on iOS require Safari 16.4+ with PWA installation.
- **Staff / Admins:** Modern desktop or tablet browser in any of the above families.
- **Public Display:** A modern browser (Chrome recommended) running in full-screen kiosk mode on a TV, monitor, or tablet.
- **Network:** The system must remain functional over 3G mobile data connections (≥ 3 Mbps) and shall degrade gracefully if WebSocket connections are temporarily unavailable.

## 2.5 Design and Implementation Constraints

| # | Constraint |
|---|---|
| C-01 | The backend **must** be built with **Laravel 12** (PHP 8.2+). |
| C-02 | Frontend reactivity **must** use **Livewire 4.1**. Static asset pipeline **must** use **Vite** with Tailwind CSS. |
| C-03 | Real-time events **must** be delivered via **Laravel Reverb** (WebSockets). Third-party WebSocket SaaS (e.g., Pusher) may be used as a fallback only. |
| C-04 | QR code generation **must** use the `simplesoftwareio/simple-qrcode` package. |
| C-05 | Web push notifications **must** use `minishlink/web-push` with VAPID authentication. |
| C-06 | Authentication **must** be implemented with **Laravel Breeze** (session-based, guard-protected routes). |
| C-07 | The database **must** be **MySQL / MariaDB** with the **InnoDB** engine and foreign key enforcement enabled. |
| C-08 | Customer-facing pages (`/join/`, `/display/`) **must not** require user account creation or login. |
| C-09 | Ticket IDs used in public URLs **must not** be guessable. Sequential integer IDs are acceptable only if combined with session-based ownership verification (not URL-only access). |
| C-10 | All HTTP traffic in production **must** be encrypted via HTTPS (TLS 1.2 minimum). |
| C-11 | The UI **must** be mobile-first and responsive, prioritising 360px–430px viewport widths for customer-facing pages. |
| C-12 | Rate limiting **must** be applied to the public queue-joining endpoint to prevent abuse. |

## 2.6 Assumptions and Dependencies

| # | Assumption / Dependency |
|---|---|
| A-01 | Each business operator has a modern browser and a stable internet connection at their premises. |
| A-02 | Customers own a smartphone capable of scanning a QR code (either using the native camera or a third-party app). |
| A-03 | The server environment supports running long-lived WebSocket processes (Reverb) in addition to standard PHP web requests. |
| A-04 | VAPID public/private key pairs are generated and configured in the [.env](file:///c:/Users/HP/Desktop/qrq-clone/.env) file before push notifications are enabled. |
| A-05 | The customer's browser supports the Web Push API (see §2.4). Push notifications are treated as an enhancement, not a primary communication channel. |
| A-06 | All database tables use the InnoDB storage engine (verified as a known past issue and resolved — see migration history). |
| A-07 | A single authenticated user may manage multiple businesses; each business may have multiple queues. |
| A-08 | ETA calculation in v1.0 uses a static average service time figure (10 minutes per person) as no historical data is available at queue creation. |
| A-09 | The platform operates under a single domain with subdirectory-based business separation (slug-based routing), not subdomain-based tenant separation. |
| A-10 | The system is deployed to a single server/VPS in v1.0. Horizontal scaling is a v2.0 concern. |

---

# 3. Specific Requirements

## 3.1 External Interface Requirements

### 3.1.1 User Interfaces

**UI-01: Welcome / Landing Page (`/`)**
- The system shall display a public-facing landing page describing QRQ's value proposition to visitors and business owners.
- The landing page shall include a call-to-action directing business owners to register/log in.
- The page shall be responsive and render correctly on viewports from 360px to 1920px width.

**UI-02: Customer Queue Join Page (`/join/{queue:slug}`)**
- The page shall be accessible without any authentication.
- Before joining: The page shall display the queue name, business name, current waiting count, and a join form with optional name and phone number fields.
- After joining: The page shall display the customer's ticket number (position), their current status, and the estimated wait time.
- The ETA shall update automatically in real time without requiring a full page reload.
- A button shall allow the customer to leave the queue voluntarily.
- The page shall present a browser push notification opt-in prompt after the ticket is successfully created.
- The page layout shall be optimised for single-hand mobile use with minimum touch target sizes of 44×44 CSS pixels.

**UI-03: Public Display Page (`/display/{queue:slug}`)**
- The page shall be accessible without authentication.
- The page shall display in a full-screen-friendly, high-contrast, large-font layout suitable for TV or large monitor viewing.
- The display shall show: the queue name, the currently served ticket identifier/name, and the next 3–5 waiting ticket identifiers.
- All information shall update in real time via WebSocket. If the WebSocket connection is lost, the display shall attempt automatic reconnection.
- The page shall show a status message (e.g., "Queue is open – No customers waiting yet") when the queue is empty.

**UI-04: Admin Login Page (`/admin/login`)**
- The system shall provide a dedicated admin login page separate from normal web navigation.
- The page shall include an email address field, a password field, a "Remember Me" checkbox, and a submit button.
- Failed login attempts shall display a clear validation error message.
- Successful login shall redirect the user to the Admin Dashboard (`/admin`).

**UI-05: Admin Dashboard (`/admin`)**
- The dashboard shall present an overview of all businesses owned by the authenticated user.
- Statistics shown shall include: total number of queues, total tickets currently waiting, and total tickets served today.
- Each business card shall link to its queue management page.

**UI-06: Queue Management Page (`/business/{business:slug}/queues`)**
- The page shall list all queues belonging to the selected business.
- Each queue entry shall link to the Queue Dashboard and the QR code page.
- An "Add Queue" button shall link to the queue creation form.

**UI-07: Queue Dashboard (`/dashboard/{queue:slug}`)**
- The dashboard shall display the full list of waiting tickets ordered by position.
- For each ticket: position number, name (if provided), phone (if provided), joined time, and action buttons shall be visible.
- The actions available to staff shall be: **Call Next** (advance queue to next waiting ticket), **Mark Served** (mark a specific waiting ticket as served), and **Cancel Ticket** (mark a specific waiting ticket as cancelled).
- The currently serving ticket shall be visually distinguished at the top of the view.
- The waiting list shall update in real time without manual page refresh.

**UI-08: QR Code Page (`/queue/{queue:slug}/qr`)**
- The page shall display the generated QR code for the selected queue.
- The QR code shall encode the full public URL of the join page (`/join/{queue-slug}`).
- A download or print option should be available for the QR code image.

**UI-09: Navigation and Layout**
- All admin pages shall share a consistent sidebar navigation layout with links to: Admin Overview, list of owned businesses, and profile management.
- The sidebar shall be collapsible on smaller viewport sizes.
- A dark mode toggle shall be available in the navigation area.

### 3.1.2 Hardware Interfaces

QRQ does not interface with any hardware components directly. The following hardware usage is indirect:

- **QR Code Scanners:** Customers use their smartphone's built-in camera. The system produces the QR code image; scanning is handled by the device OS/camera app.
- **Printers:** The QR code page should be printable using standard browser print functionality. No direct printer API integration is required.
- **Large Screens / TVs:** The Public Display page is opened in a browser on a display device connected to the premises network. No hardware driver integration is required.

### 3.1.3 Software Interfaces

| Interface | Package / Technology | Purpose |
|---|---|---|
| **Database** | MySQL 8.0 / MariaDB 10.6 via Laravel Eloquent ORM | Persistent storage of all application data |
| **WebSocket Server** | Laravel Reverb (self-hosted) | Real-time bidirectional event broadcasting |
| **Push Notification API** | `minishlink/web-push` ^10.0 + W3C Push API | Server-to-browser push notifications via VAPID |
| **QR Code Generation** | `simplesoftwareio/simple-qrcode` ^4.2 | SVG/PNG QR code image generation |
| **Auth Framework** | Laravel Breeze ^2.3 | Session-based authentication scaffolding |
| **Frontend Reactivity** | Livewire ^4.1 | Server-driven UI updates over HTTP/WebSocket |
| **Asset Compilation** | Vite + Tailwind CSS | CSS/JS bundling and hot module replacement |
| **Job/Queue Processing** | Laravel Queue (database driver) | Asynchronous task processing (e.g., push sends) |

### 3.1.4 Communication Interfaces

| Protocol | Usage | Port (default) |
|---|---|---|
| **HTTPS (TLS 1.2+)** | All browser-to-server communication in production | 443 |
| **WebSocket (WSS)** | Reverb real-time events (customer page ↔ dashboard ↔ display) | 8080 (configurable) |
| **Web Push (HTTPS)** | VAPID-authenticated push notifications sent to browser push services (FCM, Mozilla Autopush) | 443 |
| **HTTP** | Development server only (Laravel Artisan serve) | 8000 |

---

## 3.2 Functional Requirements

Requirements are written using SHALL (Must-Have), SHOULD (Should-Have), and COULD (Could-Have / Nice-to-Have) to reflect MoSCoW priority.

### FR-1: Business & Queue Management

**FR-1.1** The system **shall** allow an authenticated user to create a new business profile by providing a business name. The system shall automatically generate a URL-safe slug from the name, ensuring uniqueness across all businesses.

**FR-1.2** The system **shall** associate each business with the authenticated user who created it, so that a user owns and manages only their own businesses.

**FR-1.3** The system **shall** allow an authenticated user to create one or more queues under each of their businesses. Each queue shall require a name, and the system shall auto-generate a unique slug.

**FR-1.4** The system **shall** enforce that queue slugs are unique across the entire platform, as queues are addressed globally by slug in public URLs.

**FR-1.5** The system **shall** allow an authenticated user to view a list of all queues belonging to a specific business.

**FR-1.6** The system **should** allow an authenticated user to edit the name of an existing business or queue.

**FR-1.7** The system **should** allow an authenticated user to delete a queue. All tickets associated with the deleted queue shall be cascade-deleted.

**FR-1.8** The system **should** allow an authenticated user to delete a business. All queues and their tickets shall be cascade-deleted.

**FR-1.9** The system **shall** generate a QR code image for each queue, encoding the full public join URL (`/join/{queue-slug}`). The QR code shall be accessible to the authenticated owner from the QR code page.

**FR-1.10** The system **could** allow the admin to configure a per-queue average service duration (minutes per customer) to improve ETA accuracy.

---

### FR-2: Customer Queue Joining

**FR-2.1** The system **shall** provide a public web page at `/join/{queue-slug}` that allows any visitor to join the corresponding queue without requiring account registration or login.

**FR-2.2** The system **shall** allow a customer to join a queue by submitting the join form (with optional name and optional phone number). On successful submission, the system shall:
  - Create a new [Ticket](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Ticket.php#7-21) record with status `waiting` and assign the next available sequential position number.
  - Store the ticket's ownership in the customer's HTTP session (keyed by `queue_{id}_ticket`).
  - Display the assigned position number, status, and estimated wait time to the customer.
  - Broadcast a [QueueUpdated](file:///c:/Users/HP/Desktop/qrq-clone/app/Livewire/QueueDashboard.php#177-186) event to notify all connected dashboard and display clients.

**FR-2.3** The system **shall** detect if a customer with the same name and phone number already has an active `waiting` ticket in the queue and shall restore that ticket's state rather than creating a duplicate. The customer shall be notified with a "Welcome back" message.

**FR-2.4** The system **shall** display the customer's current position in real time. When the queue advances (a ticket is called or cancelled), the customer's position display shall update automatically via WebSocket without requiring manual page refresh.

**FR-2.5** The system **shall** display an estimated wait time based on the customer's current position and the configured (or default) average service time per customer.

**FR-2.6** The system **shall** allow a customer to voluntarily leave the queue by clicking "Leave Queue." This shall:
  - Update the ticket's status to `cancelled`.
  - Decrement the position of all remaining `waiting` tickets with a higher position number.
  - Broadcast a [QueueUpdated](file:///c:/Users/HP/Desktop/qrq-clone/app/Livewire/QueueDashboard.php#177-186) event.
  - Redirect the customer to the join page in a clean state (ticket ID removed from URL).

**FR-2.7** The customer's ticket ID **shall** only grant them visibility of their own ticket status if they also possess the session-stored ownership record. A customer who guesses a ticket ID in the URL without session ownership shall not be shown ticket details.

**FR-2.8** The system **shall** present a web-push notification permission prompt to the customer after their ticket is successfully created. The customer's push subscription endpoint shall be stored against their ticket record if they grant permission.

**FR-2.9** The system **shall** apply rate limiting to the queue join endpoint to mitigate abuse. The system shall allow no more than **10 join requests per IP address per minute**.

**FR-2.10** The join page **shall** remain usable if the WebSocket connection is unavailable; it shall fall back to a degraded static view and attempt WebSocket reconnection automatically.

---

### FR-3: Real-Time Public Display

**FR-3.1** The system **shall** provide a public web page at `/display/{queue-slug}` that displays the current queue status without requiring any login.

**FR-3.2** The display page **shall** show the following information in real time:
  - The queue name and associated business name.
  - The most recently served ticket identifier (number/name) as "Now Serving."
  - The next 3–5 waiting tickets in order of position as "Up Next."
  - Total number of tickets currently waiting.

**FR-3.3** All display data **shall** update in real time via WebSocket when any queue event occurs (next called, ticket cancelled, new customer joined).

**FR-3.4** The display page **shall** show a friendly status message (e.g., "Queue is open – No customers waiting") when the waiting list is empty.

**FR-3.5** The display layout **shall** use large typography (minimum 2rem for ticket numbers) and high contrast to be legible from a distance of approximately 3 metres.

**FR-3.6** The display page **should** be suitable for use in a kiosk/full-screen browser mode (e.g., no browser chrome-dependent navigation).

---

### FR-4: Staff / Admin Queue Control

**FR-4.1** The system **shall** restrict the queue dashboard (`/dashboard/{queue:slug}`) to authenticated users who own the business to which the queue belongs.

**FR-4.2** The staff dashboard **shall** display the complete list of all `waiting` tickets for a queue, ordered by position ascending.

**FR-4.3** The system **shall** provide a **"Call Next"** action that:
  - Identifies the `waiting` ticket with the lowest position number.
  - Updates that ticket's status to `served`.
  - Decrements the position of all remaining `waiting` tickets with higher position numbers by one.
  - Increments the queue's `current_position` counter.
  - Broadcasts a [QueueUpdated](file:///c:/Users/HP/Desktop/qrq-clone/app/Livewire/QueueDashboard.php#177-186) event.
  - Triggers push notifications to the next 1–3 upcoming waiting customers (if subscribed).

**FR-4.4** The system **shall** provide a **"Mark Served"** action on any individual waiting ticket, applying the same position-decrement and broadcast logic as "Call Next."

**FR-4.5** The system **shall** provide a **"Cancel Ticket"** action on any individual waiting ticket that:
  - Updates the selected ticket's status to `cancelled`.
  - Decrements positions of remaining waiting tickets behind it.
  - Broadcasts a [QueueUpdated](file:///c:/Users/HP/Desktop/qrq-clone/app/Livewire/QueueDashboard.php#177-186) event.
  - Triggers push notifications to the next upcoming customers.

**FR-4.6** The dashboard **shall** update in real time when new customers join from the public join page, without requiring a manual page refresh.

**FR-4.7** The dashboard **shall** display the ticket that is currently being served (most recently called) at a distinct, visually prominent position above the waiting list.

**FR-4.8** The staff dashboard **should** display a confirmation message after each action (e.g., "Called #12 – Ali Hassan").

**FR-4.9** The system **could** provide a **"Recall"** action to re-announce a ticket already marked as served, without advancing the queue position counter further.

---

### FR-5: Notifications

**FR-5.1** The system **shall** support web-push notifications to customers who have granted browser push permission, delivered via the W3C Push API using VAPID authentication.

**FR-5.2** When a "Call Next" or "Mark Served" action is performed, the system **shall** evaluate the next 3 waiting tickets and send a push notification to each subscribed ticket holder, containing:
  - A title: "Queue Update."
  - A body message contextual to their position: "You are next! Please head to the counter." (position 1) or "Your position is now #N. Please stay nearby." (positions 2–3).
  - A URL deep-linking back to their join page with their ticket ID pre-populated.

**FR-5.3** The system **shall** gracefully handle expired or invalid push subscriptions by removing the `push_subscription` data from the ticket record.

**FR-5.4** Push notification delivery **shall** be non-blocking with respect to the staff's queue control actions. Notification send failures must **not** cause the queue operation to fail or roll back.

**FR-5.5** The system **should** supply a `service-worker.js` that the customer's browser can register to receive and display push notifications, even when the join-queue tab is in the background or closed.

**FR-5.6** SMS and WhatsApp notifications are explicitly **out of scope for v1.0**.

---

### FR-6: Statistics & Reporting

**FR-6.1** The system **shall** provide the Admin Dashboard with the following aggregate statistics for the authenticated user's businesses:
  - Total number of active queues.
  - Total tickets currently with `waiting` status across all owned queues.
  - Total tickets with `served` status across all owned queues (all time).

**FR-6.2** The system **should** provide per-queue statistics on the queue dashboard or a dedicated reporting view, including:
  - Total tickets served today.
  - Total tickets cancelled today.
  - Average wait time for served tickets (calculated as the difference between `joined_at` and the `updated_at` timestamp when status changed to `served`).
  - Peak hour indicator (hour with the highest ticket creation count for the current day).

**FR-6.3** The system **could** display an abandonment rate metric (percentage of tickets that were cancelled vs. total tickets created) per queue, per day.

**FR-6.4** Statistics **shall** be computed on-demand from the database and **shall not** require a separate analytics engine in v1.0.

**FR-6.5** The system **could** allow an admin to export daily or historical ticket data for a queue as a CSV file.

---

## 3.3 Non-Functional Requirements

| ID | Category | Requirement | Measurable Target |
|---|---|---|---|
| NFR-01 | **Performance** | Page load time for customer join page (`/join/`) on a 3G connection | Initial load < 3 seconds; subsequent Livewire updates < 1 second |
| NFR-02 | **Performance** | WebSocket event propagation latency (event broadcast to client render) | < 500 milliseconds under normal load |
| NFR-03 | **Performance** | Staff dashboard response to queue action (e.g., "Call Next") | UI update < 2 seconds end-to-end |
| NFR-04 | **Performance** | QR code generation response time | < 1 second from page load |
| NFR-05 | **Scalability** | Concurrent WebSocket connections per queue (public display + customer join pages) | System shall handle ≥ 500 concurrent WebSocket connections per active queue without service degradation |
| NFR-06 | **Scalability** | Total concurrent users across the platform (v1.0 single-server deployment) | System shall remain stable with ≥ 200 concurrent HTTP users platform-wide |
| NFR-07 | **Availability** | System uptime target in production | ≥ 99% uptime measured monthly (excludes scheduled maintenance) |
| NFR-08 | **Availability** | Scheduled maintenance windows | Performed during off-peak hours; users notified ≥ 24 hours in advance |
| NFR-09 | **Security** | Authentication | All admin routes protected by Laravel session auth middleware; unauthenticated access returns HTTP 401/302 |
| NFR-10 | **Security** | Ticket ownership | Ticket status accessible via URL only if the request session contains the owning ticket ID; no brute-force guessability |
| NFR-11 | **Security** | Rate limiting – public join endpoint | Max 10 requests/IP/minute on `POST /join/{slug}`; excess requests receive HTTP 429 |
| NFR-12 | **Security** | HTTPS | All production traffic encrypted via TLS 1.2+; HTTP requests redirected to HTTPS |
| NFR-13 | **Security** | Input validation | All user inputs validated server-side via Laravel Validation; malformed/oversized inputs rejected with HTTP 422 |
| NFR-14 | **Security** | CSRF protection | All state-changing POST/PATCH/DELETE requests protected by Laravel CSRF tokens (Livewire handles this automatically) |
| NFR-15 | **Security** | VAPID key storage | VAPID keys stored in [.env](file:///c:/Users/HP/Desktop/qrq-clone/.env) (not in codebase); never exposed to the client |
| NFR-16 | **Usability** | Mobile-first design | All customer-facing pages fully functional on viewports ≥ 360px width; touch targets ≥ 44×44 CSS px |
| NFR-17 | **Usability** | Accessibility | Core interactive elements shall meet WCAG 2.1 Level AA for contrast ratio (≥ 4.5:1 for normal text) |
| NFR-18 | **Usability** | Error feedback | All user-facing errors displayed within 300ms of the erroneous action, clearly describing the problem and corrective action |
| NFR-19 | **Maintainability** | Code structure | Application follows Laravel conventions: MVC (Livewire components), service classes, Eloquent models with defined relationships |
| NFR-20 | **Maintainability** | Database migrations | All schema changes managed via Laravel migrations with [up()](file:///c:/Users/HP/Desktop/qrq-clone/database/migrations/2026_02_24_142159_create_businesses_table.php#9-21) and [down()](file:///c:/Users/HP/Desktop/qrq-clone/database/migrations/2026_02_24_142207_create_queues_table.php#24-31) methods |
| NFR-21 | **Maintainability** | Dependency management | All PHP dependencies managed via Composer; all JS dependencies via npm; no manual vendor files |
| NFR-22 | **Maintainability** | Logging | Application errors and warnings logged via Laravel's logging system (default: [storage/logs/laravel.log](file:///c:/Users/HP/Desktop/qrq-clone/storage/logs/laravel.log)); log rotation configured |
| NFR-23 | **Localization** | Language | v1.0 UI language is English only; the codebase should use Laravel's localisation helpers (`__()`) for user-visible strings to facilitate future translation |
| NFR-24 | **Localization** | Timezone | All timestamps stored in UTC in the database; displayed times converted to the configured application timezone |
| NFR-25 | **Browser Compatibility** | Supported browsers (customers) | Chrome ≥ 80, Firefox ≥ 75, Edge ≥ 80, Safari ≥ 14 |
| NFR-26 | **Browser Compatibility** | Web Push (customers) | Push notifications supported on Chrome ≥ 80, Firefox ≥ 75, Edge ≥ 80; Safari ≥ 16.4 (PWA mode) |
| NFR-27 | **Data Integrity** | Foreign keys | All referential integrity constraints enforced at the database level via InnoDB foreign keys |
| NFR-28 | **Data Integrity** | Ticket position consistency | The `position` field of `waiting` tickets in a queue shall always form a contiguous, gap-free descending sequence starting at 1 after any queue operation |

---

## 3.4 Data Requirements / Database Summary

### Key Entities

#### 3.4.1 `users` Table

| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Surrogate primary key |
| `name` | VARCHAR(255) | NOT NULL | Display name of the admin user |
| `email` | VARCHAR(255) | NOT NULL, UNIQUE | Login email address |
| `password` | VARCHAR(255) | NOT NULL | Bcrypt-hashed password |
| `role` | VARCHAR(255) | NOT NULL, DEFAULT 'admin' | User role: `admin` or `super_admin` |
| `email_verified_at` | TIMESTAMP | NULLABLE | Email verification timestamp |
| `remember_token` | VARCHAR(100) | NULLABLE | "Remember me" token |
| `created_at` | TIMESTAMP | NOT NULL | Record creation time |
| `updated_at` | TIMESTAMP | NOT NULL | Last update time |

#### 3.4.2 [businesses](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/User.php#35-39) Table

| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Surrogate primary key |
| `user_id` | BIGINT UNSIGNED | FK → `users.id`, CASCADE DELETE | Owning admin user |
| `name` | VARCHAR(191) | NOT NULL | Business display name |
| `slug` | VARCHAR(191) | NOT NULL, UNIQUE | URL-safe identifier |
| `created_at` | TIMESTAMP | NOT NULL | Record creation time |
| `updated_at` | TIMESTAMP | NOT NULL | Last update time |

#### 3.4.3 [queues](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Business.php#18-22) Table

| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Surrogate primary key |
| `business_id` | BIGINT UNSIGNED | FK → `businesses.id`, CASCADE DELETE | Parent business |
| `name` | VARCHAR(191) | NOT NULL | Queue/service name |
| `slug` | VARCHAR(191) | NOT NULL, UNIQUE | Global URL-safe identifier |
| `current_position` | INT | NOT NULL, DEFAULT 0 | Monotonic call counter |
| `created_at` | TIMESTAMP | NOT NULL | Record creation time |
| `updated_at` | TIMESTAMP | NOT NULL | Last update time |

#### 3.4.4 [tickets](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Queue.php#17-21) Table

| Column | Type | Constraints | Description |
|---|---|---|---|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Surrogate primary key |
| `queue_id` | BIGINT UNSIGNED | FK → `queues.id`, CASCADE DELETE | Parent queue |
| `position` | INT | NOT NULL | Current position in the waiting list (1 = next) |
| `name` | VARCHAR(255) | NULLABLE | Customer's optional name |
| `phone` | VARCHAR(255) | NULLABLE | Customer's optional phone number |
| `joined_at` | TIMESTAMP | NOT NULL | When the ticket was created / customer joined |
| `status` | ENUM('waiting','served','cancelled') | NOT NULL, DEFAULT 'waiting' | Ticket lifecycle state |
| `push_subscription` | JSON / TEXT | NULLABLE | Browser push subscription object (endpoint + keys) |
| `created_at` | TIMESTAMP | NOT NULL | Eloquent creation timestamp |
| `updated_at` | TIMESTAMP | NOT NULL | Eloquent last-update timestamp (used for served-time calculation) |

### Entity-Relationship Summary

```
users ──< businesses ──< queues ──< tickets
 1         1..N          1..N        1..N
```

- One **User** can own many **Businesses**.
- One **Business** can have many **Queues**.
- One **Queue** can have many **Tickets**.
- All relationships cascade delete downward.

### Indexes (Recommended)

| Table | Column(s) | Type | Rationale |
|---|---|---|---|
| [businesses](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/User.php#35-39) | `slug` | UNIQUE | Route model binding lookup |
| [businesses](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/User.php#35-39) | `user_id` | INDEX | Admin overview query (`WHERE user_id = ?`) |
| [queues](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Business.php#18-22) | `slug` | UNIQUE | Route model binding lookup |
| [queues](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Business.php#18-22) | `business_id` | INDEX | Business queue listing |
| [tickets](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Queue.php#17-21) | `queue_id, status, position` | COMPOSITE INDEX | Dashboard waiting list query (`WHERE queue_id = ? AND status = 'waiting' ORDER BY position`) |
| [tickets](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Queue.php#17-21) | `queue_id, status, updated_at` | COMPOSITE INDEX | Currently serving lookup (`WHERE status = 'served' ORDER BY updated_at DESC`) |

---

# 4. Supporting Information

## 4.1 High-Level Use-Case / User Journey Summaries

### UC-01: Business Admin Onboarding

**Actor:** Business Admin  
**Goal:** Register, create a business, and set up a queue.

1. Admin navigates to `/admin/login` and enters credentials (or registers via Breeze auth routes).
2. Admin lands on `/admin` (Dashboard Overview).
3. Admin clicks "Create Business" → navigates to `/businesses/create`.
4. Admin enters business name → system generates slug → business record saved.
5. Admin is redirected to `/business/{slug}/queues`.
6. Admin clicks "Add Queue" → navigates to `/business/{slug}/queues/create`.
7. Admin enters queue name → system generates queue slug → queue record saved.
8. Admin navigates to `/queue/{slug}/qr` to view and print/download the QR code.
9. Admin prints and displays QR code at business premises.

**Postcondition:** The QR code is in place; customers can now scan and join.

---

### UC-02: Customer Joins a Queue

**Actor:** Customer  
**Goal:** Secure a position in a virtual queue.

1. Customer scans QR code on their smartphone camera.
2. Browser opens `/join/{queue-slug}` — no login required.
3. Page displays queue name, business name, and current waiting count.
4. Customer optionally enters their name and phone number, then taps "Join Queue."
5. System validates input, creates a [Ticket](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Ticket.php#7-21) record, stores ownership in session.
6. Page transitions to status view: shows position number (e.g., "You are #4"), estimated wait ("About 30 minutes"), and status badge "Waiting."
7. A push notification permission prompt appears; customer may accept or dismiss.
8. Customer leaves the premises or waits nearby.
9. As other tickets are served, the position display updates automatically (e.g., "You are #2 → You are #1 → You are Next!").

**Postcondition:** Customer's ticket is `waiting`; they are notified if/when they are near the front.

---

### UC-03: Staff Operates the Queue

**Actor:** Staff / Admin  
**Goal:** Manage the queue during service hours.

1. Staff logs in at `/admin/login` and navigates to `/dashboard/{queue-slug}`.
2. Dashboard displays the waiting list with ticket details.
3. When ready to serve, staff clicks **"Call Next"**.
4. System marks the first `waiting` ticket as `served`, shifts positions, and broadcasts the update.
5. The customer immediately receives a push notification that they are being called.
6. The Public Display page (if on a TV) updates to show the called ticket as "Now Serving."
7. If a customer does not appear, staff may click **"Cancel Ticket"** on the listed customer.
8. Repeat from step 3 for the next customer.

**Postcondition:** Queue advances; all connected views (display, customer join pages) reflect the new state.

---

### UC-04: Customer Leaves the Queue

**Actor:** Customer  
**Goal:** Exit a queue before being served.

1. Customer opens their join page (already has ticket assigned).
2. Customer taps **"Leave Queue."**
3. System marks ticket as `cancelled`, compresses the position list for remaining waiters, and broadcasts.
4. Customer is redirected to the clean join page (`/join/{slug}`, no ticket in URL).
5. Other customers' position displays automatically update upward.

**Postcondition:** The customer's position is freed; subsequent customers move up.

---

### UC-05: Staff Views Queue Analytics

**Actor:** Business Admin  
**Goal:** Review today's queue performance.

1. Admin logs in and navigates to `/admin`.
2. Overview dashboard shows total waiting and total served across all queues.
3. Admin navigates to a specific queue dashboard or a dedicated analytics view.
4. System displays: tickets served today, tickets cancelled today, average wait time, and peak hour.

**Postcondition:** Admin gains operational insight for staffing decisions.

---

## 4.2 Queue State Machine

Each [Ticket](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Ticket.php#7-21) in the system transitions through the following lifecycle states:

```
                     ┌─────────────────────────────────────────────┐
                     │                                             │
          [Customer joins]                                         │
                     │                                             │
                     ▼                                             │
              ┌─────────────┐                                      │
              │   WAITING   │ ◄── Default state on ticket creation │
              └──────┬──────┘                                      │
                     │                                             │
        ┌────────────┼────────────┐                               │
        │            │            │                               │
        ▼            ▼            ▼                               │
  [Staff calls   [Staff marks  [Customer                          │
   next / marks   served        leaves queue /                    │
   served]        directly]     staff cancels]                    │
        │            │            │                               │
        ▼            ▼            ▼                               │
   ┌─────────┐  ┌─────────┐  ┌───────────┐                       │
   │  SERVED │  │  SERVED │  │ CANCELLED │                        │
   └─────────┘  └─────────┘  └───────────┘                       │
      (terminal)  (terminal)   (terminal)  ──────────────────────┘
```

**State Descriptions:**

| State | Description | Transitions In | Transitions Out |
|---|---|---|---|
| `waiting` | Ticket is active; customer is in queue | `Ticket::create()` | → `served`, → `cancelled` |
| `served` | Ticket has been called and the customer served | Staff action: "Call Next" or "Mark Served" | None (terminal) |
| `cancelled` | Ticket removed from queue (customer left or staff cancelled) | Customer: "Leave Queue"; Staff: "Cancel Ticket" | None (terminal) |

**State Transition Rules:**
1. Only `waiting` tickets appear in the active waiting list on dashboards and displays.
2. Position numbers are only maintained for `waiting` tickets; served and cancelled tickets retain their original `position` value as a historical record.
3. When a ticket moves from `waiting` to any terminal state, all remaining `waiting` tickets with a higher `position` value are decremented by 1 to maintain a gap-free sequence.
4. The `queue.current_position` counter increments only when a ticket is transitioned to `served` (not on cancellation).

---

## 4.3 Glossary

| Term | Definition |
|---|---|
| **Abandonment Rate** | The percentage of created tickets that were cancelled (by the customer or staff) vs. the total tickets created in a given period. Formula: [(cancelled / total) × 100](file:///c:/Users/HP/Desktop/qrq-clone/database/migrations/2026_02_24_142159_create_businesses_table.php#9-21). |
| **Average Wait Time** | The mean duration between a ticket's `joined_at` timestamp and the `updated_at` timestamp at the moment its status was changed to `served`. |
| **Business** | A registered entity in QRQ (e.g., "City Clinic") that owns one or more queues. Maps to the [businesses](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/User.php#35-39) database table. |
| **Broadcast** | The act of emitting a [QueueUpdated](file:///c:/Users/HP/Desktop/qrq-clone/app/Livewire/QueueDashboard.php#177-186) event via Laravel Reverb's WebSocket server, which all connected clients of that queue receive and react to. |
| **Current Position** | A monotonically increasing counter (`queues.current_position`) tracking how many tickets have been served. Used for reporting, not for customer position display. |
| **ETA** | Estimated Time of Arrival (colloquially: estimated wait time). In v1.0, calculated as [(position - 1) × avgMinutesPerPerson](file:///c:/Users/HP/Desktop/qrq-clone/database/migrations/2026_02_24_142159_create_businesses_table.php#9-21). |
| **Gap-Free Sequence** | The invariant that `waiting` ticket positions in a queue always form a continuous sequence 1, 2, 3, … N with no gaps, maintained by decrementing positions after each removal. |
| **InnoDB** | The MySQL/MariaDB storage engine used by QRQ. Required for foreign key constraint enforcement and ACID transactions. |
| **Position** | An integer field on a [Ticket](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Ticket.php#7-21) representing the customer's place in the queue. Position 1 = next to be served. |
| **Push Subscription** | A JSON object (containing endpoint, p256dh key, and auth key) generated by the browser's Push API and stored on the ticket. Used by the server to deliver push notifications via VAPID. |
| **Queue** | A named service line within a business (e.g., "General Consultation," "Haircuts"). Maps to the [queues](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Business.php#18-22) database table. |
| **Queue Slug** | A globally unique, URL-safe string identifier for a queue. Used in public-facing URLs (`/join/{slug}`, `/display/{slug}`). |
| **Reverb** | Laravel Reverb — the first-party self-hosted WebSocket server used for broadcasting real-time events. |
| **Route Model Binding** | A Laravel feature that automatically resolves Eloquent models from route parameters by their specified column (e.g., `{queue:slug}` resolves a Queue by its `slug` column). |
| **Session Ownership** | A server-side mechanism whereby a customer's ticket ID is stored in their PHP session (`queue_{id}_ticket`), used to authenticate ticket status display without requiring user accounts. |
| **Slug** | A URL-friendly string derived from a name (lowercase, spaces replaced with hyphens). Example: "City Clinic" → `city-clinic`. |
| **VAPID** | Voluntary Application Server Identification. A standard (RFC 8292) for authenticating push notification servers to push services without requiring a service-specific registration. |
| **WebSocket** | A bi-directional, persistent communication protocol over TCP. Used by QRQ (via Reverb) to push queue updates to connected browser clients in real time. |

---

## 4.4 Open Questions / Assumptions to Validate

The following items represent unresolved design decisions or assumptions that require confirmation from stakeholders before development of the affected feature areas is finalised.

| # | Category | Open Question / Assumption |
|---|---|---|
| OQ-01 | **Security** | The current implementation uses sequential integer IDs for tickets in the URL (`?ticket=12`). The session ownership check provides protection, but should ticket IDs be UUIDs or other non-sequential tokens to further reduce attack surface? Decision needed before v1.0 launch. |
| OQ-02 | **ETA Calculation** | ETA is currently hardcoded at 10 minutes per person. Should this be configurable per queue (an admin setting field on the [queues](file:///c:/Users/HP/Desktop/qrq-clone/app/Models/Business.php#18-22) table), and if so, what is the default? |
| OQ-03 | **Multi-Staff / Roles** | Can multiple staff accounts belong to the same business without also being the business owner? The current model ties each business directly to the creating `user_id`. A `business_users` pivot table may be needed if staff separation is required. |
| OQ-04 | **Queue State (Open/Closed)** | Should a queue have an explicit `is_open` / `is_active` status flag that admins can toggle? Currently there is no way to mark a queue as "closed for the day" without deleting it. |
| OQ-05 | **Daily Reset** | Should ticket positions and the `current_position` counter reset at the start of each business day? If so, what mechanism triggers this reset (scheduled command, manual admin action)? |
| OQ-06 | **Ticket Number Format** | Is the customer's "ticket number" their `position` in the current waiting list (dynamic, changes as others are served) or a fixed sequential integer assigned at join time (stable, does not change)? The current implementation uses `position` which changes. Clarity needed for display and notification copy. |
| OQ-07 | **Data Retention** | How long should historical ticket records (served/cancelled) be retained in the database? Is there a GDPR/privacy implication for storing customer names and phone numbers? |
| OQ-08 | **Super Admin UI** | Section 2.3 identifies a Super Admin role. What specific capabilities, routes, and UI pages are required for Super Admin in v1.0? Currently no Super Admin UI is implemented. |
| OQ-09 | **Public Display Auth** | The `/display/{slug}` page is fully public. Should it be possible to password-protect or token-protect a display URL to prevent competitors or unauthorised viewers from monitoring queue status? |
| OQ-10 | **Notification Timing** | Currently, push notifications are sent to the top 3 waiting customers after every "Call Next" action. Should there be configurable thresholds (e.g., "notify when within 5 of being called"), or is the top-3 policy fixed? |
| OQ-11 | **Peak Hour Definition** | "Peak hour" is listed as a Should-Have analytic (FR-6.2). The definition assumed here is: the clock hour (0–23) with the highest count of ticket creations for the current day. Is this the correct business interpretation? |
| OQ-12 | **WebSocket Infrastructure** | In production, Reverb runs as a separate long-lived process alongside PHP-FPM. Has the hosting environment (VPS/shared hosting) been verified to support this? Shared hosting may prohibit long-lived TCP processes. |

---

*End of Document*

---

> **Document Control:** This SRS is a living document. All changes after v1.0 approval shall be tracked in the Revision History table at the head of this document. Functional changes discovered during development that contradict this specification shall be escalated and resolved before implementation proceeds.
