<?php

#Get the parameters
$ini = parse_ini_file("repos.ini.php", true);

#The Subversion repository name is the section name in the ini file
$repo = $_REQUEST['repname'];

if (!array_key_exists($repo, $ini)) {
    $repo = "Default";
}

list($stupid, $branch, $path) = explode("/", $_REQUEST['path'], 3);

#Make the redirect permanent unless specified otherwise
if (!array_key_exists("temporary", $ini[$repo])) {
    http_response_code($ini[$repo]["permanent"] ?? 308);
}

if (isset($githubpath)) {
    #Construct the redirect header from the values in the ini file
    #It will look like this:
    #  https://github.com/{user}/{repo}/{githubpath}/{branch}/{path}
    # With branch default to master if it is not set in the ini file
    header("Location: https://github.com/".$ini[$repo]["user"]."/".$ini[$repo]["repo"]."/$githubpath/".($ini[$repo]["branch"] ?? "master")."/$path");
} else {
    #Link to the raw file
    #Construct the redirect header from the values in the ini file
    #It will look like this:
    #  https://raw.githubusercontent.com/{user}/{repo}/{branch}/{path}
    # With branch default to master
    header("Location: https://raw.githubusercontent.com/".$ini[$repo]["user"]."/".$ini[$repo]["repo"]."/".($ini[$repo]["branch"] ?? "master")."/$path");
}

?>
