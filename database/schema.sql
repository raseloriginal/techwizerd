-- Tech Wizard Database Schema
-- Import this file into MySQL before running the application
-- Default admin login: admin@techwizard.com / password

CREATE DATABASE IF NOT EXISTS techwizard_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE techwizard_db;

-- Admin Users
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin','admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Services
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    sort_order INT DEFAULT 0,
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Clients
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    logo VARCHAR(255),
    website VARCHAR(255),
    contact_person VARCHAR(100),
    contact_email VARCHAR(150),
    contact_phone VARCHAR(30),
    is_active TINYINT DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Team Members
CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(150) NOT NULL,
    department VARCHAR(100),
    qualification VARCHAR(100),
    phone VARCHAR(30),
    email VARCHAR(150),
    photo VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Projects
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    client_id INT,
    description TEXT,
    scope TEXT,
    location VARCHAR(200),
    project_type ENUM('civil','telecom','steel_structure','maintenance','power','site_acquisition','supply','other') DEFAULT 'other',
    status ENUM('pending','ongoing','completed','on_hold','cancelled') DEFAULT 'pending',
    start_date DATE,
    end_date DATE,
    contract_value DECIMAL(15,2) DEFAULT 0.00,
    featured_image VARCHAR(255),
    is_featured TINYINT DEFAULT 0,
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL
);

-- Project Images
CREATE TABLE IF NOT EXISTS project_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    sort_order INT DEFAULT 0,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

-- Expense Categories
CREATE TABLE IF NOT EXISTS expense_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('project','company') NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Project Expenses
CREATE TABLE IF NOT EXISTS project_expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    category_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    expense_date DATE NOT NULL,
    receipt_image VARCHAR(255),
    payment_method ENUM('cash','bank_transfer','cheque','mobile_banking','other') DEFAULT 'cash',
    paid_to VARCHAR(200),
    approved_by VARCHAR(100),
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES expense_categories(id) ON DELETE SET NULL
);

-- Company Expenses
CREATE TABLE IF NOT EXISTS company_expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    amount DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    expense_date DATE NOT NULL,
    receipt_image VARCHAR(255),
    payment_method ENUM('cash','bank_transfer','cheque','mobile_banking','other') DEFAULT 'cash',
    paid_to VARCHAR(200),
    approved_by VARCHAR(100),
    fiscal_year VARCHAR(10),
    month INT,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES expense_categories(id) ON DELETE SET NULL
);

-- Contact Messages
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(30),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site Settings
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================
-- SEED DATA
-- =====================

INSERT INTO admin_users (name, email, password, role) VALUES
('Md. Anisuzzaman', 'admin@techwizard.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin');
-- Default password: password

INSERT INTO services (title, slug, description, icon, sort_order) VALUES
('Site Acquisition', 'site-acquisition', 'Complete site acquisition services including initial investigation, proposal submission, negotiation, and deed signing for telecom sites (GF/GFRT/RT).', 'tower', 1),
('Civil Construction', 'civil-construction', 'Full civil construction services from site survey to final handover including piling, casting, plaster, painting and electrical work.', 'building', 2),
('Telecom Installation', 'telecom-installation', 'MW, BTS, IBS & Outdoor equipment installation and commissioning including feeder cable, GSM, WiMAX antenna systems.', 'wifi', 3),
('Steel Structure', 'steel-structure', 'Design and erection of steel structures for telecom towers and industrial facilities.', 'settings', 4),
('Power Connection', 'power-connection', 'End-to-end power connection services from site survey to meter installation and handover.', 'zap', 5),
('Maintenance', 'maintenance', 'Comprehensive maintenance services for civil, electrical, grounding, tower, pole, aviation lights and raised floors.', 'tool', 6),
('Supply', 'supply', 'Supply of construction materials, electronics, IT solutions, stationery and gift items.', 'package', 7),
('RF Survey & Drive Test', 'rf-survey', 'Area Survey, RF Survey, Drive Test, Optimization and LOS for telecom network planning.', 'radio', 8);

INSERT INTO clients (name, logo, website, is_active, sort_order) VALUES
('Robi Axiata Ltd.', '', 'https://www.robi.com.bd', 1, 1),
('Grameenphone', '', 'https://www.grameenphone.com', 1, 2),
('EDOTCO Bangladesh Co. Ltd.', '', 'https://www.edotcogroup.com', 1, 3),
('Summit Towers Limited', '', 'https://www.summit-towers.net', 1, 4),
('Cixingbd Limited', '', '', 1, 5),
('Akij Group Ltd.', '', 'https://www.akijgroup.com', 1, 6);

INSERT INTO team_members (name, designation, department, qualification, phone, sort_order) VALUES
('Md. Anisuzzaman', 'CEO', 'Management', 'MBA', '+8801619161842', 1),
('Md. Mahfuz Alam', 'CFO', 'Management', 'MSS', '+8801768859986', 2),
('Rubel Mia', 'Project Manager', 'Site Acquisition', 'MS.C', '', 3),
('Md. Sazzad Hossain', 'Legal Consultant', 'Site Acquisition', 'L.L.B', '', 4),
('Md. Zaved Hossain', 'Legal Consultant', 'Site Acquisition', 'L.L.B', '', 5),
('Md. Hasanuzzaman', 'Sr. Executive Officer (SAQ)', 'Site Acquisition', 'Diploma in Civil', '', 6),
('Md. Moslem Uddin', 'Sr. Executive Officer (SAQ)', 'Site Acquisition', 'Diploma in Electrical', '', 7),
('Md. Rashadul Hasan', 'Project Manager (Civil)', 'Civil Construction', 'BSC in Civil', '', 8),
('Md. Sazedur Rahman', 'Coordinator', 'Civil Construction', 'BSc in EEE', '', 9);

INSERT INTO expense_categories (name, type) VALUES
('Labor Cost', 'project'),
('Materials', 'project'),
('Equipment Rental', 'project'),
('Transportation', 'project'),
('Site Survey', 'project'),
('Subcontractor', 'project'),
('Miscellaneous', 'project'),
('Office Rent', 'company'),
('Salaries', 'company'),
('Utilities', 'company'),
('Marketing', 'company'),
('Vehicle', 'company'),
('Office Supplies', 'company'),
('Bank Charges', 'company'),
('Insurance', 'company'),
('Other', 'company');

INSERT INTO settings (setting_key, setting_value) VALUES
('site_title', 'Tech Wizard'),
('site_tagline', 'Keep Your World Connected'),
('site_email', 'info.techwizardbd@gmail.com'),
('site_phone', '+8801619161842'),
('site_phone2', '01552666676'),
('site_address', 'House No-83, Flat-4A, 5A, Gulshan Badda Link Road, Dhaka-1212'),
('site_description', 'Tech Wizard is a leading telecom and civil construction contractor in Bangladesh providing quality services to major telecom operators.'),
('facebook_url', ''),
('linkedin_url', ''),
('google_map_embed', '');
