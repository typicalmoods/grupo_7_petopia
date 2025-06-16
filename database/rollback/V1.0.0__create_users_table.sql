-- Rollback script for creating users table
DELETE TABLE users;

DELETE FROM flyway_schema_history
WHERE version = '1.0.0';
