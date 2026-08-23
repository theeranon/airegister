<?php
$db = new PDO('sqlite:seminar.sqlite');
$db->exec("
CREATE TABLE IF NOT EXISTS registrations (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  email TEXT UNIQUE NOT NULL,
  phone TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS checkins (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT UNIQUE NOT NULL,
  checked_in_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS feedbacks (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  email TEXT UNIQUE NOT NULL,
  rating INTEGER NOT NULL,
  comment TEXT,
  submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO registrations (name, email, phone) VALUES ('John Doe', 'john@example.com', '0812345678');
INSERT INTO checkins (email) VALUES ('john@example.com');
INSERT INTO feedbacks (email, rating, comment) VALUES ('john@example.com', 5, 'Great seminar!');
");
echo "SQLite DB created.";
?>
