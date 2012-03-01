<?php

		$possible_lang = array (
			'en' => 'English',
			'fr' => 'French',
			'sp' => 'Spanish'
		);
		
		$errors = array();
		$display_thanks = false;
		
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);
		$notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
		$lang = filter_input(INPUT_POST, 'lang', FILTER_SANITIZE_STRING);
		$terms = filter_input(INPUT_POST, 'terms', FILTER_DEFAULT);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (empty($name)) {
				$errors['name'] = true;
			}
		
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = true;
			}
		
			if (mb_strlen($username) > 25) {
				$errors['username'] = true;
			}
		
			if (empty($password)) {
				$errors['password'] = true ;
			}
		
			if (!array_key_exists($lang, $possible_lang)) {
				$errors['lang'] = true;
			}
		
			if (empty($terms)) {
			$errors['terms'] = true;
			}
		
			if (empty($errors)) {
				$display_thanks = true;
		
				$email_message = 'Name: ' . $name . "\r\n";
				$email_message .= 'Email ' . $email . "\r\n";
				$email_message .= "Message:\r\n" . $message;
				
				$headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
				
				
				mail($email, $username, $email_message);
			}
			
			}
			
		
?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration Form Validation</title>
    <link href="css/general.css" rel="stylesheet">
</head>
		
	<body>

	<?php if ($display_thanks) : ?>
		<strong>Thank you for using our mail form</strong>
	<?php else : ?>
		<form method="post" action="index.php">
			<h1>EMAIL FORM</h1>
		
        	<div>
				<label for="name">Name </label>
				<input type="name" id="name" name="name" value="<?php echo $name; ?>" required><?php if (isset($errors['name'])) : ?> <strong>is required</strong><?php endif; ?>
			</div>
			
            <div>
				<label for="email">Email </label>
				<input type="email" id="email" name="email" value="<?php echo $email; ?>" required><?php if (isset($errors['email'])) : ?> <strong>enter a valid email address</strong><?php endif; ?>
			</div>
		
        	<div>
				<label for="username">Username </label>
				<input type="text" id="username" name="username" value="<?php echo $username; ?>" required><?php if (isset($errors['username'])) : ?> <strong>less than 25 characters</strong><?php endif; ?>
			</div>
			
            <div>
				<label for="password">Password </label>
				<input type="password" id="password" name="password" value="<?php echo $password; ?>" required><?php if (isset($errors['password'])) : ?> <strong>please enter a password</strong><?php endif; ?>
			</div>
			
            <div>
				<fieldset>
					<legend class="pref">Preferred Language</legend><?php if (isset($errors['lang'])) : ?> <strong>choose a language</strong><?php endif; ?>
				<?php foreach($possible_lang as $key => $value) : ?>
					<input type="radio" id="<?php echo $key; ?>" name="lang" value="<?php echo $key; ?>"<?php if ($key == $lang) { echo ' checked'; } ?> required>
					<label for="<?php echo $key; ?>"><?php echo $value; ?></label>
				<?php endforeach; ?>
				</fieldset>
			</div>
			
            <div>
				<label for="notes"><strong>Notes </strong></label>
				<textarea id="notes" name="notes"><?php echo $notes; ?></textarea>
			</div>
		
        	<div>
				<fieldset>
					<input type="checkbox" id="terms" name="terms" required>
					<label for="terms">Accept the Terms</label><?php if (isset($errors['terms'])) : ?> <strong>must accept the terms</strong><?php endif; ?>
				</fieldset>
			</div>

			<div>
				<button type="submit" name="submit"><strong>Send Message</strong></button>
			</div>
				</form>
			<?php endif; ?>
		
</body>
</html>