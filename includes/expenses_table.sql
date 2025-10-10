-- Create an expenses table for non-sales expenses
CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    expense_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
