<?php
		$kategorie = "simple";
		
			$css_class = "menu";
			if($this->akce=="")
			{
				$css_class = "menu_active";
			}
		
		echo "<menu class='block'>";
	 	echo "<li><a class='".$css_class."' href='".$this->root."/'>".$language['home-page'][$this->language]."</a></li>";
		echo "</menu>";
			echo "<menu class='block'>";
			$subkategorie = new db_dotaz("SELECT * FROM menu_subkategorie WHERE parent_url= '".$kategorie."' AND zobrazovat='ano' ORDER BY pozice asc");
			$subkategorie->proved_dotaz();
			while ($subzaznam=$subkategorie->get_vysledek()):
					//if($subzaznam['url']=='separator')
					//if(ereg('separator', $subzaznam['url']))
                    if(preg_match('/separator/', $subzaznam['url']))
					{
						
						echo "<li class='menu'><br /></li>";	
					}
					else
					{
					 	if($this->obsah==$subzaznam['url'])
					 	{
							$css_class = "menu_active";
						}
						else
						{
							$css_class = "menu";
						}
						
						if($this->language=="CZ")
						{
							if($subzaznam['typ']=='text')
							{
							echo "<li><a class='".$css_class."' href='".$this->root."/".$subzaznam['url'].".html'>".$subzaznam['nazev']."</a></li>";
							}
							elseif($subzaznam['typ']=='list')
							{
								if($this->kategorie==$subzaznam['url'])
								{
									$css_class = "menu_active";
								}
								echo "<li><a class='".$css_class."' href='".$this->root."/".$subzaznam['url']."/'>".$subzaznam['nazev']."</a></li>";
							}
						}
						else
						{
							$subkategorie_lang = new db_dotaz("SELECT * FROM menu_subkategorie_langs WHERE parent_id='".$subzaznam['url']."' AND jazyk='".$this->language."'");
							$subkategorie_lang->proved_dotaz();
							$subzaznam_lang = $subkategorie_lang->get_vysledek();	
							
							if($subzaznam['typ']=='text')
							{
							echo "<li><a class='".$css_class."' href='".$this->root."/".$subzaznam['url'].".html'>".$subzaznam_lang['nazev']."</a></li>";
							}
							elseif($subzaznam['typ']=='list')
							{
								echo "<li><a class='".$css_class."' href='".$this->root."/".$subzaznam['url']."/'>".$subzaznam_lang['nazev']."</a></li>";
							}
						}
						
					}
			endwhile;
			echo "</menu>";
		$kategorie = NULL;
		$subkategorie = NULL;
		$subkategorie_lang = NULL;
		
?>