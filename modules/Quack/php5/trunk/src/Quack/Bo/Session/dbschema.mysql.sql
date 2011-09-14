-- Tables to store http sessions
DROP TABLE IF EXISTS http_session_entry;
DROP TABLE IF EXISTS http_session;

CREATE TABLE http_session (
    session_id              CHAR(32)            NOT NULL,
    session_timestamp       INT                 NOT NULL,
        INDEX (session_timestamp),
    PRIMARY KEY (session_id)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE http_session_entry (
    session_id              CHAR(32)            NOT NULL,
    session_key             VARCHAR(128)        NOT NULL,
        INDEX (session_key),
    session_value           LONGTEXT,
    PRIMARY KEY (session_id, session_key)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
