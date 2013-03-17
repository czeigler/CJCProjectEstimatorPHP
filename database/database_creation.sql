CREATE TABLE [dbo].[appusers] (
    [Id]           INT    identity primary key     NOT NULL,
    [FirstName]    NCHAR (40)  NOT NULL,
    [LastName]     NCHAR (40)  NOT NULL,
    [UserName]     NCHAR (40)  NOT NULL,
    [PasswordHash] NCHAR (256) NOT NULL,
    [PasswordSalt] NCHAR (20)  NOT NULL,
    [CompanyName]  NCHAR (40)  NULL
);

    