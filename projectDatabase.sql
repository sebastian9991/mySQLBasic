drop table Picks;
drop table Owns; 
drop table Consumables; 
drop table Wards; 
drop table Weapons;
drop table Item_contains;
drop table Inventory_holds;
drop table Enemies; 
drop table Ability_Knows_1;
drop table Champion; 
drop table Character_2;
drop table Character; 
drop table Ability_Knows_2;
drop table Rank_Is;
drop table PlayerInventory_2;
drop table PlayerInventory_1;
drop table Matches; 
drop table Player; 

create table Player(
    AccountID char(20) not null, 
    Email char(40) null, 
    Password_player char(20) null,  
    Username char(30) null,
    primary key (AccountID));
grant select on Player to public; 


create table Matches (
    MatchID CHAR(20) not null, 
    Player1 CHAR(20) null,
    Player2 CHAR(20) null,  
    primary key (MatchID), 
    foreign key (Player1) references Player(AccountID)
    ON DELETE CASCADE, 
    foreign key (Player2) references Player(AccountID)
    ON DELETE CASCADE);
grant select on Matches to public;


create table PlayerInventory_1(
    PlayerOwnerID char(20) not null, 
    Skin char(10) null, 
    Currency integer null, 
    AccountID char(20) null,
    primary key (PlayerOwnerID),  
    foreign key (AccountID) references Player
    ON DELETE CASCADE);
grant select on PlayerInventory_1 to public;



create table PlayerInventory_2(
    Currency integer primary key, 
    Subrank char(20) null
);
grant select on PlayerInventory_2 to public;



create table Rank_Is(
    AccountID char(20) not null, 
    Tier integer null, 
    Subrank char(20) null, 
    primary key (AccountID),
    foreign key (AccountID) references Player 
    ON DELETE CASCADE
);
grant select on Rank_Is to public;



create table Ability_Knows_2(
    Effect Char(20) primary key, 
    cooldown char(20)
);
grant select on Ability_Knows_2 to public;


create table Character(
    Name char(20), 
    Health integer, 
    primary key (Name)
);
grant select on Character to public;

create table Character_2(
    Health integer primary key, 
    Mana integer
);
grant select on Character_2 to public; 

create table Champion (
    Name char(20) null, 
    primary key(Name), 
    foreign key (Name) references Character
    ON DELETE CASCADE
); 
grant select on Champion to public; 

create table Ability_Knows_1(
    Name char(20), 
    Champ_name char(20) NOT NULL, 
    Effect char(20), 
    primary key (Name), 
    foreign key (Champ_name) references Champion
    ON DELETE CASCADE
);


create table Enemies (
    Name char(20), 
    Gold_reward integer, 
    primary key (Name), 
    foreign key (Name) references Character
    ON DELETE CASCADE
);


create table Inventory_holds (
    OwnerID char(20) primary key, 
    Coin integer, 
    Name char(20), 
    foreign key (Name) references Champion
    ON DELETE CASCADE
);


create table Item_contains(
    ItemID char(20) primary key, 
    ItemName char(20), 
    OwnerID char(20), 
    foreign key (OwnerID) references Inventory_holds
    ON DELETE CASCADE
); 



create table Weapons (
    ItemID char(20) primary key, 
    AttackPower integer, 
    foreign key (ItemID) references Item_contains
    ON DELETE CASCADE
);


create table Wards (
    ItemID char(20) primary key, 
    Range integer, 
    foreign key (ItemID) references Item_contains 
    ON DELETE CASCADE
);


create table Consumables(
    ItemID char(20) primary key, 
    Effect char(50), 
    foreign key (ItemID) references Item_contains 
    ON DELETE CASCADE
); 


create table Owns(
    PlayerOwnerID char(20), 
    Champ_name char(20), 
    primary key (PlayerOwnerID, Champ_name),
    foreign key (PlayerOwnerID) references PlayerInventory_1
    ON DELETE CASCADE, 
    foreign key (Champ_name) references Champion
    ON DELETE CASCADE
);

create table Picks(
    AccountID char(20), 
    Champ_name char(20), 
    primary key (AccountID, Champ_name),
    foreign key (AccountID) references Player
    ON DELETE CASCADE, 
    foreign key (Champ_name) references Champion
    ON DELETE CASCADE);
grant select on Picks to public; 


insert into Player(AccountID, Email, Password_player, Username) 
values ('gamer1', 'gamer1@email.com', 'gamer1password', 'gamer1username');
insert into Player(AccountID, Email, Password_player, Username) 
values ('gamer2', 'gamer2@email.com', 'gamer2password', 'gamer2username');
insert into Player(AccountID, Email, Password_player, Username) 
values ('gamer3', 'gamer3@email.com', 'gamer3password', 'gamer3username');
insert into Player(AccountID, Email, Password_player, Username) 
values ('gamer4', 'gamer4@email.com', 'gamer4password', 'gamer4username');
insert into Player(AccountID, Email, Password_player, Username) 
values ('gamer5', 'gamer5@email.com', 'gamer5password', 'gamer5username');


insert into Matches(MatchID, Player1, Player2)
values('102', 'gamer1', 'gamer2');
insert into Matches(MatchID, Player1, Player2)
values('103', 'gamer1', 'gamer3');
insert into Matches(MatchID, Player1, Player2)
values('104', 'gamer1', 'gamer3');
insert into Matches(MatchID, Player1, Player2)
values('105', 'gamer4', 'gamer2');
insert into Matches(MatchID, Player1, Player2)
values('106', 'gamer4', 'gamer5');

insert into PlayerInventory_1(PlayerOwnerID, Skin, Currency, AccountID)
values ('playerInventory1', 'skin01', 999, 'gamer1');
insert into PlayerInventory_1(PlayerOwnerID, Skin, Currency, AccountID)
values ('playerInventory2', 'skin02', 999, 'gamer2');
insert into PlayerInventory_1(PlayerOwnerID, Skin, Currency, AccountID) 
values ('playerInventory3', 'skin03', 999, 'gamer3');
insert into PlayerInventory_1(PlayerOwnerID, Skin, Currency, AccountID) 
values ('playerInventory4', 'skin04', 999, 'gamer4');
insert into PlayerInventory_1(PlayerOwnerID, Skin, Currency, AccountID) 
values ('playerInventory5', 'skin05', 999, 'gamer5');

INSERT INTO PlayerInventory_2(Currency, Subrank) 
VALUES (999, 'subrank01');
INSERT INTO PlayerInventory_2(Currency, Subrank) 
VALUES (998, 'subrank02');
INSERT INTO PlayerInventory_2(Currency, Subrank) 
VALUES (997, 'subrank03');
INSERT INTO PlayerInventory_2(Currency, Subrank) 
VALUES (996, 'subrank04');
INSERT INTO PlayerInventory_2(Currency, Subrank) 
VALUES (995, 'subrank05');


INSERT INTO Rank_Is(AccountID, Tier, Subrank) 
VALUES ('gamer1', 1, 'subrank01');
INSERT INTO Rank_Is(AccountID, Tier, Subrank) 
VALUES ('gamer2', 2, 'subrank02');
INSERT INTO Rank_Is(AccountID, Tier, Subrank) 
VALUES ('gamer3', 3, 'subrank03');
INSERT INTO Rank_Is(AccountID, Tier, Subrank) 
VALUES ('gamer4', 4, 'subrank04');
INSERT INTO Rank_Is(AccountID, Tier, Subrank) 
VALUES ('gamer5', 5, 'subrank01');

INSERT INTO Ability_knows_2(Effect, Cooldown) 
VALUES ('Effect01', 11);
INSERT INTO Ability_knows_2(Effect, Cooldown) 
VALUES ('Effect02', 12);
INSERT INTO Ability_knows_2(Effect, Cooldown) 
VALUES ('Effect03', 13);
INSERT INTO Ability_knows_2(Effect, Cooldown) 
VALUES ('Effect04', 14);
INSERT INTO Ability_knows_2(Effect, Cooldown) 
VALUES ('Effect05', 15);

INSERT INTO Character(Name, Health) 
VALUES ('Champion01', 100);
INSERT INTO Character(Name, Health) 
VALUES ('Champion02', 200);
INSERT INTO Character(Name, Health) 
VALUES ('Champion03', 300);
INSERT INTO Character(Name, Health) 
VALUES ('Champion04', 400);
INSERT INTO Character(Name, Health) 
VALUES ('Champion05', 500);
INSERT INTO Character(Name, Health) 
VALUES ('Enemy01', 100);
INSERT INTO Character(Name, Health) 
VALUES ('Enemy02', 200);
INSERT INTO Character(Name, Health) 
VALUES ('Enemy03', 300);
INSERT INTO Character(Name, Health) 
VALUES ('Enemy04', 400);
INSERT INTO Character(Name, Health) 
VALUES ('Enemy05', 500);

INSERT INTO Character_2(Health, Mana) 
VALUES (100, 50);
INSERT INTO Character_2(Health, Mana) 
VALUES (200, 100);
INSERT INTO Character_2(Health, Mana) 
VALUES (300, 150);
INSERT INTO Character_2(Health, Mana) 
VALUES (400, 200);
INSERT INTO Character_2(Health, Mana) 
VALUES (500, 250);


INSERT INTO Champion(Name) 
VALUES ('Champion01');
INSERT INTO Champion(Name) 
VALUES ('Champion02');
INSERT INTO Champion(Name) 
VALUES ('Champion03');
INSERT INTO Champion(Name) 
VALUES ('Champion04');
INSERT INTO Champion(Name) 
VALUES ('Champion05');


INSERT INTO Ability_Knows_1(Name, Champ_name, Effect) 
VALUES ('Ability01', 'Champion01', 'Effect01');
INSERT INTO Ability_Knows_1(Name, Champ_name, Effect) 
VALUES ('Ability02', 'Champion02', 'Effect02');
INSERT INTO Ability_Knows_1(Name, Champ_name, Effect) 
VALUES ('Ability03', 'Champion03', 'Effect03');
INSERT INTO Ability_Knows_1(Name, Champ_name, Effect) 
VALUES ('Ability04', 'Champion04', 'Effect04');
INSERT INTO Ability_Knows_1(Name, Champ_name, Effect) 
VALUES ('Ability05', 'Champion05', 'Effect05');


INSERT INTO Enemies(Name, Gold_reward) 
VALUES ('Enemy01', 10);
INSERT INTO Enemies(Name, Gold_reward) 
VALUES ('Enemy02', 20);
INSERT INTO Enemies(Name, Gold_reward) 
VALUES ('Enemy03', 30);
INSERT INTO Enemies(Name, Gold_reward) 
VALUES ('Enemy04', 40);
INSERT INTO Enemies(Name, Gold_reward) 
VALUES ('Enemy05', 50);

INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory01', 10, 'Champion01');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory02', 20, 'Champion02');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory03', 30, 'Champion03');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory04', 40, 'Champion04');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory05', 50, 'Champion05');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory06', 50, 'Champion05');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory07', 50, 'Champion05');
INSERT INTO Inventory_holds(OwnerID, Coin, Name) 
VALUES ('championinventory09', 50, 'Champion01');

INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('ward01', 'itemName01', 'championinventory01');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('ward02', 'itemName02', 'championinventory02');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('ward03', 'itemName03', 'championinventory03');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('ward04', 'itemName04', 'championinventory04');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('ward05', 'itemName05', 'championinventory05');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('weapon01', 'itemName01', 'championinventory01');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('weapon06', 'itemName01', 'championinventory01');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('weapon02', 'itemName02', 'championinventory02');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('weapon03', 'itemName03', 'championinventory03');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('weapon04', 'itemName04', 'championinventory04');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('weapon05', 'itemName05', 'championinventory05');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('consumable01', 'itemName01', 'championinventory01');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('consumable02', 'itemName02', 'championinventory02');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('consumable03', 'itemName03', 'championinventory03');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('consumable06', 'itemName03', 'championinventory03');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('misc01', 'itemName03', 'championinventory03');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('consumable04', 'itemName04', 'championinventory04');
INSERT INTO Item_contains(ItemID, ItemName, OwnerID) 
VALUES ('consumable05', 'itemName05', 'championinventory05');


INSERT INTO Weapons(ItemID, AttackPower) 
VALUES ('weapon01', 10);
INSERT INTO Weapons(ItemID, AttackPower) 
VALUES ('weapon02', 20);
INSERT INTO Weapons(ItemID, AttackPower) 
VALUES ('weapon03', 30);
INSERT INTO Weapons(ItemID, AttackPower) 
VALUES ('weapon04', 40);
INSERT INTO Weapons(ItemID, AttackPower) 
VALUES ('weapon05', 50);

INSERT INTO Wards(ItemID, Range) 
VALUES ('ward01', 10);
INSERT INTO Wards(ItemID, Range) 
VALUES ('ward02', 20);
INSERT INTO Wards(ItemID, Range) 
VALUES ('ward03', 30);
INSERT INTO Wards(ItemID, Range) 
VALUES ('ward04', 40);
INSERT INTO Wards(ItemID, Range) 
VALUES ('ward05', 50);

INSERT INTO Consumables(ItemID, Effect) 
VALUES ('consumable01', 10);
INSERT INTO Consumables(ItemID, Effect) 
VALUES ('consumable02', 20);
INSERT INTO Consumables(ItemID, Effect) 
VALUES ('consumable03', 30);
INSERT INTO Consumables(ItemID, Effect) 
VALUES ('consumable04', 40);
INSERT INTO Consumables(ItemID, Effect) 
VALUES ('consumable05', 50);


INSERT INTO Owns(PlayerOwnerId, Champ_name) 
VALUES ('playerInventory1',  'Champion01');
INSERT INTO Owns(PlayerOwnerId, Champ_name) 
VALUES ('playerInventory2',  'Champion02');
INSERT INTO Owns(PlayerOwnerId, Champ_name) 
VALUES ('playerInventory3',  'Champion03');
INSERT INTO Owns(PlayerOwnerId, Champ_name) 
VALUES ('playerInventory4',  'Champion04');
INSERT INTO Owns(PlayerOwnerId, Champ_name) 
VALUES ('playerInventory5',  'Champion05');



insert into Picks(AccountID, Champ_Name) 
values ('gamer1', 'Champion01');
insert into Picks(AccountID, Champ_Name) 
values ('gamer2', 'Champion02');
insert into Picks(AccountID, Champ_Name) 
values ('gamer3', 'Champion03');
insert into Picks(AccountID, Champ_Name) 
values ('gamer4', 'Champion04');
insert into Picks(AccountID, Champ_Name) 
values ('gamer5', 'Champion05');
