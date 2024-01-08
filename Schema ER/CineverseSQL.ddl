-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Mon Jan  8 10:59:55 2024 
-- * LUN file: C:\Users\bacco\Desktop\CineVerse\Schema ER\concettuale.lun 
-- * Schema: Cineverse logico 1.1/SQL2 
-- ********************************************* 


-- Database Section
-- ________________ 


-- DBSpace Section
-- _______________


-- Tables Section
-- _____________ 

create table COMMENTO (
     Scrive_Username char(20) not null,
     Username char(20) not null,
     IDpost numeric(1) not null,
     Corpo char(50) not null,
     IDcommento numeric(1) not null,
     Ass_Username_Sondaggio char(20),
     Ass_IDpost_Sondaggio numeric(1),
     Ass_Username_Testo char(20),
     Ass_IDpost_Testo numeric(1),
     Ass_Username_Foto_Video char(20),
     Ass_IDpost_Foto_Video numeric(1),
     Padre_Username char(20) not null,
     Padre_IDpost numeric(1) not null,
     Padre_Scrive_Username char(20) not null,
     Padre_IDcommento numeric(1) not null,
     constraint ID_COMMENTO_ID primary key (Username, IDpost, Scrive_Username, IDcommento));

create table LIKE_COMMENTO (
     Username char(20) not null,
     Username_Post char(20) not null,
     IDpost numeric(1) not null,
     Scrive_Username char(20) not null,
     IDcommento numeric(1) not null,
     constraint ID_LIKE_COMMENTO_ID primary key (Username, Username_Post, IDpost, Scrive_Username, IDcommento));

create table LIKE_POST_FOTO_VIDEO (
     Username char(20) not null,
     Post_Username char(20) not null,
     Post_IDpost numeric(1) not null,
     constraint ID_LIKE_POST_FOTO_VIDEO_ID primary key (Username, Post_Username, Post_IDpost));

create table LIKE_POST_TESTUALI (
     Username char(20) not null,
     Post_Username char(20) not null,
     Post_IDpost numeric(1) not null,
     constraint ID_LIKE_POST_TESTUALI_ID primary key (Username, Post_Username, Post_IDpost));

create table LIKE_SONDAGGIO (
     Username char(20) not null,
     Post_Username char(20) not null,
     Post_IDpost numeric(1) not null,
     constraint ID_LIKE_SONDAGGIO_ID primary key (Username, Post_Username, Post_IDpost));

create table OPZIONE (
     Username char(20) not null,
     IDpost numeric(1) not null,
     Testo char(20) not null,
     Selezionato char not null,
     constraint ID_OPZIONE_ID primary key (Username, IDpost, Testo));

create table POST_FOTO_VIDEO (
     Username char(20) not null,
     Titolo char(30) not null,
     IDpost numeric(1) not null,
     Archiviato char not null,
     Foto_Video char(1) not null,
     Descrizione char(50),
     Nome_tag char(20) not null,
     constraint ID_POST_FOTO_VIDEO_ID primary key (Username, IDpost));

create table POST_TESTUALE (
     Username char(20) not null,
     Titolo char(30) not null,
     IDpost numeric(1) not null,
     Archiviato char not null,
     Corpo char(150) not null,
     Nome_tag char(20) not null,
     constraint ID_POST_TESTUALE_ID primary key (Username, IDpost));

create table RELAZIONE (
     Username_Seguito char(20) not null,
     Username_Segue char(20) not null,
     constraint ID_RELAZIONE_ID primary key (Username_Seguito, Username_Segue));

create table SONDAGGIO (
     Username char(20) not null,
     Titolo char(30) not null,
     IDpost numeric(1) not null,
     Archiviato char not null,
     Nome_tag char(20) not null,
     constraint ID_SONDAGGIO_ID primary key (Username, IDpost));

create table TOPIC (
     Nome_tag char(20) not null,
     constraint ID_TOPIC_ID primary key (Nome_tag));

create table TOPIC_UTENTE (
     Nome_tag char(20) not null,
     Username char(20) not null,
     constraint ID_TOPIC_UTENTE_ID primary key (Nome_tag, Username));

create table UTENTE (
     Nome char(20) not null,
     Cognome char(20) not null,
     Username char(20) not null,
     Data_nascita date not null,
     Email char(30) not null,
     Email_di_recupero char(30),
     Password char(20) not null,
     Foto_profilo char(1) not null,
     Sesso char(15),
     Descrizione char(50) not null,
     Foto_background char(1) not null,
     constraint ID_UTENTE_ID primary key (Username));


-- Constraints Section
-- ___________________ 

alter table COMMENTO add constraint REF_COMME_SONDA_FK
     foreign key (Ass_Username_Sondaggio, Ass_IDpost_Sondaggio)
     references SONDAGGIO(Username, IDpost);

alter table COMMENTO add constraint REF_COMME_SONDA_CHK
     check((Ass_Username_Sondaggio is not null and Ass_IDpost_Sondaggio is not null)
           or (Ass_Username_Sondaggio is null and Ass_IDpost_Sondaggio is null)); 

alter table COMMENTO add constraint REF_COMME_POST__1_FK
     foreign key (Ass_Username_Testo, Ass_IDpost_Testo)
     references POST_TESTUALE(Username, IDpost);

alter table COMMENTO add constraint REF_COMME_POST__1_CHK
     check((Ass_Username_Testo is not null and Ass_IDpost_Testo is not null)
           or (Ass_Username_Testo is null and Ass_IDpost_Testo is null)); 

alter table COMMENTO add constraint REF_COMME_POST__FK
     foreign key (Ass_Username_Foto_Video, Ass_IDpost_Foto_Video)
     references POST_FOTO_VIDEO(Username, IDpost);

alter table COMMENTO add constraint REF_COMME_POST__CHK
     check((Ass_Username_Foto_Video is not null and Ass_IDpost_Foto_Video is not null)
           or (Ass_Username_Foto_Video is null and Ass_IDpost_Foto_Video is null)); 

alter table COMMENTO add constraint REF_COMME_UTENT_FK
     foreign key (Scrive_Username)
     references UTENTE(Username);

alter table COMMENTO add constraint REF_COMME_COMME_FK
     foreign key (Padre_Username, Padre_IDpost, Padre_Scrive_Username, Padre_IDcommento)
     references COMMENTO(Username, IDpost, Scrive_Username, IDcommento);

alter table LIKE_COMMENTO add constraint REF_LIKE__UTENT_3
     foreign key (Username)
     references UTENTE(Username);

alter table LIKE_COMMENTO add constraint REF_LIKE__COMME_FK
     foreign key (Username_Post, IDpost, Scrive_Username, IDcommento)
     references COMMENTO(Username, IDpost, Scrive_Username, IDcommento);

alter table LIKE_POST_FOTO_VIDEO add constraint REF_LIKE__UTENT_2
     foreign key (Username)
     references UTENTE(Username);

alter table LIKE_POST_FOTO_VIDEO add constraint REF_LIKE__POST__1_FK
     foreign key (Post_Username, Post_IDpost)
     references POST_FOTO_VIDEO(Username, IDpost);

alter table LIKE_POST_TESTUALI add constraint REF_LIKE__UTENT_1
     foreign key (Username)
     references UTENTE(Username);

alter table LIKE_POST_TESTUALI add constraint REF_LIKE__POST__FK
     foreign key (Post_Username, Post_IDpost)
     references POST_TESTUALE(Username, IDpost);

alter table LIKE_SONDAGGIO add constraint REF_LIKE__UTENT
     foreign key (Username)
     references UTENTE(Username);

alter table LIKE_SONDAGGIO add constraint REF_LIKE__SONDA_FK
     foreign key (Post_Username, Post_IDpost)
     references SONDAGGIO(Username, IDpost);

alter table OPZIONE add constraint EQU_OPZIO_SONDA
     foreign key (Username, IDpost)
     references SONDAGGIO(Username, IDpost);

alter table POST_FOTO_VIDEO add constraint REF_POST__UTENT_1
     foreign key (Username)
     references UTENTE(Username);

alter table POST_FOTO_VIDEO add constraint REF_POST__TOPIC_1_FK
     foreign key (Nome_tag)
     references TOPIC(Nome_tag);

alter table POST_TESTUALE add constraint REF_POST__UTENT
     foreign key (Username)
     references UTENTE(Username);

alter table POST_TESTUALE add constraint REF_POST__TOPIC_FK
     foreign key (Nome_tag)
     references TOPIC(Nome_tag);

alter table RELAZIONE add constraint REF_RELAZ_UTENT_1
     foreign key (Username_Seguito)
     references UTENTE(Username);

alter table RELAZIONE add constraint REF_RELAZ_UTENT_FK
     foreign key (Username_Segue)
     references UTENTE(Username);

alter table SONDAGGIO add constraint REF_SONDA_UTENT
     foreign key (Username)
     references UTENTE(Username);

alter table SONDAGGIO add constraint REF_SONDA_TOPIC_FK
     foreign key (Nome_tag)
     references TOPIC(Nome_tag);

alter table TOPIC_UTENTE add constraint REF_TOPIC_TOPIC
     foreign key (Nome_tag)
     references TOPIC(Nome_tag);

alter table TOPIC_UTENTE add constraint EQU_TOPIC_UTENT_FK
     foreign key (Username)
     references UTENTE(Username);

-- Index Section
-- _____________ 

create unique index ID_COMMENTO_IND
     on COMMENTO (Username, IDpost, Scrive_Username, IDcommento);

create index REF_COMME_SONDA_IND
     on COMMENTO (Ass_Username_Sondaggio, Ass_IDpost_Sondaggio);

create index REF_COMME_POST__1_IND
     on COMMENTO (Ass_Username_Testo, Ass_IDpost_Testo);

create index REF_COMME_POST__IND
     on COMMENTO (Ass_Username_Foto_Video, Ass_IDpost_Foto_Video);

create index REF_COMME_UTENT_IND
     on COMMENTO (Scrive_Username);

create index REF_COMME_COMME_IND
     on COMMENTO (Padre_Username, Padre_IDpost, Padre_Scrive_Username, Padre_IDcommento);

create index REF_LIKE__COMME_IND
     on LIKE_COMMENTO (Username_Post, IDpost, Scrive_Username, IDcommento);

create unique index ID_LIKE_COMMENTO_IND
     on LIKE_COMMENTO (Username, Username_Post, IDpost, Scrive_Username, IDcommento);

create index REF_LIKE__POST__1_IND
     on LIKE_POST_FOTO_VIDEO (Post_Username, Post_IDpost);

create unique index ID_LIKE_POST_FOTO_VIDEO_IND
     on LIKE_POST_FOTO_VIDEO (Username, Post_Username, Post_IDpost);

create index REF_LIKE__POST__IND
     on LIKE_POST_TESTUALI (Post_Username, Post_IDpost);

create unique index ID_LIKE_POST_TESTUALI_IND
     on LIKE_POST_TESTUALI (Username, Post_Username, Post_IDpost);

create index REF_LIKE__SONDA_IND
     on LIKE_SONDAGGIO (Post_Username, Post_IDpost);

create unique index ID_LIKE_SONDAGGIO_IND
     on LIKE_SONDAGGIO (Username, Post_Username, Post_IDpost);

create unique index ID_OPZIONE_IND
     on OPZIONE (Username, IDpost, Testo);

create unique index ID_POST_FOTO_VIDEO_IND
     on POST_FOTO_VIDEO (Username, IDpost);

create index REF_POST__TOPIC_1_IND
     on POST_FOTO_VIDEO (Nome_tag);

create unique index ID_POST_TESTUALE_IND
     on POST_TESTUALE (Username, IDpost);

create index REF_POST__TOPIC_IND
     on POST_TESTUALE (Nome_tag);

create index REF_RELAZ_UTENT_IND
     on RELAZIONE (Username_Segue);

create unique index ID_RELAZIONE_IND
     on RELAZIONE (Username_Seguito, Username_Segue);

create unique index ID_SONDAGGIO_IND
     on SONDAGGIO (Username, IDpost);

create index REF_SONDA_TOPIC_IND
     on SONDAGGIO (Nome_tag);

create unique index ID_TOPIC_IND
     on TOPIC (Nome_tag);

create index EQU_TOPIC_UTENT_IND
     on TOPIC_UTENTE (Username);

create unique index ID_TOPIC_UTENTE_IND
     on TOPIC_UTENTE (Nome_tag, Username);

create unique index ID_UTENTE_IND
     on UTENTE (Username);

