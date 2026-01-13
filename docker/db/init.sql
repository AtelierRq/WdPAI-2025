CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'user')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    beds INT NOT NULL,
    description TEXT
);

CREATE TABLE bookings (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id),
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    date_from DATE NOT NULL,
    date_to DATE NOT NULL,
    adults INT NOT NULL,
    children INT NOT NULL,
    infants INT NOT NULL,
    breakfast BOOLEAN DEFAULT FALSE,
    notes TEXT,
    total_price INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE booking_rooms (
    booking_id INT REFERENCES bookings(id) ON DELETE CASCADE,
    room_id INT REFERENCES rooms(id),
    PRIMARY KEY (booking_id, room_id)
);

INSERT INTO rooms (name, beds, description) VALUES
('Polana', 2, '1 łóżko podwójne, prywatna łazienka'),
('Homola', 3, '1 łóżko podwójne, 1 łóżko pojedyncze, prywatna łazienka'),
('Kopa', 2, '2 łóżka pojedyncze, dzielona łazienka'),
('Skałka', 4, '4 łóżka pojedyncze, dzielona łazienka');

INSERT INTO users (email, password_hash, role)
VALUES (
    'admin@debowyjar.pl',
    '$2y$10$examplehash',
    'admin'
);