<?php
# ================================================================================================= #
# SUBVERSION CLASS                                                                                  #
# ================================================================================================= #
# Author :  Tim Haselaars                                                                           #
# Company : Dynamix Solutions                                                                       #
# Contact:  timhaselaars@gmail.com                                                                  #                                                                                                     #
# Date:     3 October 2006                                                                          #                                                                                                     #
# Version:  1.00                                                                                    #                                                                                                     #
# ================================================================================================= #

// Error Handeling
error_reporting( E_ALL );

// include class file
require_once 'class.subversion.php';

// Class examples
$svn = new subversion();
$svn->getVersion(); // Get versiondir
$svn->getVersion('svnadmin'); // Get versiondir

//$svn->delete('test'); // Delete a repository xxx
//$svn->create('test'); // Create a repository yyy
//$svn->addFile( 'test', '/svn/svn_default'); // Add default directory structure
//$svn->addFile( 'test/design', '/test'); // Add all files in /test directory structure
//print_r($svn->status('test')); // Show status of repo test

//$svn->renameFile( 'test/design', 'test.txt','test2.txt'); // rename file from test to test2
//$svn->renameDir( 'test/design' , 'JOHN', 'JOHN2'); // rename dir from JOHN to JOHN2
//$svn->show('test/design'); //Show repository list

//$svn->updateFile('yyy', '/test'); // AddFiles from a directory to repo
//$svn->downloadFile('yyy/test',$_GET['file']);
?>
