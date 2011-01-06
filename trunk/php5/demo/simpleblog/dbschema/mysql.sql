#Db schema for demo aplication
#DBMS: MySQL

#Table to store blog posts
DROP TABLE IF EXISTS simpleblog_post;
CREATE TABLE simpleblog_post (
    pid                 INT                 AUTO_INCREMENT,
    ptitle              VARCHAR(128),
    pbody               TEXT,
    pcreated            DATETIME,
    pmodified           DATETIME,
    PRIMARY KEY (pid)
) DEFAULT CHARSET=utf8;

#Some sample data
INSERT INTO simpleblog_post (ptitle, pbody, pcreated) VALUES ('The title', 'This is the post body.', NOW());
INSERT INTO simpleblog_post (ptitle, pbody, pcreated) VALUES ('A title once again', 'And the post body follows.', NOW());
INSERT INTO simpleblog_post (ptitle, pbody, pcreated) VALUES ('Title strikes back', 'This is really exciting! Not.', NOW());
