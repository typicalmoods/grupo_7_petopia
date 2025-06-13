-- This migration script modifies the 'products' table to add a new column 'url_image'
ALTER TABLE products
    ADD COLUMN url_image VARCHAR(255) AFTER description;
