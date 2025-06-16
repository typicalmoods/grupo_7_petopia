-- Rollback script for version 1.3.0: Modify products table
ALTER TABLE products
    DROP COLUMN url_image;

DELETE FROM flyway_schema_history
WHERE version = '1.3.0';
