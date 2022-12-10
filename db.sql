-- CREATE DATEBASE
CREATE DATABASE IF NOT EXISTS gallery;

-- POSTS TABLE
CREATE TABLE IF NOT EXISTS posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  post_filename VARCHAR(255) NOT NULL,
  post_title VARCHAR(255) NOT NULL,
  post_body TEXT NOT NULL,
  post_author VARCHAR(255) NOT NULL,
  post_created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  post_updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)

-- COMMENTS TABLE
CREATE TABLE IF NOT EXISTS comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  comment_body VARCHAR(255) NOT NULL,
  comment_author VARCHAR(255) NOT NULL,
  comment_created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE ON UPDATE NO ACTION
)


-- SOME POSTS
INSERT INTO posts (post_filename, post_title, post_body, post_author) VALUES
  ('Throne For the Game.jpg', 'The iron throne', "In both Game of Thrones and House of the Dragon, the Iron Throne is the seat of the king or queen of the Seven Kingdoms of Westeros and a symbol of the authority and danger that comes with ruling. It has also been known to cut some of the rulers who sit in it, supposedly symbolising that they aren't fit to rule.", 'Yassine'),
  ('Aspyer_morocco_with_ice_feels_cold_everybody_wears_jackets_rain_e1c59aa5-e497-4744-836e-a5830ffe23e7.png', 'AI Generated picture of Moroccan Atlas Mountains', "AI Generated picture of Moroccan Atlas Mountains", 'Y. Oumaima'),
  ('image3.jpg', 'OpenAI ChatGPT', "ChatGPT is a prototype artificial intelligence chatbot developed by OpenAI that specializes in dialogue. The chatbot is a large language model fine-tuned with both supervised and reinforcement learning techniques. The base model that was fine-tuned was OpenAI's GPT-3 language model.", 'Zakaria Fadil');

-- SOME COMMENTS
INSERT INTO comments (post_id, comment_body, comment_author) VALUES
  (1, 'Magnifique!', 'Hamza'),
  (1, 'Jolie!', 'Y. Imane'),
  (1, 'Avez-vous une chance de relier la grille à une galerie publique de sites construits avec yassinethegoat.com?', 'Ibrahim'),
  (2, "J'adore!", 'Karim'),
  (2, 'Wow!', 'Sofia Km'),
  (3, 'Thats Crazy!', 'Soufiane Kamel'),
  (3, "O_O", 'Salma Jamal')


