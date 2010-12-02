#Db schema for demo aplication
#DBMS: MySQL

#Table to store blog posts
CREATE TABLE dzit_post (
    pid                 INT                 AUTO_INCREMENT
    ptitle              VARCHAR(128),
    pbody               TEXT,
    pcreated            DATETIME,
    pmodified           DATETIME,
    PRIMARY KEY (pid)
);

#Some sample data
INSERT INTO posts (ptitle, pbody, pcreated) VALUES ('The title', 'This is the post body.', NOW());
INSERT INTO posts (ptitle, pbody, pcreated) VALUES ('A title once again', 'And the post body follows.', NOW());
INSERT INTO posts (ptitle, pbody, pcreated) VALUES ('Title strikes back', 'This is really exciting! Not.', NOW());
