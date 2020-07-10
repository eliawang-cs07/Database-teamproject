create table guestbook
(
  no int auto_increment primary key,
  name char(20),
  subject char(50),
  content text(500),
  time datetime
 );
