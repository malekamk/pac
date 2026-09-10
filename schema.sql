CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','member') NOT NULL DEFAULT 'member',
  position VARCHAR(150) NULL,
  profile_image VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  event_date DATE NOT NULL,
  event_time VARCHAR(100),
  venue VARCHAR(200),
  description TEXT,
  image VARCHAR(255),
  featured TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tag VARCHAR(100) NOT NULL DEFAULT 'Announcement',
  title VARCHAR(200) NOT NULL,
  body TEXT,
  image VARCHAR(255),
  published_at DATE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS candidates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  ward VARCHAR(50),
  role VARCHAR(100) NOT NULL DEFAULT 'Councillor Candidate',
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS hero_slides (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL,
  alt_text VARCHAR(255),
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gallery_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(255) NOT NULL,
  caption VARCHAR(255),
  display_mode ENUM('cover','contain','pattern') NOT NULL DEFAULT 'cover',
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Initial admin login: admin@pacjhb.org.za / PacJhb2026!  (change after first login)
INSERT INTO admins (name, email, password_hash, role) VALUES
('PAC Johannesburg Admin', 'admin@pacjhb.org.za', '$2y$12$fh10vbYjCydo7auus3zsK.Idk2ICSlsa0TcP3cJD5Duq7uRBfMvtu', 'admin');

INSERT INTO events (title, event_date, event_time, venue, description, image, featured) VALUES
('Raboroko Branch (Naledi) Car Wash & Fundraiser', '2026-09-24', '10:00 till late', 'Park next to Naledi High School',
 'The Raboroko Branch in Naledi invites the National, Provincial and Regional leadership and all PAC structures to its branch event — a community car wash and fundraiser to mobilise and strengthen the organisation at branch level. Car Wash: R30, Plate: R30 — good music, good vibes, good cause.',
 'assets/img/event-raboroko-naledi-carwash.jpeg', 1),
('PAC JHB Regional Manifesto Launch', '2026-09-27', '10:00 – 13:00', 'Orlando Community Hall, Soweto', NULL, NULL, 0),
('Mayoral Candidate Community Walkabout', '2026-10-10', '09:00 – 12:00', 'Alexandra', 'With Thami ka Plaatjie.', NULL, 0),
('PAYCO Youth Dialogue on Jobs & Land', '2026-10-17', '11:00 – 15:00', 'Newclare Community Centre', NULL, NULL, 0),
('PAWO Women''s Assembly — Johannesburg', '2026-10-24', '10:00 – 14:00', 'Lenasia South Civic Centre', NULL, NULL, 0),
('Final Campaign Rally', '2026-10-31', 'All day', 'Johannesburg CBD', NULL, NULL, 0),
('2026 Local Government Elections — Election Day', '2026-11-04', NULL, 'National election day, as proclaimed by the President', NULL, NULL, 0);

INSERT INTO announcements (tag, title, body, image, published_at) VALUES
('Interview Alert', 'Cde Thami ka Plaatjie Live on eNCA',
 'On 7 August 2026, PAC Johannesburg Mayoral Candidate Cde Thami ka Plaatjie appeared live on eNCA (Channel 403) with Nicholas Maphopha, sharing his vision to restore Johannesburg to its glory through principled leadership, accountable governance and people-centred service delivery — a city that is safe, functional, prosperous and works for all who call it home. Secure Joburg. Empower the City.',
 'assets/img/announcement-thami-enca-interview.jpeg', '2026-08-07');

INSERT INTO candidates (name, ward, role, image) VALUES
('Thabisa Jonas', '100', 'Councillor Candidate', 'assets/img/candidate-thabisa-jonas.jpeg'),
('Ntombi Mtshali', '19', 'Councillor Candidate', 'assets/img/candidate-ntombi-mtshali.jpeg'),
('Tsholo Molatlou', '39', 'Councillor Candidate', 'assets/img/candidate-tsholo-molatlou.jpeg');

INSERT INTO hero_slides (image, alt_text, sort_order) VALUES
('assets/img/hero-pac-flags-crowd.png', 'PAC supporters marching with party flags, Johannesburg skyline behind them', 1);

INSERT INTO gallery_images (image, caption, display_mode, sort_order) VALUES
('assets/img/founding-members-1957.jpg', 'Robert Sobukwe with fellow founding members, 1957. Public domain.', 'cover', 1),
('assets/img/sobukwe-leballo.jpg', 'Sobukwe (left) with Potlako Leballo, before 21 March 1960. Public domain.', 'cover', 2),
('assets/img/rsa-1994-pac-map.png', 'PAC vote share, 1994 election. CC BY-SA 4.0, Tomislav Addai.', 'contain', 3),
('assets/img/nyhontso-president.jpeg', 'President Mzwanele Nyhontso at the launch of Sobukwe Month. PAC of Azania.', 'cover', 4),
('assets/img/apa-pooe.jpg', 'Secretary-General Ntsiri "Apa" Pooe. PAC of Azania.', 'cover', 5),
('assets/img/1200px-Pan_Africanist_Congress_of_Azania_logo.svg_.png', NULL, 'pattern', 6);
