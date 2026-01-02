# High-Reliability Banking System Architecture 🏦

A backend simulation of a core banking system focused on **data consistency**, **clean architecture**, and **high-load performance**. 

Unlike standard CRUD applications, this project implements advanced design patterns to handle financial transactions securely and reliably.

## 🧠 Architectural Patterns Implemented

###  The Outbox Pattern (Transactional Reliability)
In distributed systems, writing to the database and sending a notification (or calling an external API) are two different steps. If the database succeeds but the API fails, data becomes inconsistent.
* **My Solution:** I implemented the **Transactional Outbox Pattern**. 
* **How it works:** Instead of sending data immediately, the system saves the "event" into an `outbox` database table within the same transaction. A separate background process then reads the outbox and processes the messages reliably.

## ⚡ Performance Testing (JMeter)

Reliability means nothing if the system crashes under load. I used **Apache JMeter** to stress-test the transaction endpoints.

* **Test Scenario:** 1,000 concurrent users initiating transfers simultaneously.
* **Result:** Optimized database locking strategies to prevent "Race Conditions" (Double Spending).
* **Outcome:** Achieved stable response times with zero data corruption.



## 🛠️ Tech Stack

* **Language:** PHP / Laravel
* **Architecture:** Domain-Driven Design (DDD) principles
* **Database:** MySQL (Transaction Management)
* **Testing:** Apache JMeter (Load Testing)

## 🚀 How to Inspect the Code

1.  **Clone the Repo**
    ```bash
    git clone (https://github.com/hasan-devtech/banking-system-architecture.git)
    cd banking-system-architecture
    ```

2.  **Check the Patterns**
    * Navigate to `app/Jobs/ProcessOutbox` to see the **Outbox Worker**.

---
*Focusing on reliability, consistency, and scale.*
