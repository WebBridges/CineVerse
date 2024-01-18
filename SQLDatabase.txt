-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Thu Jan 18 23:17:11 2024 
-- * LUN file: C:\xampp\htdocs\CineVerse\Schema ER\concettuale.lun 
-- * Schema: Cineverse logico 3.2/SQL 
-- ********************************************* 


-- Database Section
-- ________________ 


-- DBSpace Section
-- _______________


-- Tables Section
-- _____________ 

create table COMMENTO (
     Corpo varchar(50) not null,
     IDcommento integer auto_increment not null,
     IDpost integer not null,
     Username_Utente varchar(30) not null,
     IDcommento_Padre integer,
     constraint ID_COMMENTO_ID primary key (IDcommento));

create table FOTO_VIDEO (
     IDpost_foto_video integer auto_increment not null,
     IDpost integer not null,
     Foto_Video longblob not null,
     Descrizione varchar(50),
     constraint ID_FOTO_VIDEO_ID primary key (IDpost_foto_video),
     constraint SID_FOTO__POST_ID unique (IDpost));

create table LIKE_COMMENTO (
     IDcommento integer not null,
     Username_Utente varchar(30) not null,
     constraint ID_LIKE_COMMENTO_ID primary key (IDcommento, Username_Utente));

create table LIKE_POST (
     IDpost integer not null,
     Username_Utente varchar(30) not null,
     constraint ID_LIKE_POST_ID primary key (IDpost, Username_Utente));

create table OPZIONE (
     IDpost integer not null,
     Testo varchar(30) not null,
     Selezionato boolean not null,
     constraint ID_OPZIONE_ID primary key (IDpost, Testo));

create table POST (
     Titolo varchar(50) not null,
     IDpost integer auto_increment not null,
     Archiviato boolean not null,
     Username_Utente varchar(30) not null,
     Nome_tag_Topic varchar(30),
     constraint ID_POST_ID primary key (IDpost));

create table RELAZIONE (
     Username_Seguito varchar(30) not null,
     Username_Segue varchar(30) not null,
     constraint ID_RELAZIONE_ID primary key (Username_Seguito, Username_Segue));

create table TESTO (
     IDpost_testo integer auto_increment not null,
     IDpost integer not null,
     Corpo varchar(150) not null,
     constraint ID_TESTO_ID primary key (IDpost_testo),
     constraint SID_TESTO_POST_ID unique (IDpost));

create table TOPIC (
     Nome_tag varchar(30) not null,
     constraint ID_TOPIC_ID primary key (Nome_tag));

create table TOPIC_UTENTE (
     Username_Utente varchar(30) not null,
     Nome_tag_Topic varchar(30) not null,
     constraint ID_TOPIC_UTENTE_ID primary key (Username_Utente, Nome_tag_Topic));

create table UTENTE (
     Nome varchar(30) not null,
     Cognome varchar(30) not null,
     Username varchar(30) not null,
     Data_nascita date not null,
     Email varchar(50) not null,
     Email_di_recupero varchar(50),
     Password varchar(30) not null,
     Foto_profilo mediumblob not null,
     Sesso varchar(30),
     Descrizione varchar(50) not null,
     Foto_background mediumblob not null,
     constraint ID_UTENTE_ID primary key (Username));


-- Constraints Section
-- ___________________ 

alter table COMMENTO add constraint REF_COMME_POST_FK
     foreign key (IDpost)
     references POST(IDpost);

alter table COMMENTO add constraint REF_COMME_UTENT_FK
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table COMMENTO add constraint REF_COMME_COMME_FK
     foreign key (IDcommento_Padre)
     references COMMENTO(IDcommento);

alter table FOTO_VIDEO add constraint SID_FOTO__POST_FK
     foreign key (IDpost)
     references POST(IDpost);

alter table LIKE_COMMENTO add constraint REF_LIKE__COMME
     foreign key (IDcommento)
     references COMMENTO(IDcommento);

alter table LIKE_COMMENTO add constraint REF_LIKE__UTENT_1_FK
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table LIKE_POST add constraint REF_LIKE__POST
     foreign key (IDpost)
     references POST(IDpost);

alter table LIKE_POST add constraint REF_LIKE__UTENT_FK
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table OPZIONE add constraint REF_OPZIO_POST
     foreign key (IDpost)
     references POST(IDpost);

alter table POST add constraint REF_POST_UTENT_FK
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table POST add constraint REF_POST_TOPIC_FK
     foreign key (Nome_tag_Topic)
     references TOPIC(Nome_tag);

alter table RELAZIONE add constraint REF_RELAZ_UTENT_1
     foreign key (Username_Seguito)
     references UTENTE(Username);

alter table RELAZIONE add constraint REF_RELAZ_UTENT_FK
     foreign key (Username_Segue)
     references UTENTE(Username);

alter table TESTO add constraint SID_TESTO_POST_FK
     foreign key (IDpost)
     references POST(IDpost);

alter table TOPIC_UTENTE add constraint EQU_TOPIC_UTENT
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table TOPIC_UTENTE add constraint REF_TOPIC_TOPIC_FK
     foreign key (Nome_tag_Topic)
     references TOPIC(Nome_tag);


-- Index Section
-- _____________ 

create unique index ID_COMMENTO_IND
     on COMMENTO (IDcommento);

create index REF_COMME_POST_IND
     on COMMENTO (IDpost);

create index REF_COMME_UTENT_IND
     on COMMENTO (Username_Utente);

create index REF_COMME_COMME_IND
     on COMMENTO (IDcommento_Padre);

create unique index ID_FOTO_VIDEO_IND
     on FOTO_VIDEO (IDpost_foto_video);

create unique index SID_FOTO__POST_IND
     on FOTO_VIDEO (IDpost);

create index REF_LIKE__UTENT_1_IND
     on LIKE_COMMENTO (Username_Utente);

create unique index ID_LIKE_COMMENTO_IND
     on LIKE_COMMENTO (IDcommento, Username_Utente);

create index REF_LIKE__UTENT_IND
     on LIKE_POST (Username_Utente);

create unique index ID_LIKE_POST_IND
     on LIKE_POST (IDpost, Username_Utente);

create unique index ID_OPZIONE_IND
     on OPZIONE (IDpost, Testo);

create unique index ID_POST_IND
     on POST (IDpost);

create index REF_POST_UTENT_IND
     on POST (Username_Utente);

create index REF_POST_TOPIC_IND
     on POST (Nome_tag_Topic);

create index REF_RELAZ_UTENT_IND
     on RELAZIONE (Username_Segue);

create unique index ID_RELAZIONE_IND
     on RELAZIONE (Username_Seguito, Username_Segue);

create unique index ID_TESTO_IND
     on TESTO (IDpost_testo);

create unique index SID_TESTO_POST_IND
     on TESTO (IDpost);

create unique index ID_TOPIC_IND
     on TOPIC (Nome_tag);

create index REF_TOPIC_TOPIC_IND
     on TOPIC_UTENTE (Nome_tag_Topic);

create unique index ID_TOPIC_UTENTE_IND
     on TOPIC_UTENTE (Username_Utente, Nome_tag_Topic);

create unique index ID_UTENTE_IND
     on UTENTE (Username);

