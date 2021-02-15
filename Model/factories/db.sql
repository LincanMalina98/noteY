
 create table users(
    id int NOT NULL AUTO_INCREMENT,
    name varchar (256),
    email varchar (256) NOT NULL,
    password varchar (256) NOT NULL,
    PRIMARY KEY(id)
);

create table notes(
    id int NOT NULL AUTO_INCREMENT,
    user_id int NOT NULL,
    title varchar(256),
    description text,
    date date,
    file varchar(256),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);
