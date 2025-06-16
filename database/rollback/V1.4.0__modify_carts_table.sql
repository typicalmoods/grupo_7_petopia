-- Rollback script for version 1.4.0: Modify carts table
ALTER TABLE carts
    DROP COLUMN status;

DELETE FROM flyway_schema_history
WHERE version = '1.4.0';
