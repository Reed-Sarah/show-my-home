CREATE TABLE users (
  user_id SERIAL,
  is_realtor boolean,
  first_name VARCHAR(255),
  last_name VARCHAR(255),
  phone VARCHAR(255),
  email VARCHAR(255),
  user_password VARCHAR(255),
  PRIMARY KEY (user_id)
);

CREATE TABLE homes (
  MLS_num INT PRIMARY KEY,
  user_id int NOT NULL REFERENCES users (user_id),
  addressLine1 VARCHAR(255),
  addressLine2 VARCHAR(255),
  country VARCHAR(255),
  state VARCHAR(255),
  city VARCHAR(255),
  zip_code VARCHAR(255),
  picture_path VARCHAR(255)
);

CREATE TABLE home_avail (
avail_id INT PRIMARY KEY,
MLS_num INT NOT NULL REFERENCES homes (MLS_num),
start_date DATETIME,
end_date DATETIME
);

CREATE TABLE showings (
showing_id INT PRIMARY KEY,
MLS_num INT NOT NULL REFERENCES homes (MLS_num),
date DATETIME,
user_id INT NOT NULL REFERENCES users (user_id),
);
