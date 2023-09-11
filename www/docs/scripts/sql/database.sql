CREATE DATABASE okr;

use okr;

CREATE TABLE user
(
    id         INT(10) unsigned NOT NULL auto_increment,
    name       VARCHAR(45)      NOT NULL,
    email      VARCHAR(80)      NOT NULL,
    password   VARCHAR(80)      NOT NULL,
    created_at DATETIME         NOT NULL DEFAULT NOW(),
    updated_at DATETIME         NOT NULL DEFAULT NOW(),
    deleted_at DATETIME,
    PRIMARY KEY (id)
);

CREATE TABLE objective
(
    id          INT(10) unsigned NOT NULL auto_increment,
    user_id     INT(10) unsigned NOT NULL,
    title       VARCHAR(80)      NOT NULL,
    description longtext         NOT NULL,
    status      tinyint(1)       DEFAULT 0,
    created_at  DATETIME         NOT NULL DEFAULT NOW(),
    updated_at  DATETIME         NOT NULL DEFAULT NOW(),
    deleted_at  DATETIME,
    PRIMARY KEY (id),
    CONSTRAINT fk_objective_user FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE INDEX fk_user_id_idx ON objective (user_id);

CREATE TABLE key_result
(
    id           INT(10) unsigned NOT NULL auto_increment,
    objective_id INT(10) unsigned NOT NULL,
    title        VARCHAR(80)      NOT NULL,
    description  VARCHAR(255)     NOT NULL,
    type         enum ('1', '2')  NOT NULL comment "1: Milestone 2: Porcentagem",
    created_at   DATETIME         NOT NULL DEFAULT NOW(),
    updated_at   DATETIME         NOT NULL DEFAULT NOW(),
    deleted_at   DATETIME,
    PRIMARY KEY (id),
    CONSTRAINT fk_key_result_objective FOREIGN KEY (objective_id) REFERENCES objective (id) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE INDEX fk_objective_id_idx ON key_result (objective_id);