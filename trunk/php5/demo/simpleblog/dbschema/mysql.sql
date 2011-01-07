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
INSERT INTO simpleblog_post (ptitle, pbody, pcreated) VALUES (
    'The title', 
    'This is the post body.', 
    NOW());
INSERT INTO simpleblog_post (ptitle, pbody, pcreated) VALUES ('Dzit Blog', 
    'This is a simple web-based blog to demostrate Dzit Framework. Feel free to use this demo as starting point of your Dzit Framework application.', 
    NOW()+1);
INSERT INTO simpleblog_post (ptitle, pbody, pcreated) VALUES ('Feel free', 
    'You can post new posts or deleting existing ones. The first 3 posts (this one and it''s previous two), however, are protected from deleting.', 
    NOW()+2);
