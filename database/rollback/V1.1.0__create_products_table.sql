-- Rollback script for creating products table
DELETE TABLE products;

DELETE FROM flyway_schema_history
WHERE version = '1.1.0';
