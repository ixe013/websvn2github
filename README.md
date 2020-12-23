# websvn2github
A liteweight PHP application that redirects WebSVN links to a GitHub project. WebSVN was nice and it served me well. [It still exists](https://github.com/websvnphp/websvn), but I moved all of my projects to Git now.

It is a very minimal implementation that redirects requests in the WebSVN format to Github's URL format. Most of the traffic I got was from Google, folks searching for some obscure function that my code has. I wanted the link given by Google to send to the same file.

For example, this WebSVN URL:

```
http://src.paralint.com/filedetails.php?repname=Notifu&path=%2Ftrunk%2Fnotifu%2Fextern.h
```

Will redirect to 

```
https://github.com/ixe013/notifu/blob/master/notifu/extern.h
```


# Running it

Websvn2github is a PHP application. If you run WebSVN, you already have PHP setup. The files `filedetails.php` and `listing.php` in the original package are replaced with a script that parses the command line and builds a Github URL based on the values it finds in the URL and the ini file.

WebSVN requires PHP 5.6 or higher. I wrote this in about an hour, tested with HP 7.2.24-0ubuntu0.18.04.7. Open an issue if it does not work for you!


# Configuration

Set your own repositories in the file `repos.ini.php`. It is a standard PHP ini file, with each section name corresponding to the value you passed to WebSVN's addRepository.

For example, if you have this line in your WebSVN `include/config.php` file:

```
$config->addRepository('Notifu', 'file:///home/ixe013/svn/My-Notifu');
```

And Github's copy of the source accessible with at [https://github.com/ixe013/notifu](https://github.com/ixe013/notifu), then the ini section would look like this:

```
[Notifu]
user=ixe013
repo=notifu
```

A file named `dist-repos.ini.php` is available to get you started. Copy it to `repos.ini.php`.


## Options

Two optional settings are supported:

| name | purpose |
|------|---------|
| branch | Change the branch name, from `master` to `main` or `develop` |
| temporary | Set to `true` to return a 302 Temporary redirection instead of a 308 Permanent redirection |

Here is a working example that sends temporary redirects to the develop branch

```
[Notifu]
user=ixe013
repo=notifu
branch=develop
temporary=true
```

## Catch all

The code will look for a `Default` section where it will send any URL it can't parse. The default is to send the user to your profile homepage

```
[Default]
user=ixe013
repo=#
```
