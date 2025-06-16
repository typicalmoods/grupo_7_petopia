-- This migration script modifies the carts table to add a new column 'status'.
ALTER TABLE carts
    ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT 'ACTIVE' AFTER quantity;

UPDATE carts
SET status = 'ACTIVE'
WHERE status IS NULL;
