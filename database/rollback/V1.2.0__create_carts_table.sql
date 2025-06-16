-- Rollback script for creating carts table
DELETE TABLE carts;

DELETE FROM flyway_schema_history
WHERE version = '1.2.0';
