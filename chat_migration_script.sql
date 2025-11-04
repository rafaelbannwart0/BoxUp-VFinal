use boxup;
CREATE TABLE IF NOT EXISTS chat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mudanca_id INT NOT NULL,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mudanca_id) REFERENCES mudanca(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES usuario(id) ON DELETE CASCADE
    FOREIGN KEY (receiver_id) REFERENCES usuario(id) ON DELETE CASCADE
);