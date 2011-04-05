<?php
# ================================================================================================= #
# SUBVERSION CLASS                                                                                  #
# ================================================================================================= #
# Author :  Tim Haselaars                                                                           #
# Company : Dynamix Solutions                                                                       #
# Contact:  timhaselaars@gmail.com                                                                  #                                                                                                     #
# Date:     10 October 2006                                                                          #                                                                                                     #
# Version:  1.01                                                                                    #                                                                                                     #
# ================================================================================================= #

class subversion
{
	/************************************************/
	/* Class variables
	 /************************************************/

	// General Variables
	var $path         = '/usr/bin/'; //Subversion bin location
	var $method_type  =  1; // 1 = FILE:// Method  || 2 = NETWORK (http://) Method || 3 = NETWORK (http://) + authentication Method
	var $method;
	var $repo         = '/home/grini/javgama/miweb'; // Repository location
	var $repo_tmp     = '/home/grini/javgama/tmp'; // Repository url
	var $repo_url     = 'http://192.*.*'; // Repository url
	var $repo_usr     = '***'; // Repository  htaccess login user ||  Necesairy with method_type = 3
	var $repo_psw     = '***'; // Repository htaccess login password ||  Necesairy with method_type = 3
	var $include      = 'export LD_PRELOAD=/usr/lib/libgdbm.so.2;'; // Incase of apache error just include this in shell_exec;
	var $windows = false;
	// Debug variables
	var $output_html  = true; // Output string as html
	var $debug        = true; // Show debug info
	var $apache_log   = '/usr/local/apache2/logs/error_log'; // Apache error log location

	function error($numero,$texto){
		$ddf = fopen('/home/grini/javgama/tmp/error.log','a');
		fwrite($ddf,"\r\n[".date("r")."] Error: ".$texto);
		fclose($ddf);
	}



	/************************************************/
	/* Constructor
	 /************************************************/
	function subversion()
	{
		//empty constructor

		// Set Method
		$this->setMethod();

	}

	/************************************************/
	/* Subversion Functions
	 /************************************************/

	//<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>//
	//<<<<<<<<< Repository Functions >>>>>>>>>//
	//<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>//

	# Create repository function
	function create($_repo) {
		$cmd  = ''.$this->path.'svnadmin create '.$this->repo.'/'.$_repo.';';
		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Rename repository function
	function rename($_repo_src, $_repo_dest) {
		$cmd  = 'mv '.$this->repo.'/'.$_repo_src.' '.$this->repo.'/'.$_repo_dest.';';
		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}


	# Delete repository function
	function delete($_repo) {
		$cmd  = 'rm -Rf '.$this->repo.'/'.$_repo.';';
		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Show info repository
	function info($_repo) {
		$cmd  = 'svn info ; ';
		$cmd  = $this->showRepo($_repo, $cmd );
		$info = exec($cmd, $_array, $_return);
		$this->cleanUpTmp(); // Clean up temp repo

		if ($_return == 0)
		{
			if (count($_array) > 0)
			{
				return $_array;
			} else {
				return $_array[0] = 'No info for '.$_repo.' available';
			}
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Show status repository
	function status($_repo) {
		$cmd  = 'svn info ; ';
		$cmd  = $this->showRepo($_repo, $cmd );
		$info = exec($cmd, $_array, $_return);
		$this->cleanUpTmp(); // Clean up temp repo
		$this->error('005',$cmd);
		$this->error('005',implode(",", $_array));
		$this->error('005',$_return);
		if ($_return == 0)
		{
			if (count($_array) > 0)
			{
				return $_array;
			} else {
				return $_array[0] = 'No status info for '.$_repo.' available';
			}
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Checkout local repository to a location
	function checkout($_repo, $_location = '') {
		if (empty($_location))
		{
			$_location = $this->repo_tmp;
		}
		$cmd  = ''.$this->path.'svn checkout '.$this->method.$this->repo.'/'.$_repo.' '.$_location.$this->repo.'/'.$_repo.'; '; // Checkout repo to tmp map
		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	//<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>//
	//<<< Repository Files & Dir Functions >>>//
	//<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>//

	# Add Files from a Directory to a repository
	function addFile($_repo, $_dir) {
		$cmd .= 'cd '.$this->repo_tmp.'; '; // Go to temp repo
		$cmd  = 'svn import '.$_dir.' '.$this->method.$this->repo.'/'.$_repo.' -m \'a\'';
		$this->error('005',$cmd);
		$info = exec($cmd, $_array, $_return);
		$this->error('005',implode(",",$_array));
		$this->error('005',$_return);
		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}



	# Update Files from a Directory to a repository
	function updateFile($_repo, $_dir) {
		if ($this->windows) {
			$_cmd  = 'copy /Y '.$_dir.' D:\\tmp';
		} else {
			$_cmd  = 'cp -f '.$_dir.'/* '.$this->repo_tmp.'/'.$_repo.'; '; //Copy file from tmp location to repo
		}
		$cmd  = $this->workRepo($_repo, $_cmd, 'Commited a file');

		$info = exec($cmd, $_array, $_return);
		$this->error('001',$_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Rename Files in a repository
	function renameFile($_repo, $_src, $_dest) {
		$cmd = ''.$this->path.'svn rename '.$_src.' '.$_dest.' ; ';
		$cmd = $this->workRepo($_repo, $cmd, 'Rename a file');

		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Delete File in a repository
	function deleteFile($_repo, $_file) {
		$cmd = ''.$this->path.'svn rm '.$_file.' ; ';
		$cmd = $this->workRepo($_repo, $cmd, 'Delete a file');

		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Download File
	function downloadFile($_repo, $_file)
	{
		$_cmd  = '';
		$cmd  = $this->showRepo($_repo, $_cmd );

		$info = exec($cmd, $_array, $_return);

		if ($_return == 0)
		{
			// <<<<<<< Send to browser for download <<<<<<< //
			$fname = ''.$this->repo_tmp.'/'.$_repo.'/'.$_file;
			header("Content-Type: application/octet-stream; name=\"".$_file."\"");
			header("Content-Disposition: inline; filename=\"".$_file."\"");
			$fh=fopen($fname, "rb");
			fpassthru($fh);
			@unlink($fname);
			$this->cleanUpTmp(); // Clean up temp repo

		} else {
			//echo $this->cleanUp($this->getError());
		}
	}


	# Make a directory in a repository
	function addDir($_repo, $_dir) {
		$cmd = ''.$this->path.'svn mkdir  '.$_dir.' ; ';
		$cmd = $this->workRepo($_repo, $cmd, 'Add a directory');

		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Rename Directory in a repository
	function renameDir($_repo, $_src, $_dest) {
		$cmd = ''.$this->path.'svn rename '.$_src.' '.$_dest.' ; ';
		$cmd = $this->workRepo($_repo, $cmd, 'Rename a directory');

		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# Delete Dir in a repository
	function deleteDir($_repo, $_dir) {
		$cmd = ''.$this->path.'svn rm '.$_dir.' ; ';
		$cmd = $this->workRepo($_repo, $cmd, 'Delete a directory');

		$info = exec($cmd, $_array, $_return);

		if ($_return == 0 && $this->debug ==  false)
		{
			return true;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# List repository files function
	# $_args = -v (print extra info) or $_args = -R (descend resursively)
	# Default no args
	function show($_repo , $_args = '') {
		$cmd  = ''.$this->path.'svn ls '.$_args.' '.$this->method.$this->repo.'/'.$_repo;
		$info = exec($cmd, $_array, $_return);

		if ($_return == 0)
		{
			return $_array;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	function showExtra($_repo) {
		$cmd  = ''.$this->path.'svn ls -v '.$this->method.$this->repo.'/'.$_repo.';';
		$info = exec($cmd, $_array, $_return);
		$arr = array();

		if ($_return == 0)
		{
			$i = 0;
			foreach ($_array as $val)
			{
				$element = '';
				// If $val is file or directory
				if ($this->isDir($val) == false)
				{
					//$val is file, add size val to array
					$tmp = preg_replace("§(\040)+§iS",'#',$val);
					$_val = (explode('#',trim($tmp,'#')));
					$arr[$i]['type'] = 'FILE';
					$arr[$i]['rev'] = $_val[0];
					$arr[$i]['user'] = $_val[1];
					$arr[$i]['size'] = $_val[2];
					$arr[$i]['date'] = $_val[3].' '.$_val[4].' '.$_val[5];
					for ($count = 6; $count <= count($_val); $count++)
					{
						$element .= $_val[$count].' ';
					}
					$arr[$i]['element'] = $element;
				} else {
					//$val is directory
					$tmp = preg_replace("§(\040)+§iS",'#',$val);
					$_val = (explode('#',trim($tmp,'#')));
					$arr[$i]['type'] = 'DIRECTORY';
					$arr[$i]['rev'] = $_val[0];
					$arr[$i]['user'] = $_val[1];
					$arr[$i]['date'] = $_val[2].' '.$_val[3].' '.$_val[4];
					for ($count = 5; $count <= count($_val); $count++)
					{
						$element .= $_val[$count].' ';
					}
					$arr[$i]['element'] = $element;
				}
				$i++;
			}
			return $arr;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# List repository files in a tree lay-out function
	function showTree($_repo) {
		$cmd  = ''.$this->path.'svnlook tree '.$this->repo.'/'.$_repo.';';
		$info = exec($cmd, $_array, $_return);

		if ($_return == 0)
		{
			return $_array;
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	# List repository files function
	function showSubversion() {
		// create a handler for the directory
		$handler = opendir($this->repo);
		while ($file = readdir($handler)) {
			// if $file isn't this directory or its parent,
			// add it to the results array
			if ($file != '.' && $file != '..' && substr($file,0,1) != '.' && is_dir($this->repo.'/'.$file))
			$_array[] = $file;
		}
		closedir($handler);
		sort($_array);
		return $_array;
	}

	# Show files or directories
	function showFiles($_array)
	{
		if (count($_array) > 0)
		{
			foreach ($_array as $val)
			{
				if ($this->isDir($val) == true)
				{
					echo 'DIRE :'.$val.'<br>';
				} else {
					echo 'FILE :'.$val.'<br>';
				}
			}
		} else {
			echo 'No files found<br>';
		}
	}

	# Work with tmp copy of repository
	function workRepo($_repo, $_cmd, $_comment = 'Commit changed File')
	{

		$cmd  = 'rm -Rf '.$this->repo_tmp.'; '; // Clean up temp repo
		$cmd .= ''.$this->path.'svn checkout '.$this->method.$this->repo.'/'.$_repo.' '.$this->repo_tmp.'; '; // Checkout repo to tmp map
		$cmd .= 'cd '.$this->repo_tmp.'; '; // Go to temp repo
		$cmd .= $_cmd ; // Execute command
		$cmd .= ''.$this->path.'svn commit -m "'.$_comment.'" ; '; // Commit change to repo
		$cmd .= 'rm -Rf '.$this->repo_tmp.'; '; // Clean up temp repo
		$this->error('001',$cmd);
		return $cmd;
	}

	# Show with tmp copy of repository
	function showRepo($_repo, $_cmd)
	{
		$cmd  = 'rm -Rf '.$this->repo_tmp.'; '; // Clean up temp repo
		$cmd .= ''.$this->path.'svn checkout '.$this->method.$this->repo.'/'.$_repo.' '.$this->repo_tmp.'; '; // Checkout repo to tmp map
		$cmd .= 'cd '.$this->repo_tmp.'; '; // Go to temp repo
		$cmd .= $_cmd ; // Execute command

		return $cmd;
	}

	/************************************************/
	/* Setters
	 /************************************************/
	# set repository method
	function setMethod() {
		if ($this->method_type == 1 or empty($this->method_type))
		{
			$this->method_type = 1;
			$this->method = ' file://';
		} elseif ($this->method_type == 2) {
			$this->method_type = 2;
			if (!empty($this->repo_url))
			{
				$this->method = $this->repo_url;
			} else {
				die('<br>Please set the URL of the remote repository, (set var $repo_url, example http://www.test.be)');
			}
		} else {
			if (!empty($this->repo_usr))
			{
				if (!empty($this->repo_usr) and !empty($this->repo_psw) )
				{
					$this->method = ' --username '.$this->repo_usr.' --password '.$this->repo_psw.' '.$this->repo_url;
				} else {
					die('<br>Please set the correct username and password for the remote repository, (set var $repo_usr and repo_psw)');
				}
			} else {
				die('<br>Please set the URL of the remote repository, (set var $repo_url, example http://www.test.be)');
			}
		}
	}

	/************************************************/
	/* Getters
	 /************************************************/
	# Get the svn version
	function getVersion($_str = 'svn') {
		$cmd  = ''.$this->path.$_str.' --version;';
		$info = shell_exec($cmd);

		if (!empty($info))
		{
			echo $this->cleanUp($info);
		} else {
			echo $this->cleanUp($this->getError());
		}
	}

	/************************************************/
	/* Functions
	 /************************************************/
	# Clean up the output string
	function cleanUp($string) {
		$_string = trim($string);
		if ($this->output_html == true)
		{
			$string = nl2br($_string);
		}

		return  '<br>'.$string.'<br>';
	}

	# Clean up the tmp dir
	function cleanUpTmp() {
		$cmd = 'rm -Rf  '.$this->repo_tmp.'; '; // Clean up temp repo
		shell_exec($cmd);
	}


	# Get apache error
	function getError() {
		return  shell_exec('tail -n 1 '.$this->apache_log.';');
	}

	# is Directory ?
	function isDir($_val) {
		return (substr($_val,- 1) == "/") ? true : false;
	}

}// End Class