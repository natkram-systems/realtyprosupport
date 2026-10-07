-- Schema and development seed data for the MMJ Greenland dashboard.
-- Applied automatically by the MySQL container on first start of the db volume.

CREATE TABLE IF NOT EXISTS users (
  user_id     VARCHAR(64)  NOT NULL PRIMARY KEY,
  name        VARCHAR(100) NOT NULL,
  email       VARCHAR(150) NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,
  verified    TINYINT(1)   NOT NULL DEFAULT 1,
  verify_code VARCHAR(64)  DEFAULT NULL,
  totp_secret VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS land_sales (
  id                    INT AUTO_INCREMENT PRIMARY KEY,
  lot_id                VARCHAR(32),
  contract_number       VARCHAR(32),
  buyer_name            VARCHAR(120),
  contract_status       VARCHAR(20),
  price                 DECIMAL(12,2),
  amount_paid           DECIMAL(12,2),
  last_amount_paid      DECIMAL(12,2),
  balance               DECIMAL(12,2),
  date_sold             DATE,
  date_last_transaction DATE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Development login: admin@mmj.test / green123 (same credentials as users.txt).
INSERT INTO users (user_id, name, email, password, verified)
VALUES ('user_admin', 'Admin', 'admin@mmj.test',
        '$2y$10$8HQSirwSGM5zfWHTc.8i9eFEEMazXRU..M1uLvMYI0EkR2PUYuKKu', 1)
ON DUPLICATE KEY UPDATE password = VALUES(password);

INSERT INTO land_sales
  (lot_id, contract_number, buyer_name, contract_status, price, amount_paid, last_amount_paid, balance, date_sold, date_last_transaction)
VALUES
  ('LOT-101', 'CT-2024-001', 'Juan Dela Cruz',   'Active',    1250000.00, 450000.00, 50000.00,  800000.00, CURDATE() - INTERVAL 27 DAY, CURDATE() - INTERVAL 3 DAY),
  ('LOT-102', 'CT-2024-002', 'Maria Santos',     'Active',    980000.00,  380000.00, 40000.00,  600000.00, CURDATE() - INTERVAL 24 DAY, CURDATE() - INTERVAL 6 DAY),
  ('LOT-103', 'CT-2024-003', 'Pedro Reyes',      'Completed', 750000.00,  750000.00, 750000.00,      0.00, CURDATE() - INTERVAL 21 DAY, CURDATE() - INTERVAL 21 DAY),
  ('LOT-104', 'CT-2024-004', 'Ana Villanueva',   'Active',    1420000.00, 500000.00, 60000.00,  920000.00, CURDATE() - INTERVAL 18 DAY, CURDATE() - INTERVAL 2 DAY),
  ('LOT-105', 'CT-2024-005', 'Ramon Bautista',   'Overdue',   860000.00,  210000.00, 15000.00,  650000.00, CURDATE() - INTERVAL 15 DAY, CURDATE() - INTERVAL 41 DAY),
  ('LOT-106', 'CT-2024-006', 'Liza Fernandez',   'Active',    1100000.00, 420000.00, 45000.00,  680000.00, CURDATE() - INTERVAL 12 DAY, CURDATE() - INTERVAL 4 DAY),
  ('LOT-107', 'CT-2024-007', 'Carlos Mendoza',   'Active',    940000.00,  300000.00, 30000.00,  640000.00, CURDATE() - INTERVAL 9 DAY,  CURDATE() - INTERVAL 1 DAY),
  ('LOT-108', 'CT-2024-008', 'Grace Lim',        'Completed', 1330000.00, 1330000.00, 80000.00,      0.00, CURDATE() - INTERVAL 7 DAY,  CURDATE() - INTERVAL 7 DAY),
  ('LOT-109', 'CT-2024-009', 'Nathan Ocampo',    'Active',    1020000.00, 250000.00, 25000.00,  770000.00, CURDATE() - INTERVAL 5 DAY,  CURDATE() - INTERVAL 2 DAY),
  ('LOT-110', 'CT-2024-010', 'Rosa Domingo',     'Active',    1180000.00, 360000.00, 35000.00,  820000.00, CURDATE() - INTERVAL 3 DAY,  CURDATE() - INTERVAL 3 DAY),
  ('LOT-111', 'CT-2024-011', 'Miguel Torres',    'Overdue',   690000.00,  150000.00, 10000.00,  540000.00, CURDATE() - INTERVAL 2 DAY,  CURDATE() - INTERVAL 45 DAY),
  ('LOT-112', 'CT-2024-012', 'Elena Rivera',     'Active',    1570000.00, 600000.00, 70000.00,  970000.00, CURDATE() - INTERVAL 1 DAY,  CURDATE() - INTERVAL 1 DAY);
