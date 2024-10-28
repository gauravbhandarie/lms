CREATE DATABASE library_db;
USE library_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE librarians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    author VARCHAR(255),
    genre VARCHAR(100),
    available INT DEFAULT 1 
);
CREATE TABLE borrowed_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    borrow_date DATE,
    return_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);
INSERT INTO books (title, author, genre, available)
VALUES ('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1),
       ('1984', 'George Orwell', 'Dystopian', 1),
       ('The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 1);
INSERT INTO books (title, author, genre, available) VALUES 
('The Silent Patient', 'Alex Michaelides', 'Psychological Thriller', 1),
('The Vanishing Half', 'Brit Bennett', 'Fiction', 1),
('Klara and the Sun', 'Kazuo Ishiguro', 'Science Fiction', 1),
('The Midnight Library', 'Matt Haig', 'Fiction', 1),
('Project Hail Mary', 'Andy Weir', 'Science Fiction', 1),
('Malibu Rising', 'Taylor Jenkins Reid', 'Contemporary Fiction', 1),
('The Last House on Needless Street', 'Catriona Ward', 'Horror', 1),
('The Push', 'Ashley Audrain', 'Psychological Thriller', 1),
('The Paper Palace', 'Miranda Cowley Heller', 'Fiction', 1),
('The Four Winds', 'Kristin Hannah', 'Historical Fiction', 1),
('The Invisible Life of Addie LaRue', 'V.E. Schwab', 'Fantasy', 1),
('The Song of Achilles', 'Madeline Miller', 'Historical Fiction', 1),
('Circe', 'Madeline Miller', 'Fantasy', 1),
('Anxious People', 'Fredrik Backman', 'Fiction', 1),
('The Guest List', 'Lucy Foley', 'Mystery', 1),
('Normal People', 'Sally Rooney', 'Fiction', 1),
('The Seven Husbands of Evelyn Hugo', 'Taylor Jenkins Reid', 'Historical Fiction', 1),
('Daisy Jones & The Six', 'Taylor Jenkins Reid', 'Historical Fiction', 1),
('Where the Crawdads Sing', 'Delia Owens', 'Fiction', 1),
('The Huntress', 'Kate Quinn', 'Historical Fiction', 1),
('The Night Circus', 'Erin Morgenstern', 'Fantasy', 1),
('Little Fires Everywhere', 'Celeste Ng', 'Fiction', 1),
('The Light We Lost', 'Jill Santopolo', 'Fiction', 1),
('Big Little Lies', 'Liane Moriarty', 'Fiction', 1),
('The Woman in the Window', 'A.J. Finn', 'Thriller', 1),
('The Couple Next Door', 'Shari Lapena', 'Thriller', 1),
('The Girl on the Train', 'Paula Hawkins', 'Thriller', 1),
('Before We Were Strangers', 'Renée Carlino', 'Romance', 1),
('The Rosie Project', 'Graeme Simsion', 'Romance', 1),
('The Giver of Stars', 'Jojo Moyes', 'Historical Fiction', 1),
('A Man Called Ove', 'Fredrik Backman', 'Fiction', 1),
('Educated', 'Tara Westover', 'Memoir', 1),
('Becoming', 'Michelle Obama', 'Memoir', 1),
('The Immortal Life of Henrietta Lacks', 'Rebecca Skloot', 'Non-fiction', 1),
('Born a Crime', 'Trevor Noah', 'Memoir', 1),
('Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Non-fiction', 1),
('The Subtle Art of Not Giving a F*ck', 'Mark Manson', 'Self-help', 1),
('The Body Keeps the Score', 'Bessel van der Kolk', 'Non-fiction', 1),
('Atomic Habits', 'James Clear', 'Self-help', 1),
('The Alchemist', 'Paulo Coelho', 'Fiction', 1),
('Life of Pi', 'Yann Martel', 'Fiction', 1),
('The Kite Runner', 'Khaled Hosseini', 'Fiction', 1),
('A Thousand Splendid Suns', 'Khaled Hosseini', 'Fiction', 1),
('The Book Thief', 'Markus Zusak', 'Historical Fiction', 1),
('The Fault in Our Stars', 'John Green', 'Young Adult', 1),
('Looking for Alaska', 'John Green', 'Young Adult', 1),
('The Perks of Being a Wallflower', 'Stephen Chbosky', 'Young Adult', 1),
('It Ends with Us', 'Colleen Hoover', 'Romance', 1),
('Verity', 'Colleen Hoover', 'Thriller', 1),
('Beach Read', 'Emily Henry', 'Romance', 1),
('One Last Stop', 'Casey McQuiston', 'Romance', 1),
('The Flatshare', 'Beth O’Leary', 'Romance', 1),
('The Spanish Love Deception', 'Elena Armas', 'Romance', 1),
('The Hating Game', 'Sally Thorne', 'Romance', 1),
('The Unhoneymooners', 'Christina Lauren', 'Romance', 1),
('The Deal', 'Elle Kennedy', 'Romance', 1),
('Red, White & Royal Blue', 'Casey McQuiston', 'Romance', 1),
('The Nightingale', 'Kristin Hannah', 'Historical Fiction', 1),
('The Book of Lost Names', 'Kristin Harmel', 'Historical Fiction', 1),
('The Tattooist of Auschwitz', 'Heather Morris', 'Historical Fiction', 1),
('The Henna Artist', 'Alka Joshi', 'Historical Fiction', 1),
('The Overstory', 'Richard Powers', 'Literary Fiction', 1),
('Pachinko', 'Min Jin Lee', 'Historical Fiction', 1),
('The Vanishing Half', 'Brit Bennett', 'Fiction', 1),
('The City We Became', 'N.K. Jemisin', 'Fantasy', 1),
('The Poppy War', 'R.F. Kuang', 'Fantasy', 1),
('Crescent City', 'Sarah J. Maas', 'Fantasy', 1),
('The Priory of the Orange Tree', 'Samantha Shannon', 'Fantasy', 1),
('House of Earth and Blood', 'Sarah J. Maas', 'Fantasy', 1),
('The Shadow of the Wind', 'Carlos Ruiz Zafón', 'Literary Fiction', 1),
('The Night Watchman', 'Louise Erdrich', 'Historical Fiction', 1),
('The Overstory', 'Richard Powers', 'Literary Fiction', 1);














INSERT INTO librarians (username, password) VALUES ('gaurab', '$2y$10$HEQ/fRBwKEuC0aD7p75tau9OfrAs7TphAlWPeasg0x0iSZ7zutD/a');