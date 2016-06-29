<?php
	require('admin-security.php');
?>

<?php
		
		if(isset($_POST['files_sent'])&&$_POST['files_sent']<>"1")
		{
		$galerie['nazev'] = $_POST['galerie_nazev'];
		$galerie['popis'] = $_POST['galerie_popis'];
		$galerie['id'] = $this->friendly_url($galerie['nazev']);
		//$galerie['path'] =("..\\gallery\\".$galerie['id']);
		//$galerie['path_thumbs'] =("..\\gallery\\".$galerie['id']."\\thumbs\\");
		$galerie['path'] =("../gallery/".$galerie['id']);
		$galerie['path_thumbs'] =("../gallery/".$galerie['id']."/thumbs/");
		mkdir($galerie['path'], 0700, TRUE);
		mkdir($galerie['path_thumbs'], 0700, TRUE);
		$galerie['images_uploaded']=0;
		
		$query = ("INSERT INTO galerie VALUES ('".$galerie['id']."', '".$galerie['nazev']."', '".$galerie['popis']."', '".time()."', '0', '0', '', '0')");
		$sql_query = new db_dotaz($query);
		$sql_query->proved_dotaz();
		$sql_query = NULL;
		
		}
		else
		{
		$galerie['id']=$_POST['id'];
		//$galerie['path'] =("..\\gallery\\".$galerie['id']);
		//$galerie['path_thumbs'] =("..\\gallery\\".$galerie['id']."\\thumbs\\");
		$galerie['path'] =("../gallery/".$galerie['id']);
		$galerie['path_thumbs'] =("../gallery/".$galerie['id']."/thumbs/");
		$galerie['images_uploaded']=$_POST['images_uploaded'];
		}
		
		echo "<h2>Vytvoøit novou fotogalerii - Krok 2/3</h2>";
		
		if(isset($_POST['files_sent']))
		{
			
			$path = $galerie['path']."/";
			foreach ($_FILES["soubor"]["error"] as $key => $error)
			{
   				
				if ($error == UPLOAD_ERR_OK)
				{
       				if(move_uploaded_file($_FILES["soubor"]["tmp_name"][$key], $path.$_FILES["soubor"]["name"][$key]))
					{
						echo($_FILES['soubor']['name'][$key]." - <strong>OK</strong><br />");
						//echo $_POST['desc'][$key]."<br />";
						$picture['full_path'] = $path.$_FILES["soubor"]["name"][$key];
						$picture['thumb_path'] = $galerie['path_thumbs'].$_FILES["soubor"]["name"][$key];
						$this->createthumb($picture['full_path'],$picture['thumb_path'],120,120, TRUE);
						$this->createthumb($picture['full_path'],$picture['full_path'],550,550, FALSE);
						$galerie['images_uploaded']++;
						//$query = "INSERT INTO galerie_obrazky VALUES ('".$galerie['images_uploaded']."', '".$_FILES["soubor"]["name"][$key]."', '".$galerie['id']."', '".$_POST['desc'][$key]."', '".$_FILES["soubor"]["size"][$key]."', '0', '1')";
						$query = "INSERT INTO galerie_obrazky VALUES ('".$galerie['images_uploaded']."', '".$_FILES["soubor"]["name"][$key]."', '".$galerie['id']."', '', '".$_FILES["soubor"]["size"][$key]."', '0', '1')";
						$sql_query = new db_dotaz($query);
						$sql_query->proved_dotaz();
						$sql_query = NULL;
					}
					else
					{
						echo($_FILES['soubor']['name'][$key]." - <strong>Chyba pøenosu!</strong><br />");
					}
   				}
			}
		}
		
		echo "<h3>DO této kategorie již bylo nahráno ".$galerie['images_uploaded']." fotografií.</h3>";
		echo "<br />";
		echo "<form method='post' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' enctype='multipart/form-data'>";
			$this->add_file_input("soubor[]",'soubor_1',"Fotografie 1");
			//$this->add_text_input("desc[0]", desc_1, "Popis fotografie 1","", 50, 50);
			echo "<br />";
			$this->add_file_input("soubor[]",'soubor_2',"Fotografie 2");
			//$this->add_text_input("desc[]", 'desc_2', "Popis fotografie 2","", 50, 50);
			echo "<br />";
			$this->add_file_input("soubor[]",'soubor_3',"Fotografie 3");
			//$this->add_text_input("desc[]", desc_3, "Popis fotografie 3","", 50, 50);
			echo "<br />";
			$this->add_file_input("soubor[]",'soubor_4',"Fotografie 4");
			//$this->add_text_input("desc[]", desc_4, "Popis fotografie 4","", 50, 50);
			echo "<br />";
			$this->add_file_input("soubor[]",'soubor_5',"Fotografie 5");
			//$this->add_text_input("desc[]", desc_5, "Popis fotografie 5","", 50, 50);
			echo "<br />";
			$this->add_hidden_input("files_sent","1");
			$this->add_hidden_input("images_uploaded",$galerie['images_uploaded']);
			$this->add_hidden_input("id",$galerie['id']);
			$this->add_hidden_input("krok","1");
			$this->add_submit_button("Nahrát");
		echo "</form>";
		
		if($galerie['images_uploaded']>=3)
		{
		 	echo "<p><strong>Mùžete pokraèovat k vytvoøení galerie</strong></p>";
			echo "<form method='post' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' >";
				$this->add_hidden_input("krok","2");
				$this->add_hidden_input("images_uploaded",$galerie['images_uploaded']);
				$this->add_hidden_input("id",$galerie['id']);
				$this->add_submit_button("Pokraèovat");
			echo "</form>";
		}
		else
		{
			echo "<p><strong>Pro vytvoøení galerie je tøeba nahrát alespoò 3 fotografie</strong></p>";
		}
?>