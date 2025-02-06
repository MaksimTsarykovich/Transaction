CREATE TABLE transactions
(
    `id`          INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `date`        DATE                           NOT NULL,
    `check`       VARCHAR(55),
    `description` VARCHAR(255) UNIQUE            NOT NULL,
    `amount`      INT                            NOT NULL,
    `is_positive` BOOL                           NOT NULL
);
