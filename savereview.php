<?php  
		  include("db.php");
		  include("sup_mail.php");
		  ensure_logged_in();

		  
		  

  		
		  $company=htmlspecialchars($_POST["company"]);
          $address=htmlspecialchars($_POST["address"]);
		  $city=htmlspecialchars($_POST["city"]);
          $review=htmlspecialchars($_POST["review"]);
		  $lng=htmlspecialchars($_POST["lng"]);
		  $lat=htmlspecialchars($_POST["lat"]);
		  $rating=htmlspecialchars($_POST["rating"]);
          
		  $water=htmlspecialchars(pType("Water", $_POST["water"]));
          $air=htmlspecialchars(pType("Air", $_POST["air"]));
          $waste=htmlspecialchars(pType("Waste", $_POST["waste"]));
          $land=htmlspecialchars(pType("Land", $_POST["land"]));
          $living=htmlspecialchars(pType("Ecosystem",$_POST["living"]));
          $other=htmlspecialchars(pType("Other",$_POST["other"]));
          $other_item=htmlspecialchars($_POST["other_item"]);

		  function pType ($p_name, $p_type){
			  if  (isset($p_type))
			  {				  
				  return $p_name;
			  }
			  else{
				  return $p_type;
			  }
		  }

		  if  (isset($other_item))
		  {				  
				$other=$other_item;
		  }
			  

		  		  
		  $news=htmlspecialchars($_POST["news"]);

		  $industry=htmlspecialchars($_POST["industry"]);
          $product=htmlspecialchars($_POST["product"]);
		  $epa=htmlspecialchars($_POST["epa"]);
		  $measure=htmlspecialchars($_POST["measure"]);
		  $token=htmlspecialchars($_POST["token"]);


		  if(!isset($token) || !isset($_SESSION["token"]) || $token !== $_SESSION["token"]) {
				//print "Error: Your session is invalid. Transfer not performed. Or please check uploading image size.";
				redirect("WriteReview.php", "Sorry, your session is invalid. Transfer not performed. Or please check uploading image size.");
				die();
		  } else {
		  		unset($_SESSION["token"]);
		   
		  
		  try{
				  //$db=new PDO("mysql:dbname=myGreenGuide;host=us-cdbr-azure-west-b.cleardb.com","b4f6ad8be99b99","0ba0581c");
				  //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				  	/*
				   	  $company=$con->quote($company);
			          $address=$con->quote($address);
					  $city=$con->quote($city);
			          $review=$con->quote($review);
					  $lng=$con->quote($lng);
					  $lat=$con->quote($lat);
					  //$rating=$con->quote($rating);
			          
					  $water=$con->quote($water);
			          $air=$con->quote($air);
			          $waste=$con->quote($waste);
			          $land=$con->quote($land);
			          $living=$con->quote($living);
			          $other=$con->quote($other);					  
					  $news=$con->quote($news);

					  $industry=$con->quote($industry);
					  $product=$con->quote($product);
					  $epa=$con->quote($epa);
					  $measure=$con->quote($measure);
					*/

				  	
				  //$result=$con->query("insert into review (company, address, city, review, lng, lat, rating, water, air, waste, land, living, other, news, industry, product, epa, measure) values($company, $address, $city, $review, $lng, $lat, $rating, $water, $air, $waste, $land, $living, $other, $news, $industry, $product, $epa, $measure)");
				  





				  //echo "Last inserted ID is: " . $last_id;	
				  //print_r($_FILES);
				  //if(is_uploaded_file($_FILES['image']['tmp_name'])){
						if(isset($_FILES['image']['tmp_name'])){	

						  		

				  				$img_size=0;
				  				foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){
				  					if($_FILES['image']['tmp_name'][$key]){
				  						$img_size+=$_FILES['image']['size'][$key];
				  					}
				  				}

				  				if($img_size>1048576){
						  			redirect("WriteReview.php", "Sorry, image size is bigger than 1 MB. Please rewrite the review again.");
				  				}else{

				  					  $result=$db->prepare("insert into review (company, address, city, review, lng, lat, rating, water, air, waste, land, living, other, news, industry, product, epa, measure) values(:company, :address, :city, :review, :lng, :lat, :rating, :water, :air, :waste, :land, :living, :other, :news, :industry, :product, :epa, :measure)");					    
									  $result->bindParam(':company', $company);
									  $result->bindParam(':address', $address);
									  $result->bindParam(':city', $city);
									  $result->bindParam(':review', $review);
									  $result->bindParam(':lng', $lng);
									  $result->bindParam(':lat', $lat);
									  $result->bindParam(':rating', $rating);

									  $result->bindParam(':water', $water);
									  $result->bindParam(':air', $air);
									  $result->bindParam(':waste', $waste);
									  $result->bindParam(':land', $land);
									  $result->bindParam(':living', $living);
									  $result->bindParam(':other', $other);
									  $result->bindParam(':news', $news);

									  $result->bindParam(':industry', $industry);
									  $result->bindParam(':product', $product);
									  $result->bindParam(':epa', $epa);
									  $result->bindParam(':measure', $measure);

									  $result->execute();

									  $last_id = $db->lastInsertId();

						  		  //echo "image OK! ";	
						  		  	  $target_dir = "uploads/";	
									  foreach($_FILES['image']['tmp_name'] as $key => $tmp_name){

												
												
										  //echo "tmp_name is: " . $tmp_name;
									  			if($_FILES['image']['tmp_name'][$key]){
														  $image=addslashes($_FILES['image']['tmp_name'][$key]);
														  //$name=addslashes($_FILES['image']['name'][$key]);
														  $image=file_get_contents($image);
														  $image=base64_encode($image);
														  //$result=$con->query("insert into image (name,image,review_id) values('$name','$image','$last_id')");
														  //$result=$con->query("insert into image (image,review_id) values('$image','$last_id')");
														  //$result=$con->prepare("insert into image (image,review_id) values(:image,:last_id)");
														  //$result->bindParam(':image', $image);
														  //$result->bindParam(':last_id', $last_id);
														  //$result->execute();

														  $up_size=$_FILES['image']['size'][$key]; 

														  $target_file = $target_dir . basename(addslashes($_FILES['image']['name'][$key]));
                                                          $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                                          //$result=$db->prepare("insert into image (image,review_id,size) values(:image, :last_id, :size)");
                                                          //$result=$db->prepare("insert into image (review_id,size) values(:last_id, :size)");
                                                          $result=$db->prepare("insert into image (review_id,size,file_type) values(:last_id, :size, :type)");
                                                          //$result->bindParam(':image', $image);
                                                          $result->bindParam(':last_id', $last_id);
                                                          $result->bindParam(':size', $up_size);
                                                          $result->bindParam(':type', $imageFileType);
                                                          $result->execute();

                                                          $img_last_id = $db->lastInsertId();
                                                         
                                                          $upload_file_name = $target_dir .basename($img_last_id).".". $imageFileType;
                                                          

                                                          if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $upload_file_name)) {
														        echo "The file ". $target_file. " has been uploaded.";
														  } else {
														        echo "Sorry, there was an error uploading your file.";
														  }
												}

												
									  }

									  $size=$db->prepare("UPDATE review SET size=:size where id=:id");
									  $size->bindParam(':size', $img_size);
									  $size->bindParam(':id', $last_id);
									  $size->execute();
								}
						} else {
					//}


									  $result=$db->prepare("insert into review (company, address, city, review, lng, lat, rating, water, air, waste, land, living, other, news, industry, product, epa, measure) values(:company, :address, :city, :review, :lng, :lat, :rating, :water, :air, :waste, :land, :living, :other, :news, :industry, :product, :epa, :measure)");					    
									  $result->bindParam(':company', $company);
									  $result->bindParam(':address', $address);
									  $result->bindParam(':city', $city);
									  $result->bindParam(':review', $review);
									  $result->bindParam(':lng', $lng);
									  $result->bindParam(':lat', $lat);
									  $result->bindParam(':rating', $rating);

									  $result->bindParam(':water', $water);
									  $result->bindParam(':air', $air);
									  $result->bindParam(':waste', $waste);
									  $result->bindParam(':land', $land);
									  $result->bindParam(':living', $living);
									  $result->bindParam(':other', $other);
									  $result->bindParam(':news', $news);

									  $result->bindParam(':industry', $industry);
									  $result->bindParam(':product', $product);
									  $result->bindParam(':epa', $epa);
									  $result->bindParam(':measure', $measure);

									  $result->execute();

									  $last_id = $db->lastInsertId();



							}

								  $s_name=$_SESSION["name"];
								  $result=$db->query("insert into profile (name,review_id) values ('$s_name','$last_id')");

								  $suppliers=$db->query("select * from com_sup where sup_name='$company' and sup_lng='$lng' and sup_lat='$lat'");
								  if($suppliers){
								  		foreach($suppliers as $supplier){
								  				$insert_com_review=$db->query("insert into com_review (com_id, review_id) values ($supplier[1], '$last_id')");
								  				sup_mail($company, $address, $city, $review, $lng, $lat, $rating, $water, $air, $waste, $land, $living, $other, $news);
								  		}
								  }
								  $_SESSION["review_id"] = $last_id;
								  header("Location: http://www.lovegreenguide.com/confirm_review.php");
					

				  							
			}
			catch(Exception $e){
				    //die(print_r($e));
		  		 	die("Sorry, error occured. Please try again.");
			}	  

	}	  
?>		  
