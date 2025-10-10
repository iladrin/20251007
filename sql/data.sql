create table user
(
    id       integer not null
        constraint user_pk primary key autoincrement,
    username varchar(255)     not null,
    password varchar(60)      not null,
    roles    varchar(255) default 'user'
);

create index user_username_index
    on user (username);

INSERT INTO user (username, password, roles) VALUES
     ('benoit', '$2y$12$ITKCYuvYhPl8igcfqrmfdebHOpFreAk7MpMiqiCfskoUuRIVABD7S' /* admin */, 'admin,user'),
     ('damien', '$2y$12$YWErUZnGZ4ZRUvA1o9MKuOKWnUjpN/dzc3E8NQVVn0qGMEh35C69y' /* superadmin */, 'user');

