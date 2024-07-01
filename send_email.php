<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Honeypot field
  if (!empty($_POST['website'])) {
    // Bot detected
    echo '<script>alert("Bot detected"); window.history.back();</script>';
    exit;
  }

  // Verify reCAPTCHA
  $recaptchaSecret = 'your_secret_key'; // Replace with your secret key
  $recaptchaResponse = $_POST['g-recaptcha-response'];

  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
  $responseKeys = json_decode($response, true);

  if (intval($responseKeys["success"]) !== 1) {
    echo '<script>alert("Please complete the CAPTCHA"); window.history.back();</script>';
    exit;
  }

  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<script>alert("Invalid email format"); window.history.back();</script>';
    exit;
  }

  // Enhanced spam keyword filter
  $spamKeywords = [
    'spam', 'viagra', 'free', 'offer', 'winner', 'prize', 'urgent', 'buy now', 'limited time', 'click here',
    'subscribe', 'act now', 'apply now', 'bonus', 'claim', 'credit', 'earn', 'easy', 'extra cash', 'fast cash',
    'guarantee', 'income', 'investment', 'loan', 'lose weight', 'money back', 'no cost', 'online biz opportunity',
    'promise you', 'risk-free', 'sale', 'save big', 'special promotion', 'unsecured credit', 'weight loss',
    'work from home', 'xxx', 'adult', 'casino', 'lottery', 'gamble', 'no fees', 'clearance', 'limited offer',
    'discount', 'cash', 'luxury', 'urgent response', 'meet singles', 'sex', 'sexually explicit', 'earn money', 'quick cash'
  ];

  foreach ($spamKeywords as $keyword) {
    if (stripos($message, $keyword) !== false) {
      echo '<script>alert("Spam detected. Please revise your message."); window.history.back();</script>';
      exit;
    }
  }

  // Implement rate limiting (e.g., by IP address)
  session_start();
  if (!isset($_SESSION['last_submit_time'])) {
    $_SESSION['last_submit_time'] = time();
  } else {
    $timeSinceLastSubmit = time() - $_SESSION['last_submit_time'];
    if ($timeSinceLastSubmit < 60) { // Limit to one submission per minute
      echo '<script>alert("You are submitting too fast. Please wait a moment."); window.history.back();</script>';
      exit;
    } else {
      $_SESSION['last_submit_time'] = time();
    }
  }

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = 'your_smtp_server'; // Your SMTP server address
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com'; // Your email account
    $mail->Password = 'your_password'; // Your email account password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Using STARTTLS
    $mail->Port = 587; // SMTP port for STARTTLS

    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => true,
        'verify_peer_name' => true,
        'allow_self_signed' => false,
        'cafile' => '/path/to/cacert.pem' // Path to the cacert.pem file
      )
    );

    // Set the sender's email address and name
    $mail->setFrom('your_email@example.com', 'Your Name or Business'); // Your email account

    // Set the recipient's email address
    $mail->addAddress('recipient_email@example.com'); // Recipient email address

    $mail->isHTML(true);
    $mail->Subject = "Contact Form Submission from $name";
    $mail->Body    = "<h2>Contact Form Submission</h2>
                      <p><strong>Name:</strong> $name</p>
                      <p><strong>Email:</strong> $email</p>
                      <p><strong>Message:</strong><br>$message</p>";

    // Disable detailed debugging output
    $mail->SMTPDebug = 0; // Disable debugging output

    $mail->send();
    echo '<script>alert("Message has been sent successfully!"); window.location.href = "contact.html";</script>';
  } catch (Exception $e) {
    echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '"); window.history.back();</script>';
  }
}
?>
