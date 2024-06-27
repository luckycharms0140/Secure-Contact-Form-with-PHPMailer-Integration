# Secure-Contact-Form-with-PHPMailer-Integration
This project is a contact form implementation that securely sends user-submitted data via email using PHP and PHPMailer. The project includes an HTML form and a PHP script to handle the form submission, ensuring data integrity and confidentiality through several security measures.

HTML Form Interaction
The HTML form allows users to input their name, email, and message. Upon submission, the form data is sent to the PHP script via the POST method. The PHP script processes this data and sends it as an email to a specified recipient.

Security Measures
Data Sanitization and Validation:

Protection: Prevents malicious code injection and ensures data integrity.
Implementation: User inputs are sanitized and validated. The email address is sanitized using FILTER_SANITIZE_EMAIL and validated using FILTER_VALIDATE_EMAIL. Other inputs are sanitized using htmlspecialchars to escape special characters.
Using PHPMailer for Secure Email Sending:

Protection: Ensures secure email transmission.
Implementation: PHPMailer is configured to use secure SMTP connections with STARTTLS encryption, ensuring that emails are sent securely.
SSL/TLS Configuration:

Protection: Enhances security of the SMTP connection.
Implementation: SSL/TLS options are set to verify peer and peer name, and to use a CA certificate file. This ensures the authenticity of the SMTP server and encrypts the connection.
Error Handling:

Protection: Provides user-friendly error messages and handles exceptions gracefully.
Implementation: The script uses try-catch blocks to handle exceptions. User-friendly alerts are shown for both successful email sending and errors.
Preventing Cross-Site Scripting (XSS):

Protection: Prevents execution of malicious scripts in the user's browser.
Implementation: User inputs are sanitized using htmlspecialchars, which converts special characters to HTML entities, preventing script execution.
Preventing Email Header Injection:

Protection: Prevents attackers from injecting additional email headers.
Implementation: PHPMailer handles email headers securely, mitigating the risk of header injection attacks.
HTTPS:

Protection: Encrypts data in transit between the user's browser and the server.
Implementation: The website should be served over HTTPS. An SSL certificate should be obtained and installed to ensure encrypted communication.
Security Issues Addressed
Cross-Site Scripting (XSS):

Issue: XSS attacks occur when an attacker injects malicious scripts into webpages viewed by other users.
Solution: Sanitizing user inputs with htmlspecialchars to prevent execution of injected scripts.
Email Header Injection:

Issue: This occurs when an attacker injects malicious email headers to manipulate email delivery.
Solution: Using PHPMailer, which securely handles email headers and prevents injection attacks.
Insecure Data Transmission:

Issue: Data sent over an unencrypted connection can be intercepted by attackers.
Solution: Using STARTTLS encryption for SMTP and serving the website over HTTPS to encrypt data in transit.
Invalid Data Submission:

Issue: Unvalidated user input can lead to data integrity issues and security vulnerabilities.
Solution: Validating and sanitizing user inputs to ensure they meet the expected format and content.

Step-by-Step Setup Guide
1. Clone the Repository to your local machine using:

2. Download PHPMailer: Visit the PHPMailer GitHub page. Download the latest release as a ZIP file. Extract the ZIP file and move the src folder to your project directory under a new folder named PHPMailer. Upload Files to Your Server

3. Connect to your web hosting account (e.g., using cPanel or an FTP client). Navigate to the public_html directory (or the root directory of your website). Upload the following files and directories from your project:contact.html, send_email.php, PHPMailer directory (containing the src folder with PHPMailer files), cacert.pem file
   
4. Edit send_email.php with Your Details

Open send_email.php in a text editor.
Replace the placeholders with your specific details:
'your_smtp_server': Your SMTP server address.
'your_email@example.com': Your email account.
'your_password': Your email account password.
'/path/to/cacert.pem': The path to the cacert.pem file on your server.
'Your Name or Business': The name you want to appear as the sender.
'recipient_email@example.com': The email address where you want to receive the contact form submissions.

5.Ensure Your Server Supports SMTP: Check that your server supports SMTP connections and that the necessary ports (usually 587 for STARTTLS or 465 for SSL) are open.
Set Up Environment Variables (Optional for Security)

6. For better security, store sensitive data such as your email password in environment variables instead of hardcoding them in the PHP file.
In your send_email.php, replace the sensitive data with environment variables:
php
Copy code:
$mail->Username = getenv('EMAIL_USERNAME');
$mail->Password = getenv('EMAIL_PASSWORD');
Set these environment variables in your hosting control panel or in an .htaccess file:
SetEnv EMAIL_USERNAME your_email@example.com
SetEnv EMAIL_PASSWORD your_password
Test the Contact Form

Navigate to your contact form page in your web browser (e.g., http://yourdomain.com/contact.html).
Fill out the form and submit it.
Check the inbox of the recipient email address to verify that the email was received.
Enable HTTPS on Your Website

Ensure your website uses HTTPS to encrypt the communication between the user's browser and your server. Obtain and install an SSL certificate if you haven’t already.
You can usually do this via your hosting provider's control panel.
Summary of Files and Directories
scss

project-directory/
├── public_html/
│   ├── contact.html
│   ├── send_email.php
│   ├── cacert.pem
│   ├── PHPMailer/
│   │   ├── src/
│   │   │   ├── Exception.php
│   │   │   ├── PHPMailer.php
│   │   │   ├── SMTP.php
│   │   ├── ... (other PHPMailer files)
│   ├── styles.css (optional)
Additional Notes
Security: Regularly update your server’s operating system and software packages to ensure you have the latest security patches.
Firewalls: Implement a firewall to restrict unauthorized access to your server.
Passwords: Use strong and complex passwords for all accounts.
By following these steps, anyone should be able to set up and implement the contact form with secure email sending using PHPMailer. If you encounter any issues, refer to the PHPMailer documentation or seek support from your hosting provider.
