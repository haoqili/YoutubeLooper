create table table1 (
    id      int         not null    auto_increment,
    strid   varchar(10) not null,
    vidid   varchar(20) not null,
    lyrics  text        not null,
    xdim    int(4)      not null    default 500,
    ydim    int(4)      not null    default 400,
    primary key (id)
);
