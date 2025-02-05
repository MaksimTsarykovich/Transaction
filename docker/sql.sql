CREATE DATABASE app;

USE app;

CREATE TABLE transactions
(
    `id`          INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `data`        VARCHAR(55)                    NOT NULL,
    `check`       VARCHAR(55),
    `description` VARCHAR(255) UNIQUE            NOT NULL,
    `amount`      INT                            NOT NULL,
    `is_positive` BOOL                           NOT NULL
);

ALTER TABLE transactions
    MODIFY description VARCHAR(255) UNIQUE;

ALTER TABLE transactions
    CHANGE  `data` `date` VARCHAR(255);

INSERT INTO `transactions`(`data`, `check`, `description`, `amount`, `is_positive`)
VALUES ('11', '222', '333', 12, false);

TRUNCATE transactions;

SELECT SUM(amount) AS net_total
FROM transactions;

SELECT SUM(amount) AS income_total
FROM transactions
WHERE amount > 0;

SELECT SUM(amount) AS expense_total
FROM transactions
WHERE amount < 0;

ALTER TABLE `transactions`
    ADD COLUMN is_positive BOOL;
