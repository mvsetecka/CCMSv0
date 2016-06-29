<?php
	require('admin-security.php');
	echo "<h2>Úvodní strana</h3>";
	echo "<h3>Pøihlášen jako: ".$_SESSION['user']."</h3>";
	echo "<h3>Poèet dotazù na databázi MySQL: ".$this->get_settings('mysql_queries')."</h3>";
    
    
    if(file_exists('../install/index.php') or file_exists('../install/install-script.php'))
	{
			echo('<h4>Detekován adresáø \install</h4>');
            
            
            delDir('../install/CSS/');
            delDir('../install');
            
            echo('<h4>Adresáø \install automaticky odstranìn</h4>');
            
            
   }
   
   
        function delDir($dirName)
            {
                
                if(file_exists($dirName))
                {
                    $dir = dir($dirName);
                        while($file = $dir->read())
                        {
                            if($file != '.' && $file != '..')
                            {
                                if(is_dir($dirName.'/'.$file))
                                {
                                    delDir($dirName.'/'.$file);
                                } else {
                                @unlink($dirName.'/'.$file) or die('File '.$dirName.'/'.$file.' couldn\'t be deleted!');
                                }
                            }
                        }
                    @rmdir($dirName.'/'.$file) or die('Folder '.$dirName.'/'.$file.' couldn\'t be deleted!');
                } else {
                    echo 'Folder "<b>'.$dirName.'</b>" doesn\'t exist.';
                }   
	       }
        
    
?>