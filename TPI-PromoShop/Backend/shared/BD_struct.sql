drop database promoShop;
Create database promoShop;
Use promoShop;

create table `userCategory`(
	id int unsigned auto_increment primary key,
    categoryType varchar(255) not null unique,
    dateDeleted date default null
);

create table `shopType`(
	id int unsigned auto_increment primary key,
    `type` varchar(255) unique,
    `description` text,
    dateDeleted date default null
);

create table `user`(
	`id` int unsigned auto_increment primary key,
    `email` varchar(255) NOT NULL unique,
    `pass` varchar(255) not null,
    `isAdmin` boolean default null,
    `isOwner` boolean default null,
    dateDeleted date default null,
    emailToken varchar(255) default null unique,
    isEmailVerified boolean,
    idUserCategory int unsigned,
    foreign key (idUserCategory) references userCategory (id) on update cascade
);

create table shop (
	id int unsigned auto_increment primary key,
    `name` varchar(255) not null unique,
    location varchar(255) not null,
    dateDeleted date default null,
    idOwner int unsigned,
    idShopType int unsigned,
    foreign key (idOwner) references `user`(id) on update cascade,
    foreign key (idShopType) references shopType (id) on update cascade
);

create table news(
	id int unsigned auto_increment primary key,
    newsText text not null,
    dateFrom date not null,
    dateTo date not null,
    dateDeleted date default null,
    idAdmin int unsigned,
    idUserCategory int unsigned, 
    foreign key (idAdmin) references `user` (id) on update cascade,
    foreign key (idUserCategory) references userCategory (id) on update cascade
);

create table promotion (
	id int unsigned auto_increment primary key,
    promoText text not null,
    dateFrom date not null,
    dateTo date not null,
    isApproved boolean default null,
    dateDeleted date default null,
    imageUUID varchar(255),
    idShop int unsigned,
    idUserCategory int  unsigned,
    idAdmin int unsigned,
    foreign key (idShop) references shop (id) on update cascade,
    foreign key (idUserCategory) references userCategory (id) on update cascade,
    foreign key (idAdmin) references `user` (id) on update cascade
);

create table promoUse (
	id int unsigned auto_increment primary key,
    useDate date,
    uniqueCode varchar(255),
    wasUser boolean,
    idPromo int unsigned,
    idOwner int unsigned,
    idUser int unsigned,
    foreign key (idOwner) references `user` (id) on update cascade,
	foreign key (idUser) references `user` (id) on update cascade,
    foreign key (idPromo) references promotion (id) on update cascade
);

create table validPromoDay (
	id int unsigned primary key,
    weekDay int unsigned,
    idPromotion int unsigned,
    foreign key (idPromotion) references promotion (id) on update cascade
);

create table shopImages (
	id int unsigned auto_increment primary key,
    imageUUID varchar(255),
    idShop int unsigned,
    foreign key (idShop) references shop (id) on update cascade
);
