-- Zero What Solar Website Database Schema
-- Designed for MySQL (compatible with shared hosting)
-- Run this SQL in your hosting provider's phpMyAdmin

-- Create database (if your hosting provider hasn't created it)
-- CREATE DATABASE zero_what_solar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
-- USE zero_what_solar;

-- ======================================
-- BLOG SYSTEM TABLES
-- ======================================

-- Blog Categories Table
CREATE TABLE blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog Posts Table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    featured_image VARCHAR(500),
    category_id INT,
    author_name VARCHAR(100) DEFAULT 'Solar Expert Team',
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    views INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_published_at (published_at),
    INDEX idx_category (category_id)
);

-- ======================================
-- LEAD MANAGEMENT TABLES
-- ======================================

-- Contact Form Submissions
CREATE TABLE contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    property_type ENUM('residential', 'commercial', 'industrial', 'apartment', 'independent_house', 'villa') NULL,
    monthly_bill DECIMAL(10,2),
    address TEXT,
    message TEXT,
    whatsapp_updates BOOLEAN DEFAULT FALSE,
    lead_score INT DEFAULT 0,
    status ENUM('new', 'contacted', 'qualified', 'converted', 'closed') DEFAULT 'new',
    source VARCHAR(50) DEFAULT 'website',
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
);

-- Solar Calculator Results
CREATE TABLE calculator_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20),
    monthly_bill DECIMAL(10,2) NOT NULL,
    property_type ENUM('residential', 'commercial', 'industrial', 'apartment', 'independent_house', 'villa') NOT NULL,
    rooftop_area DECIMAL(8,2),
    location VARCHAR(100),
    system_size_kw DECIMAL(5,2) NOT NULL,
    estimated_cost DECIMAL(12,2) NOT NULL,
    government_subsidy DECIMAL(10,2) NOT NULL,
    monthly_savings DECIMAL(10,2) NOT NULL,
    payback_period DECIMAL(4,2) NOT NULL,
    lead_score INT DEFAULT 0,
    status ENUM('new', 'contacted', 'quoted', 'converted') DEFAULT 'new',
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_lead_score (lead_score)
);

-- Newsletter Subscriptions
CREATE TABLE newsletter_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(100),
    status ENUM('active', 'unsubscribed', 'bounced') DEFAULT 'active',
    source VARCHAR(50) DEFAULT 'website',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_status (status)
);

-- ======================================
-- PROJECT PORTFOLIO TABLES
-- ======================================

-- Project Categories
CREATE TABLE project_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Projects Portfolio
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    location VARCHAR(200) NOT NULL,
    system_size_kw DECIMAL(8,2) NOT NULL,
    monthly_savings DECIMAL(10,2),
    roi_years DECIMAL(4,2),
    project_cost DECIMAL(12,2),
    category_id INT,
    featured_image VARCHAR(500),
    gallery_images JSON,
    completion_date DATE,
    status ENUM('completed', 'ongoing', 'planned') DEFAULT 'completed',
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES project_categories(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_category (category_id)
);

-- ======================================
-- TESTIMONIALS TABLE
-- ======================================

CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    location VARCHAR(200) NOT NULL,
    testimonial_text TEXT NOT NULL,
    rating INT DEFAULT 5 CHECK (rating >= 1 AND rating <= 5),
    system_size_kw DECIMAL(5,2),
    savings_amount DECIMAL(10,2),
    customer_image VARCHAR(500),
    featured BOOLEAN DEFAULT FALSE,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_featured (featured),
    INDEX idx_rating (rating)
);

-- ======================================
-- SETTINGS TABLE
-- ======================================

CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    setting_type ENUM('text', 'number', 'boolean', 'json') DEFAULT 'text',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_key (setting_key)
);

-- ======================================
-- INSERT SAMPLE DATA
-- ======================================

-- Insert Blog Categories
INSERT INTO blog_categories (name, slug, description) VALUES
('Installation Guide', 'installation-guide', 'Solar panel installation guides and tutorials'),
('Government Policy', 'government-policy', 'Government policies and subsidy information'),
('Maintenance', 'maintenance', 'Solar panel maintenance and care tips'),
('Finance', 'finance', 'Cost analysis and financial aspects of solar energy'),
('Technology', 'technology', 'Latest solar technology updates and comparisons'),
('Commercial', 'commercial', 'Commercial and industrial solar solutions');

-- Insert Project Categories
INSERT INTO project_categories (name, slug, description) VALUES
('Residential', 'residential', 'Home solar installations'),
('Commercial', 'commercial', 'Business and office solar projects'),
('Industrial', 'industrial', 'Large-scale industrial solar installations');

-- Insert Sample Blog Posts
INSERT INTO blog_posts (title, slug, excerpt, content, featured_image, category_id, status, published_at, meta_title, meta_description) VALUES
(
    'Complete Guide to Solar Panel Installation in Jaipur 2024',
    'complete-guide-solar-panel-installation-jaipur-2024',
    'Everything you need to know about installing solar panels in Jaipur - from government approvals to cost calculations and maintenance tips.',
    '<p class="lead">Installing solar panels in Jaipur has never been more accessible, thanks to government initiatives and decreasing costs. This comprehensive guide covers everything you need to know about going solar in the Pink City.</p><h3>Why Choose Solar in Jaipur?</h3><p>Jaipur receives excellent solar irradiation throughout the year, making it one of the best cities in India for solar energy generation.</p>',
    'https://images.unsplash.com/photo-1509391366360-2e959784a276?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    1,
    'published',
    NOW(),
    'Complete Solar Panel Installation Guide Jaipur 2024 | Zero What Solar',
    'Complete guide to solar panel installation in Jaipur. Government approvals, cost calculations, maintenance tips by Zero What Solar experts.'
),
(
    'How to Get ₹78,000 Solar Subsidy in Rajasthan',
    'how-to-get-solar-subsidy-rajasthan',
    'Step-by-step guide to apply for government solar subsidy in Rajasthan. Learn about eligibility criteria, required documents, and application process.',
    '<p class="lead">The Government of India offers substantial subsidies for rooftop solar installations. Here is your complete guide to claiming up to ₹78,000 in solar subsidies in Rajasthan.</p><h3>Eligibility Criteria</h3><p>Residential consumers of JVVNL, AVVNL, or JdVVNL with proper roof space.</p>',
    'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    2,
    'published',
    NOW(),
    'Get ₹78,000 Solar Subsidy Rajasthan 2024 | Government Benefits Guide',
    'Complete guide to claim ₹78,000 government solar subsidy in Rajasthan. Eligibility, documents, application process by Zero What Solar.'
);

-- Insert Site Settings
INSERT INTO site_settings (setting_key, setting_value, setting_type, description) VALUES
('company_name', 'Zero What Solar', 'text', 'Company name'),
('company_phone', '+91 98765 43210', 'text', 'Primary contact phone'),
('company_email', 'contact@zerowhatsolar.in', 'text', 'Primary contact email'),
('company_address', 'Sitapura Industrial Area, Jaipur, Rajasthan 302022', 'text', 'Company address'),
('base_price_per_kw', '65000', 'number', 'Base price per kW for calculations'),
('max_government_subsidy', '78000', 'number', 'Maximum government subsidy amount'),
('subsidy_per_kw_first_3', '18000', 'number', 'Subsidy per kW for first 3 kW'),
('subsidy_per_kw_beyond_3', '9000', 'number', 'Subsidy per kW beyond 3 kW'),
('average_units_per_kw_month', '120', 'number', 'Average units generated per kW per month'),
('average_savings_percentage', '87', 'number', 'Average electricity bill savings percentage');

-- Insert Sample Testimonials
INSERT INTO testimonials (customer_name, location, testimonial_text, rating, system_size_kw, savings_amount, status) VALUES
('Rajesh Sharma', 'Malviya Nagar, Jaipur', 'Zero What Solar reduced my monthly bill from ₹4,500 to just ₹500! The installation was quick and professional. Highly recommended!', 5, 5.0, 4000, 'approved'),
('Priya Agarwal', 'Vaishali Nagar, Jaipur', 'Excellent service from start to finish. My 5kW system generates more power than expected. Best investment I have made!', 5, 5.0, 3800, 'approved'),
('Amit Kumar', 'Mansarovar, Jaipur', 'Professional installation and great after-sales service. My electricity bill is practically zero now!', 5, 3.0, 2400, 'approved');

-- Create indexes for better performance
CREATE INDEX idx_blog_posts_published ON blog_posts(status, published_at DESC);
CREATE INDEX idx_contact_lead_score ON contact_submissions(lead_score DESC, created_at DESC);
CREATE INDEX idx_calculator_lead_score ON calculator_results(lead_score DESC, created_at DESC);