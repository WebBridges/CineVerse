-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Tue Jan 16 16:26:37 2024 
-- * LUN file: C:\Users\bacco\Desktop\CineVerse\Schema ER\concettuale.lun 
-- * Schema: Cineverse logico 2.2/SQL 
-- ********************************************* 


-- Database Section
-- ________________ 

create database Cineverse;


-- DBSpace Section
-- _______________


-- Tables Section
-- _____________ 

create table COMMENTO (
     Post_Username_Utente char(30) not null,
     Post_IDpost numeric(1) not null,
     Username_Utente char(30) not null,
     Corpo char(50) not null,
     IDcommento numeric(1) not null,
     Padre_Post_Username_Utente char(30) not null,
     Padre_Post_IDpost numeric(1) not null,
     Padre_Username_Utente char(30) not null,
     Padre_IDcommento numeric(1) not null,
     constraint ID_COMMENTO_ID primary key (Post_Username_Utente, Post_IDpost, Username_Utente, IDcommento));

create table FOTO_VIDEO (
     Post_Username_Utente char(30) not null,
     Post_IDpost numeric(1) not null,
     Foto_Video char(1) not null,
     Descrizione char(50),
     constraint ID_FOTO_VIDEO_ID primary key (Post_Username_Utente, Post_IDpost, Foto_Video),
     constraint SID_FOTO__POST_ID unique (Post_Username_Utente, Post_IDpost));

create table LIKE_COMMENTO (
     Post_Username_Utente char(30) not null,
     Post_IDpost numeric(1) not null,
     Commento_Username_Utente char(30) not null,
     IDcommento numeric(1) not null,
     Like_Username_Utente char(30) not null,
     constraint ID_LIKE_COMMENTO_ID primary key (Post_Username_Utente, Post_IDpost, Commento_Username_Utente, IDcommento, Like_Username_Utente));

create table LIKE_POST (
     Post_Username_Utente char(30) not null,
     Post_IDpost numeric(1) not null,
     Username_Utente char(30) not null,
     constraint ID_LIKE_POST_ID primary key (Post_Username_Utente, Post_IDpost, Username_Utente));

create table OPZIONE (
     Post_Username_Utente char(30) not null,
     Post_IDpost numeric(1) not null,
     Testo char(30) not null,
     Selezionato char not null,
     constraint ID_OPZIONE_ID primary key (Post_Username_Utente, Post_IDpost, Testo));

create table POST (
     Username_Utente char(30) not null,
     Titolo char(50) not null,
     IDpost numeric(1) not null,
     Archiviato char not null,
     Nome_tag_Topic char(30) not null,
     constraint ID_POST_ID primary key (Username_Utente, IDpost));

create table RELAZIONE (
     Username_Seguito char(30) not null,
     Username_Segue char(30) not null,
     constraint ID_RELAZIONE_ID primary key (Username_Seguito, Username_Segue));

create table TESTO (
     Post_Username_Utente char(30) not null,
     Post_IDpost numeric(1) not null,
     Corpo char(150) not null,
     constraint ID_TESTO_ID primary key (Post_Username_Utente, Post_IDpost, Corpo),
     constraint SID_TESTO_POST_ID unique (Post_Username_Utente, Post_IDpost));

create table TOPIC (
     Nome_tag char(30) not null,
     constraint ID_TOPIC_ID primary key (Nome_tag));

create table TOPIC_UTENTE (
     Username char(30) not null,
     Nome_tag char(30) not null);

create table UTENTE (
     Nome char(30) not null,
     Cognome char(30) not null,
     Username char(30) not null,
     Data_nascita date not null,
     Email char(50) not null,
     Email_di_recupero char(50),
     Password char(30) not null,
     Foto_profilo char(1) not null,
     Sesso char(30),
     Descrizione char(50) not null,
     Foto_background char(1) not null,
     constraint ID_UTENTE_ID primary key (Username));


-- Constraints Section
-- ___________________ 

alter table COMMENTO add constraint REF_COMME_UTENT_FK
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table COMMENTO add constraint REF_COMME_POST
     foreign key (Post_Username_Utente, Post_IDpost)
     references POST(Username_Utente, IDpost);

alter table COMMENTO add constraint REF_COMME_COMME_FK
     foreign key (Padre_Post_Username_Utente, Padre_Post_IDpost, Padre_Username_Utente, Padre_IDcommento)
     references COMMENTO(Post_Username_Utente, Post_IDpost, Username_Utente, IDcommento);

alter table FOTO_VIDEO add constraint SID_FOTO__POST_FK
     foreign key (Post_Username_Utente, Post_IDpost)
     references POST(Username_Utente, IDpost);

alter table LIKE_COMMENTO add constraint REF_LIKE__COMME
     foreign key (Post_Username_Utente, Post_IDpost, Commento_Username_Utente, IDcommento)
     references COMMENTO(Post_Username_Utente, Post_IDpost, Username_Utente, IDcommento);

alter table LIKE_COMMENTO add constraint REF_LIKE__UTENT_1_FK
     foreign key (Like_Username_Utente)
     references UTENTE(Username);

alter table LIKE_POST add constraint REF_LIKE__POST
     foreign key (Post_Username_Utente, Post_IDpost)
     references POST(Username_Utente, IDpost);

alter table LIKE_POST add constraint REF_LIKE__UTENT_FK
     foreign key (Username_Utente)
     references UTENTE(Username);

alter table OPZIONE add constraint REF_OPZIO_POST
     foreign key (Post_Username_Utente, Post_IDpost)
     references POST(Username_Utente, IDpost);

alter table POST add constraint REF_POST_UTENT
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
     foreign key (Post_Username_Utente, Post_IDpost)
     references POST(Username_Utente, IDpost);

alter table TOPIC_UTENTE add constraint EQU_TOPIC_UTENT_FK
     foreign key (Username)
     references UTENTE(Username);

alter table TOPIC_UTENTE add constraint REF_TOPIC_TOPIC_FK
     foreign key (Nome_tag)
     references TOPIC(Nome_tag);

alter table UTENTE add constraint ID_UTENTE_CHK
     add check(exists(select * from TOPIC_UTENTE
                  where TOPIC_UTENTE.Username = Username)); 


-- Index Section
-- _____________ 

create unique index ID_COMMENTO_IND
     on COMMENTO (Post_Username_Utente, Post_IDpost, Username_Utente, IDcommento);

create index REF_COMME_UTENT_IND
     on COMMENTO (Username_Utente);

create index REF_COMME_COMME_IND
     on COMMENTO (Padre_Post_Username_Utente, Padre_Post_IDpost, Padre_Username_Utente, Padre_IDcommento);

create unique index ID_FOTO_VIDEO_IND
     on FOTO_VIDEO (Post_Username_Utente, Post_IDpost, Foto_Video);

create index REF_LIKE__UTENT_1_IND
     on LIKE_COMMENTO (Like_Username_Utente);

create unique index ID_LIKE_COMMENTO_IND
     on LIKE_COMMENTO (Post_Username_Utente, Post_IDpost, Commento_Username_Utente, IDcommento, Like_Username_Utente);

create index REF_LIKE__UTENT_IND
     on LIKE_POST (Username_Utente);

create unique index ID_LIKE_POST_IND
     on LIKE_POST (Post_Username_Utente, Post_IDpost, Username_Utente);

create unique index ID_OPZIONE_IND
     on OPZIONE (Post_Username_Utente, Post_IDpost, Testo);

create unique index ID_POST_IND
     on POST (Username_Utente, IDpost);

create index REF_POST_TOPIC_IND
     on POST (Nome_tag_Topic);

create index REF_RELAZ_UTENT_IND
     on RELAZIONE (Username_Segue);

create unique index ID_RELAZIONE_IND
     on RELAZIONE (Username_Seguito, Username_Segue);

create unique index ID_TESTO_IND
     on TESTO (Post_Username_Utente, Post_IDpost, Corpo);

create unique index ID_TOPIC_IND
     on TOPIC (Nome_tag);

create index EQU_TOPIC_UTENT_IND
     on TOPIC_UTENTE (Username);

create index REF_TOPIC_TOPIC_IND
     on TOPIC_UTENTE (Nome_tag);

create unique index ID_UTENTE_IND
     on UTENTE (Username);

