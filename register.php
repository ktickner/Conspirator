<div class="col-md-8 col-md-offset-2">
	<h3 class="dark-grey">Registration</h3>
	<div class="row">
		<div class="col-md-12">
			<form action="user.php" method="post">
				<div class="row">
					<div class="form-group col-md-6">
						<label>Email Address</label>
						<input type="email" name="email" class="form-control" value="" required />
					</div>

					<div class="form-group col-md-6">
						<label>Repeat Email Address</label>
						<input type="email" name="emailRepeat" class="form-control" value="" required />
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-6">
						<label>Password</label>
						<input type="password" name="password" class="form-control" id="" value="" required />
					</div>

					<div class="form-group col-md-6">
						<label>Repeat Password</label>
						<input type="password" name="passwordRepeat" class="form-control" id="" value="" required />
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-6">
						<label>First Name</label>
						<input type="text" name="firstName" class="form-control" id="" value="" required />
					</div>

					<div class="form-group col-md-6">
						<label>Last Name</label>
						<input type="text" name="lastName" class="form-control" id="" value="" required />
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-10 col-md-offset-1">
						<label>Avatar</label>
						<input name="avatar" type="file" value="" />
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-12">
						<label>Bio</label>
						<textarea name="bio" value="" placeholder="Tell everyone a little about yourself" rows="3" class="form-control" required></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-10 col-md-offset-1 checkbox">
						<label>
							<input type="checkbox" />Send me information about the Published & Digital Magazine
						</label>
					</div>
				</div>			
				
				<div class="row">
					<div class="col-md-12">
						<input type="submit" name="register" value="Register" class="btn btn-success pull-right register-btn">
						<!-- Large modal -->
						<button type="button" class="btn btn-primary pull-right register-btn" data-toggle="modal" data-target=".bs-example-modal-lg">Terms & Conditions</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<p>
					By clicking on "Register" you agree to The Conspirators' Terms and Conditions
				</p>

				<p>
					We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libellous, defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms of Service. (Paragraph 13.5.8)
				</p>

				<p>
					In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its 	content: (a) for any unlawful purpose; (b) to solicit others to perform or participate in any unlawful acts; (c) to violate any international, federal, provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or violate our intellectual property rights or the intellectual property rights of others; (e) to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to submit false or misleading information; (g) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet; (h) to collect or track the personal information of others; (i) to spam, phish, pharm, pretext, spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet. We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses.(Paragraph 13.5.6)
				</p>
			</div>
		</div>
	</div>
</div>