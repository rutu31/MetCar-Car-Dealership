
create database MetCar;
use MetCar;

create table CUSTOMER (
	cust_id integer(4),
	first_name varchar(10),
	last_name varchar(10),
	street varchar(50),
	city varchar(10),
	zip integer(9),
	work_phone varchar(15),
	day_phone varchar(15),
	constraint primary key (cust_id)
);




create table CAR (
	licence_no varchar(10),
	cust_id integer(4) NOT NULL,
	car_model varchar(20),
	constraint primary key (licence_no),
	constraint foreign key (cust_id) references CUSTOMER(cust_id) on delete cascade 
);
	

	
create table SERVICE_CONTRACT (
	contract_id integer(4),
	car_licence varchar(10),
	start_date DATE,
	end_date DATE,
	amount float(6,2),
	constraint primary key (contract_id),
	constraint foreign key (car_licence) references CAR(licence_no) on delete cascade 
);

create table SUPERVISOR (
	emp_id integer(4),
	first_name varchar(10),
	last_name varchar(10),
	phone varchar(15),
	constraint primary key (emp_id)
);

create table REPAIR_JOB (
	job_id integer(4),
	service_fee float(5,2),
	date_time_car_in TIMESTAMP,
	date_time_car_out TIMESTAMP,
	total_repair_charges float(7,2),
	emp_id integer(4),
	car_licence varchar(10),
	constraint primary key(job_id),
	constraint foreign key (emp_id) references SUPERVISOR(emp_id),
	constraint foreign key (car_licence) references CAR(licence_no)
);

create table REPAIR_PROBLEM (
	problem_id integer(4),
	problem_type varchar(20),
	labor_cost float(5,2),
	total_cost float(6,2),
	constraint primary key(problem_id)
);
	
	
create table REPAIR(
	job_id integer(4),
	problem_id integer(4),
	repair_date TIMESTAMP,
	constraint foreign key(job_id) references REPAIR_JOB(job_id) on delete cascade,
	constraint foreign key(problem_id) references REPAIR_PROBLEM(problem_id),
	constraint unique(job_id, problem_id)
);

create table PART (
	part_id integer(4),
	part_name varchar(15),
	part_cost float(5,2),
	constraint primary key(part_id)
);
	
create table REQUIRES(
	problem_id integer(4),
	part_id integer(4),
	constraint foreign key(problem_id) references REPAIR_PROBLEM(problem_id),
	constraint foreign key(part_id) references PART(part_id),
	constraint unique(problem_id, part_id)	
);


insert into customer values(1, "John", "Smith", "104 El Camino Real", "Sunnyvale", 95150, "4082489410", "4083281410");

insert into car values("DZNYWLD", 1, "TOYOTA COROLLA");

insert into service_contract values(1, "DZNYWLD", "2009-01-10", "2012-01-09", 1500);

insert into supervisor values(2001, "James", "Bond", "408-007-1010");
insert into supervisor values(2002, "John", "Williams", "408-547-2112");
insert into supervisor values(2003, "Anderson", "Johnson", "408-846-0482");
insert into supervisor values(2004, "Davis", "Jones", "408-123-8472");
insert into supervisor values(2005, "Bill", "Brooks", "408-756-9821");


insert into repair_job values(1, 90, "2010-04-10 07:15:30", "2010-04-15 11:12:00", 230, 2001, "DZNYWLD");

insert into repair values(1, 4001, "2010-04-12 16:20:00");

insert into repair_problem values(4001, "Break System", 30, 180);
insert into repair_problem values(4002, "Transmission", 68, 557);
insert into repair_problem values(4003, "Blinking Lights", 42, 422);
insert into repair_problem values(4004, "Radiator Leak", 23, 290);
insert into repair_problem values(4005, "Axle Failure", 20, 294);
insert into repair_problem values(4006, "Faulty Steering", 26, 215);
insert into repair_problem values(4007, "Engine Failure", 36, 926);


insert into requires values(4001, 5001);
insert into requires values(4002, 5002);
insert into requires values(4003, 5003);
insert into requires values(4004, 5004);
insert into requires values(4005, 5005);
insert into requires values(4006, 5006);
insert into requires values(4007, 5007);
	

insert into part values(5001, "Foot Break", 150);
insert into part values(5002, "Trans. Filter", 489);
insert into part values(5003, "Head Lights", 380);
insert into part values(5004, "Radiator", 267);
insert into part values(5005, "Rear Axle", 274);
insert into part values(5006, "Steering Wheel", 189);
insert into part values(5007, "Engine", 890);
