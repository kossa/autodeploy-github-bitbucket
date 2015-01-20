# Autodeploy-github-bitbucket
A simple PHP script to auto deploy from **Github** and **Bitbucket**, and executing a command after git pull like "composer install"...

###Installation :

0. Very simple, Download `deploy.php` file and put it in the root of your code directory. If you're working with **Bitbucket**, uncomment line 12 and comment line 9, otherwise keep it.
0. Create a new repo on **Github** or **Bitbucket**, and push all your code.
0. Add the SSH key of your server to **Github** or **Bitbucket**, *I had a problem with this when I added the default SSH key, so if you have the same problem, generate a SSH key for www-data using : `sudo -u www-data ssh-keygen -t rsa`*
 Add the public key  to your repo, for **Github** goto : https://github.com/user/repo/settings/keys, click on "Add deploy key" button. for **Bitbucket**, goto : https://bitbucket.org/user/repo/admin/deploy-keys, click on "Add key" button. 
0. In your server, clone the repo from **Github** or **Bitbucket** : 
`git clone git@github.com:user/repo.git`
0. Change the chown of your repo on your server using : `chown -R your_user:www-data repo`, may you should use sudo ;)
0. Also may you should check the chmod of files and folders files => 644, folders => 755.
0. Add a hook to **Github** or **Bitbucket**  :
  * **Github** : goto `https://github.com/user/repo/settings/hooks/new`, in "Payload URL" put the url to *deploy.php* from your server click on "Add webhook" button ![alt text](http://i.imgur.com/9eOL0qp.png)
  * **Bitbucket**: goto https://bitbucket.org/user/repo/admin/hooks, select "POST" option in the select box, click on "Add hook", past your URL to deploy.php file and click on "save"  
![alt text](http://i.imgur.com/ePCZBkp.png )  

0. That's all!!, for the first time you should check the `git pull` works or not using `sudo -u www-data git pull`. if you get some errors like `error: cannot open .git/FETCH_HEAD: Permission denied` you should check the chmod of your ".git" folder. also for the first time you should add **Github** or **Bitbucket** to "know hosts" file in ".ssh" folder like this :
![alt text](http://i.imgur.com/RHLLHbe.png )  

When you commit and you push automatically to **Github** or **Bitbucket**, it sends a post request to `http://www.yourwebsite.com/deploy.php`, and this will execute a `git pull`

###For Laravel users
To avoid an route exception you need to disable Laravel routing for deploy route :
0. open public/.htaccess

1. add before the redirect trailing slashes rule
```
#Exclude directory deploy from rewriting eg "http://your_url/deploy/index.php"
RewriteRule ^(deploy) - [L]
```


###How to execute a command after the  `git pull` ?
Very simple, in your commit message include the command into a [], for example : `git commit -m "first commit [composer install]"`, when the server (*deploy.php*) detect the [] symbol, it extracts the text between[], and execute the command, ex : `composer install`.


###More things: 
- You can change the [] with an other symbol, to do it goto line 15 and change the '[' and ']' with the symbol you want to use, for example if you want to use {} instead [] the pattern will be `$pattern = '/\{(.*?)\}/';`
- You can secure your POST request using a key in the hook, for example add a key like `http://www.yourwebsite.com/deploy.php?key=123456` and the *deploy.php* file check the `key` variable, you can imagine other methods.
- This solution is inspired from [@jondavidjohn](https://twitter.com/jondavidjohn) in his article  [Git pull from a php script, not so simple.](http://jondavidjohn.com/git-pull-from-a-php-script-not-so-simple)
- If you have any problem, or contribution to this project, not hesitate [here](https://github.com/kossa/autodeploy-github-bitbucket/issues) ;)
