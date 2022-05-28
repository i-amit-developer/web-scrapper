<html>
	<head>
		<title>Home | Data Scrapper</title>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<?php
		$data = [];
		if (isset($_POST['submit'])) {
		
			$base = $_POST['url'];
			$fileObj = array_reverse( explode('/',$_POST['url']) );
			$file_name = $fileObj[0];

			if( $fileObj[0] =='' ){
				$file_name = $fileObj[1];
			}
			
			require 'simple_html_dom.php';
		
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_URL, $base);
			curl_setopt($curl, CURLOPT_REFERER, $base);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			$str = curl_exec($curl);
			curl_close($curl);
		
			// Create a DOM object
			$html_base = new simple_html_dom();
			
			// Load HTML from a string
			$html_base->load($str);
		
			$blogdata = [];

			// Specify your Identifier tag/Class/ID here
			foreach ($html_base->find('body *') as $key => $element) {
				$data[$key]['tag'] = $element->tag;
				$data[$key]['content'] = $element->plaintext;

				// Advance Version
				// if ($tagName == 'p') {
				// 	$title 		= $element->find('strong', 0)->plaintext;
		
				// 	$displayAddr[] = $element->outertext;
				// 	$addr 		= $element->outertext;
				// 	$addrExplode = array_reverse(array_filter(explode('<br>', $addr)));
		
				// 	$website = str_get_html($addrExplode[1]);
				// 	$websiteAddr = '';
				// 	if($website){
				// 		$websiteAddr = @$website->find("a", 0)->href;
				// 	}
		
				// 	$phone = @$addrExplode[2];
				// 	$addrs = @$addrExplode[3];
		
				// 	if ($websiteAddr == null) {
				// 		$phone = $addrExplode[1];
				// 		$addrs = $addrExplode[2];
				// 	}
		
				// 	if (!isset($addrExplode[3])) {
				// 		$phone = '';
				// 		$addrs = $addrExplode[1];
				// 	}
		
				// 	$blogdata[$key]["Name"] = $title;
				// 	$blogdata[$key]["Phone"] = strip_tags($phone);
				// 	$blogdata[$key]["Address"] = strip_tags($addrs);
				// 	$blogdata[$key]["Website"] = $websiteAddr;
				// } else {
				// 	$blogdata[$key]["Name"] = $element->plaintext;
				// 	$blogdata[$key]["Phone"] = '';
				// 	$blogdata[$key]["Address"] = '';
				// 	$blogdata[$key]["Website"] = '';
				// }
			}
		}
	?>
	<body style="text-align: center;">
		<div class="container-fluid ps-md-0">
			<div class="row g-0">
				<div class="col-md-12 col-xs-12 col-lg-6 bg-image"></div>
					<div class="col-md-8 col-lg-6">
						<div class="login d-flex align-items-center py-5">
							<div class="container">
								<div class="row">
									<div class="col-md-9 col-lg-8 mx-auto">
									<h3 class="login-heading mb-4">Data Scrapper!</h3>
									<form action="" method="post">
										<div class="form-floating mb-3 text-left">
											<label for="webaddressInput">Web Address</label>
											<input type="text" class="form-control" required name="url" id="webaddressInput" placeholder="https://google.com">
										</div>		
										<div class="form-group mt-5">
											<input type="submit" class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" value="Scrap Data" name="submit">
										</div>
									</form>
									<?php 
										// run loop through each row in $customers_data
										if( isset($data) && !empty($data) ){
											echo '<div class="text-left">';
											foreach ($data as $row) {	
													echo "<i>Tag</i> - <code>".$row['tag']."</code><br>";
													echo "<i>Content</i> - ".$row['content'];
													echo "<br><hr>";
											}
											echo "</div>";
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>