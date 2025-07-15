INSERT INTO items (item_name, item_description, item_url, item_price) VALUES
('Focus Planner', 'Boost your daily productivity with this time-blocking planner.', 'images/full-focus-planner.jpg', 320.00),
('Gratitude Journal', 'Cultivate positivity with daily gratitude prompts.', 'images/Gratitude-Journal.jpg', 200.00),
('Stress Ball Set', 'Set of 3 stress balls for quick stress relief at home or work.', 'images/stress_ball.jpg', 120.00),
('Motivational Stickers', 'Inspiring quotes and art to decorate your space or notebook.', 'images/motivation.jpg', 150.00);

INSERT INTO items (item_name, item_description, item_url, item_price) VALUES
('Laptop', 'Laptop to boost your productivity, comes pre-built with Visual Studio', 'images/laptop.jpg', 3500.00);

ALTER TABLE items ADD COLUMN image VARCHAR(255);

UPDATE items SET image = 'https://www.leatherneo.com/cdn/shop/articles/img-1704854220174.jpg?v=1704854464' WHERE item_id = 1;
UPDATE items SET image = 'images/full-focus-planner.jpg' WHERE item_id = 2;
UPDATE items SET image = 'images/Gratitude-Journal.jpg' WHERE item_id = 3;
UPDATE items SET image = 'images/stress_ball.jpg' WHERE item_id = 4;
UPDATE items SET image = 'images/motivation.jpg' WHERE item_id = 5;
UPDATE items SET image = 'images/laptop.jpg' WHERE item_id = 6;

ALTER TABLE cart ADD COLUMN quantity INT NOT NULL DEFAULT 1;

SELECT item_id, item_name, image FROM items;

