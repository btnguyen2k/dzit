-- Table to store http sessions
CREATE TABLE http_session (
    session_id              CHAR(32)            NOT NULL,
    session_key             VARCHAR(128)        NOT NULL,
        INDEX (session_key),
    session_timestamp       INT                 NOT NULL,
        INDEX (session_timestamp),
    session_value           LONGTEXT,
    PRIMARY KEY (session_id, session_key)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
