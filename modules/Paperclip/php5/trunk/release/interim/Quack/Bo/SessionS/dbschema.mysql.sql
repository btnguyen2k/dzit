-- Table(s) to store http sessions
DROP TABLE IF EXISTS http_session;

CREATE TABLE http_session (
    session_id                  VARCHAR(32)             NOT NULL,
    session_timestamp           INT                     NOT NULL DEFAULT 0,
        INDEX session_timestamp(session_timestamp),
    session_data               LONGTEXT,
    PRIMARY KEY(session_id)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
