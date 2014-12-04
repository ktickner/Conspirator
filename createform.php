<div class="col-md-12 center-block">
	<?php
		if($valid == false)
		{
	?>
	<div class="alert alert-danger">
	<?php
			foreach($errors as $error)
			{
				echo("<p>$error</p>");
			}
			echo("</div>");
		}
	?>
	<div class="row">
		<h3>Create a User</h3>
	</div>
	<?php
		echo '<form class="form-horizontal" action="index.php?page=create&type='.$type.'" method="post" enctype="multipart/form-data">';
	?>
		<div class="control-group <?php echo !empty($emailError) ? 'error' : '';?>">
			<label class="control-label">Email</label>
			<div class="controls">
				<input name="email" type="text"  placeholder="Email" value="<?php echo !empty($email) ? $email : '' ;?>" required />
				<?php if (!empty($emailError)): ?>
					<span class="help-inline"><?php echo $emailError;?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($passwordError) ? 'error' : '';?>">
			<label class="control-label">Password</label>
			<div class="controls">
				<input name="password" type="password" value="<?php echo !empty($password) ? $password : ''; ?>" required />
				<?php if (!empty($passwordError)): ?>
					<span class="help-inline"><?php echo $passwordError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($firstNameError) ? 'error' : '';?>">
			<label class="control-label">First Name</label>
			<div class="controls">
				<input name="firstName" type="text"  placeholder="First name" value="<?php echo !empty($firstName) ? $firstName : '';?>" required />
				<?php if (!empty($firstNameError)): ?>
					<span class="help-inline"><?php echo $firstNameError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($lastNameError) ? 'error' : '';?>">
			<label class="control-label">Last Name</label>
			<div class="controls">
				<input name="lastName" type="text"  placeholder="Last name" value="<?php echo !empty($lastName) ? $lastName : '';?>" required />
				<?php if (!empty($lastNameError)): ?>
					<span class="help-inline"><?php echo $lastNameError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($permissionsError) ? 'error' : '';?>">
			<label class="control-label">Set Permissions</label>
			<div class="controls">
				<select name="permissions" required>
					<option value="1" <?php if( $permissions == '1' ){ echo 'selected'; } ?>>User</option>
					<option value="2" <?php if( $permissions == '2' ){ echo 'selected'; } ?>>Author</option>
					<option value="3" <?php if( $permissions == '3' ){ echo 'selected'; } ?>>Admin</option>
				</select>
				<?php if (!empty($permissionsError)): ?>
					<span class="help-inline"><?php echo $permissionsError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($avatarError) ? 'error' : '';?>">
			<label class="control-label">Avatar</label>
			<div class="controls">
				<input name="avatar" type="file" value="<?php echo !empty($avatar) ? $avatar : ''; ?>" required />
				<?php if (!empty($avatarError)): ?>
					<span class="help-inline"><?php echo $avatarError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($bioError) ? 'error' : '';?>">
			<label class="control-label">Bio</label>
			<div class="controls">
				<textarea name="bio" value="<?php echo !empty($bio) ? $bio : '';?>" required></textarea>
				<?php if (!empty($bioError)): ?>
					<span class="help-inline"><?php echo $bioError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group">
			<input type="submit" class="btn btn-success" value="Create"/>
			<?php echo'<a class="btn" href="index.php?page=crud&type='.$type.'">Back</a>';?>
		</div>
	</form>
</div>

<div class="col-md-12 center-block">
	<?php
		if($valid != true)
		{
	?>
	<div class="alert alert-danger">
	<?php
			foreach($errors as $error)
			{
				echo("<p>$error</p>");
			}
	?>
	</div>
	<?php
		}
	?>
	<div class="row">
	<?php
		if ($type == 'article' || $type == 'archive')
		{
			if($type == 'archive')
			{
				echo('<h3>Write an Archive</h3>');
			}
			else
			{
				echo('<h3>Write an Article</h3>');
			}

	?>
	</div>
	<?php	
			echo '<form class="form-horizontal" action="index.php?page=create&type='.$type.'" method="post" enctype="multipart/form-data">';
	?>
		<div class="control-group <?php echo !empty($nameError) ? 'error' : '';?>">
			<label class="control-label">Article Name</label>
			<div class="controls">
				<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name) ? $name : '' ;?>" required />
				<?php if (!empty($nameError)): ?>
					<span class="help-inline"><?php echo $nameError;?></span>
				<?php endif; ?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($imageError) ? 'error' : '';?>">
			<label class="control-label">Feature Image</label>
			<div class="controls">
				<input name="image" type="file" value="<?php echo !empty($image) ? $image : ''; ?>" required />
				<?php if (!empty($imageError)): ?>
					<span class="help-inline"><?php echo $imageError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group <?php echo !empty($categoryError) ? 'error' : '';?>">
			<label class="control-label">Select a Category</label>
			<div class="controls">
				<select name="category" required>
					<option value="1" <?php if( $category == '1' ){ echo 'selected'; } ?>>History</option>
					<option value="2" <?php if( $category == '2' ){ echo 'selected'; } ?>>Government / Evil Corporations</option>
					<option value="3" <?php if( $category == '3' ){ echo 'selected'; } ?>>Aliens</option>
					<option value="4" <?php if( $category == '4' ){ echo 'selected'; } ?>>Exotic Creatures</option>
					<option value="5" <?php if( $category == '5' ){ echo 'selected'; } ?>>Urban Legends</option>
					<option value="6" <?php if( $category == '6' ){ echo 'selected'; } ?>>End of Days</option>
				</select>
				<?php if (!empty($categoryError)): ?>
					<span class="help-inline"><?php echo $categoryError; ?></span>
				<?php endif;?>
			</div>
		</div>
		<?php
			if ($type == 'archive')
			{
		?>
		<div class="control-group <?php echo !empty($quickFactsError) ? 'error' : '';?>">
			<label class="control-label">Quick Facts</label>
			<div class="controls">
				<textarea name="quickFacts" rows="10" class="MCEcontent" value="<?php echo !empty($quickFacts) ? $quickFacts : '';?>"></textarea>
				<?php if (!empty($quickFactsError)): ?>
					<span class="help-inline"><?php echo $quickFactsError; ?></span>
				<?php endif;?>
			</div>
		</div>
		<?php
			}
		?>
		<div class="control-group <?php echo !empty($contentError) ? 'error' : '';?>">
			<label class="control-label">Article Content</label>
			<div class="controls">
				<textarea class="MCEcontent" name="content" rows="10" value="<?php echo !empty($content) ? $content : '';?>"></textarea>
				<?php if (!empty($contentError)): ?>
					<span class="help-inline"><?php echo $contentError; ?></span>
				<?php endif;?>
			</div>
		</div>

		<div class="control-group">
			<input type="submit" name="create" class="btn btn-success" value="Create">
			<?php echo'<a class="btn" href="index.php?page=crud&type='.$type.'">Back</a>';?>
		</div>
	</form>
</div>

	<?php
		}
		else
		{
	?>

<div class="alert alert-danger">
	<h3>I'm not sure you're meant to be here! Please return to the homepage <a href="index.php">here</a></h3>
</div>

	<?php
		}
	?>